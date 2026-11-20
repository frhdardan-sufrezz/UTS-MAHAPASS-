<?php

namespace App\Modules\Ticket\Database\Seeders;

use App\Modules\Event\Contracts\EventServiceInterface;
use App\Modules\Ticket\Models\Tiket;
use Illuminate\Database\Seeder;

class TiketSeeder extends Seeder
{
    public function run(EventServiceInterface $events): void
    {
        $ids = $events->allIds();

        // id event diambil lewat Contract, bukan query langsung ke tabel/model Event
        foreach ($ids as $eventId) {
            // UI/UX Design Competition: HTM Rp10.000 sesuai poster (harga sama untuk umum & mahasiswa)
            $htm10k = str_contains($events->find($eventId)['judul'] ?? '', 'UI/UX');

            $umum = Tiket::factory()->umum()->create(['event_id' => $eventId] + ($htm10k ? ['harga' => 10000] : []));
            Tiket::factory()->mahasiswa()->create([
                'event_id' => $eventId,
                'harga' => $htm10k ? 10000 : (int) ($umum->harga * 0.6),
            ]);
        }

        // tiket dengan kuota hampir habis untuk menguji KuotaPenuhException
        if ($first = $ids[0] ?? null) {
            Tiket::create(['event_id' => $first, 'nama' => 'Early Bird (terbatas)', 'tipe' => 'umum', 'harga' => 25000, 'kuota' => 3, 'terjual' => 2]);
        }
    }
}
