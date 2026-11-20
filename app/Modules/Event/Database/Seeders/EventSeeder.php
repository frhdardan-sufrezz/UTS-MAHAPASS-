<?php

namespace App\Modules\Event\Database\Seeders;

use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\Kategori;
use App\Modules\Event\Models\Organizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // [judul, [kategori], organizer, lokasi, tanggal, jam mulai, poster, deskripsi singkat]
        // tanggal: angka = berapa hari dari sekarang, atau string 'Y-m-d' = tanggal pasti.
        $data = [
            [
                'Jogja Campus Fest 2026 - Konser Musik',
                ['Konser'],
                'Music Community Unisi',
                'Lapangan Utama UII',
                '2026-12-20',
                16,
                '/images/posters/ceremonasi.jpg',
                'Konser musik live antar kampus di Jogja. Nikmati penampilan band-band mahasiswa terbaik dalam satu panggung bersama Music Community Unisi.',
            ],
            [
                'UI/UX Design Competition',
                ['Lomba'],
                'AMCC Amikom',
                'Auditorium AMIKOM',
                '2026-12-27',
                9,
                '/images/posters/uiux.jpg',
                'Lomba desain UI/UX bertema FinTech & Kemudahan Finansial yang diselenggarakan oleh AMCC AMIKOM. Pendaftaran dibuka 20-26 Desember 2026, HTM Rp10.000.',
            ],
            [
                'Pesta Esport MLBB Jogja 2026',
                ['Lomba'],
                'E-Sport UTY',
                'Aula UTY',
                25,
                10,
                '/images/posters/mlbb.jpg',
                'Turnamen Mobile Legends antar mahasiswa Jogja. Kumpulkan timmu, bertanding, dan jadilah juara bersama E-Sport UTY.',
            ],
            [
                'UII Trail Run 2026',
                ['Lomba'],
                'MAPALA Unisi',
                'Kampus Terpadu UII',
                '2027-01-17',
                6,
                '/images/posters/trailrun.jpg',
                'Lomba lari trail bertema Run, Edu, Care dari MAPALA Unisi UII. Tersedia kategori 7K, 15K, 30K, 50K, dan 77K Relay.',
            ],
        ];

        foreach ($data as [$judul, $kategori, $organizerNama, $lokasi, $tanggal, $jam, $poster, $deskripsi]) {
            $organizer = Organizer::where('nama', $organizerNama)->first();

            if (! $organizer) {
                throw new \RuntimeException("Penyelenggara tidak ditemukan: '{$organizerNama}'");
            }
            $mulai = is_string($tanggal)
                ? Carbon::parse($tanggal)->setTime($jam, 0)
                : now()->addDays($tanggal)->setTime($jam, 0);

            $event = Event::factory()->create([
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'lokasi' => $lokasi,
                'poster_url' => $poster,
                'organizer_id' => $organizer->id,
                'kampus_id' => $organizer->kampus_id,
                'mulai' => $mulai,
                'selesai' => $mulai->copy()->addHours(5),
                'status' => 'published',
            ]);

            $event->kategoris()->attach(Kategori::whereIn('nama', $kategori)->pluck('id')->all());
        }
    }
}
