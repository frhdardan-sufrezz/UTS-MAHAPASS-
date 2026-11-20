<?php

namespace App\Modules\Event\Database\Seeders;

use App\Modules\Event\Models\Kampus;
use App\Modules\Event\Models\Organizer;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Music Community Unisi', 'UKM', 'UII'],
            ['AMCC Amikom', 'Komunitas', 'AMIKOM'],
            ['E-Sport UTY', 'Komunitas', 'UTY'],
            ['MAPALA Unisi', 'Komunitas', 'UII'],
        ];

        foreach ($data as [$nama, $jenis, $kampus]) {
            Organizer::create(['nama' => $nama, 'jenis' => $jenis, 'kampus_id' => Kampus::where('singkatan', $kampus)->value('id')]);
        }
    }
}
