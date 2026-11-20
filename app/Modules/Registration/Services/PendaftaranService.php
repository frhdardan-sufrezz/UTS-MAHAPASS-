<?php

namespace App\Modules\Registration\Services;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Registration\Events\PendaftaranDibatalkan;
use App\Modules\Registration\Exceptions\TiketMahasiswaException;
use App\Modules\Registration\Models\KodeTiket;
use App\Modules\Registration\Models\Pendaftaran;
use App\Modules\Registration\Models\Peserta;
use App\Modules\Ticket\Contracts\TicketServiceInterface;
use App\Modules\Registration\Exceptions\TiketTidakDitemukanException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Orkestrator pembelian tiket. Berbicara dengan modul Event & Ticket
 * HANYA lewat Contract (interface), tidak menyentuh model/tabel mereka.
 */
class PendaftaranService
{
    public function __construct(
        private TicketServiceInterface $tickets,
        private EventServiceInterface $events,
    ) {
    }

    public function beli(int $userId, int $tiketId, int $jumlah): Pendaftaran
    {
        $peserta = Peserta::where('user_id', $userId)->firstOrFail();

        $tiket = $this->tickets->find($tiketId) ?? throw new TiketTidakDitemukanException();
        $event = $this->events->find($tiket['event_id']);

        if (! $event || $event['status'] !== 'published' || $event['selesai']->isPast()) {
            throw ValidationException::withMessages(['tiket_id' => 'Event ini belum dibuka atau sudah selesai.']);
        }

        $mahasiswa = $tiket['tipe'] === 'mahasiswa';
        if ($mahasiswa && $jumlah > 1) {
            throw TiketMahasiswaException::maksimalSatu();
        }

        return DB::transaction(function () use ($peserta, $tiket, $event, $jumlah) {
            // 1) kurangi kuota secara atomik -> bisa melempar KuotaPenuhException (rollback otomatis)
            $this->tickets->reserve($tiket['id'], $jumlah);

            $pendaftaran = Pendaftaran::create([
                'peserta_id' => $peserta->id,
                'event_id' => $event['id'],
                'tiket_id' => $tiket['id'],
                'kode_tiket' => $this->generateKode(),
                'jumlah' => $jumlah,
                'harga_satuan' => $tiket['harga'],
                'total' => $tiket['harga'] * $jumlah,
                'status' => Pendaftaran::LUNAS, // pembayaran disimulasikan langsung lunas
                'event_judul' => $event['judul'],
                'tiket_nama' => $tiket['nama'],
                'tiket_tipe' => $tiket['tipe'],
            ]);

            // 2) satu kode unik untuk setiap lembar tiket
            for ($i = 0; $i < $jumlah; $i++) {
                $pendaftaran->kodes()->create(['kode' => $this->generateKodeTiket()]);
            }

            return $pendaftaran->load('kodes');
        });
    }

    public function batalkan(int $pendaftaranId, int $userId, bool $isAdmin = false): Pendaftaran
    {
        $pendaftaran = Pendaftaran::with('peserta')->findOrFail($pendaftaranId);

        if (! $isAdmin && $pendaftaran->peserta->user_id !== $userId) {
            abort(403, 'Anda hanya dapat membatalkan pendaftaran milik Anda sendiri.');
        }
        if ($pendaftaran->status !== Pendaftaran::LUNAS) {
            throw ValidationException::withMessages(['pendaftaran' => 'Pendaftaran ini sudah dibatalkan sebelumnya.']);
        }

        DB::transaction(function () use ($pendaftaran) {
            $pendaftaran->update(['status' => Pendaftaran::DIBATALKAN]);
            event(new PendaftaranDibatalkan($pendaftaran->id, $pendaftaran->tiket_id, $pendaftaran->jumlah));
        });

        return $pendaftaran->refresh();
    }

    public function riwayat(int $userId): LengthAwarePaginator
    {
        $pesertaId = Peserta::where('user_id', $userId)->value('id');

        return Pendaftaran::with('kodes')->where('peserta_id', $pesertaId)->latest()->paginate(10);
    }

    public function semua(?string $cari = null): LengthAwarePaginator
    {
        return Pendaftaran::with(['peserta', 'kodes'])
            ->when($cari, fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('kode_tiket', 'like', "%{$cari}%")
                    ->orWhereHas('kodes', fn ($k) => $k->where('kode', 'like', "%{$cari}%"))
                    ->orWhere('tiket_nama', 'like', "%{$cari}%")
                    ->orWhere('event_judul', 'like', "%{$cari}%");
            }))
            ->latest()->paginate(15);
    }

    private function generateKodeTiket(): string
    {
        do {
            $kode = 'TKT-'.strtoupper(Str::random(8));
        } while (KodeTiket::where('kode', $kode)->exists());

        return $kode;
    }

    private function generateKode(): string
    {
        do {
            $kode = 'MHP-'.strtoupper(Str::random(8));
        } while (Pendaftaran::where('kode_tiket', $kode)->exists());

        return $kode;
    }
}
