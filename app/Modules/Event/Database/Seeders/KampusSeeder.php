<?php

namespace App\Modules\Event\Database\Seeders;

use App\Modules\Event\Models\Kampus;
use Illuminate\Database\Seeder;

class KampusSeeder extends Seeder
{
    public function run(): void
    {
        // Kampus penyelenggara event (UII, AMIKOM, UTY)
        $data = [
            ['Universitas Islam Indonesia', 'UII', 'Sleman'],
            ['Universitas AMIKOM Yogyakarta', 'AMIKOM', 'Sleman'],
            ['Universitas Teknologi Yogyakarta', 'UTY', 'Sleman'],
        ];

        foreach ($data as [$nama, $singkatan, $kota]) {
            Kampus::updateOrCreate(['singkatan' => $singkatan], ['nama' => $nama, 'kota' => $kota]);
        }
    }
}
