<?php

namespace App\Modules\Ticket\Services;

use App\Modules\Ticket\Contracts\TicketServiceInterface;
use App\Modules\Ticket\Exceptions\KuotaPenuhException;
use App\Modules\Ticket\Exceptions\TiketTidakDitemukanException;
use App\Modules\Ticket\Models\Tiket;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TiketService implements TicketServiceInterface
{
    public function listByEvent(int $eventId): array
    {
        return Tiket::where('event_id', $eventId)->orderBy('harga')->get()
            ->map(fn (Tiket $t) => $this->toArray($t))->all();
    }

    public function find(int $tiketId): ?array
    {
        $tiket = Tiket::find($tiketId);

        return $tiket ? $this->toArray($tiket) : null;
    }

    public function hargaMulai(array $eventIds): array
    {
        return Tiket::whereIn('event_id', $eventIds)
            ->selectRaw('event_id, MIN(harga) as harga_min')
            ->groupBy('event_id')
            ->pluck('harga_min', 'event_id')
            ->map(fn ($h) => (int) $h)
            ->all();
    }

    public function reserve(int $tiketId, int $jumlah): array
    {
        return DB::transaction(function () use ($tiketId, $jumlah) {
            $tiket = Tiket::whereKey($tiketId)->lockForUpdate()->first();

            if (! $tiket) {
                throw new TiketTidakDitemukanException();
            }
            if ($tiket->sisa() < $jumlah) {
                throw new KuotaPenuhException($tiket->sisa());
            }

            $tiket->increment('terjual', $jumlah);

            return $this->toArray($tiket->refresh());
        });
    }

    public function release(int $tiketId, int $jumlah): void
    {
        DB::transaction(function () use ($tiketId, $jumlah) {
            $tiket = Tiket::whereKey($tiketId)->lockForUpdate()->first();
            if ($tiket) {
                $tiket->update(['terjual' => max(0, $tiket->terjual - $jumlah)]);
            }
        });
    }

    // ------- CRUD khusus admin (dipakai controller modul ini) -------

    public function create(int $eventId, array $data): array
    {
        return $this->toArray(Tiket::create($data + ['event_id' => $eventId, 'terjual' => 0]));
    }

    public function update(int $id, array $data): array
    {
        $tiket = Tiket::findOrFail($id);

        if ($data['kuota'] < $tiket->terjual) {
            throw ValidationException::withMessages([
                'kuota' => "Kuota tidak boleh lebih kecil dari tiket yang sudah terjual ({$tiket->terjual}).",
            ]);
        }

        $tiket->update($data);

        return $this->toArray($tiket);
    }

    public function delete(int $id): int
    {
        $tiket = Tiket::findOrFail($id);

        if ($tiket->terjual > 0) {
            throw ValidationException::withMessages([
                'tiket' => "Tiket \"{$tiket->nama}\" sudah terjual {$tiket->terjual} buah sehingga tidak bisa dihapus.",
            ]);
        }

        $eventId = $tiket->event_id;
        $tiket->delete();

        return $eventId;
    }

    public function hapusByEvent(int $eventId): void
    {
        Tiket::where('event_id', $eventId)->delete();
    }

    private function toArray(Tiket $t): array
    {
        return [
            'id' => $t->id,
            'event_id' => $t->event_id,
            'nama' => $t->nama,
            'tipe' => $t->tipe,
            'harga' => $t->harga,
            'kuota' => $t->kuota,
            'terjual' => $t->terjual,
            'sisa' => $t->sisa(),
        ];
    }
}
