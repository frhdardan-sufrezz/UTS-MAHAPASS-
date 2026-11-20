<?php

namespace Database\Seeders;

use App\Modules\Auth\Database\Seeders\UserSeeder;
use App\Modules\Event\Database\Seeders\EventSeeder;
use App\Modules\Event\Database\Seeders\KampusSeeder;
use App\Modules\Event\Database\Seeders\KategoriSeeder;
use App\Modules\Event\Database\Seeders\OrganizerSeeder;
use App\Modules\Registration\Database\Seeders\PesertaProfilSeeder;
use App\Modules\Ticket\Database\Seeders\TiketSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,      // admin + peserta (memicu Domain Event UserTerdaftar)
            PesertaProfilSeeder::class, // No. HP demo (dilengkapi lewat profil, bukan saat daftar)
            KampusSeeder::class,
            KategoriSeeder::class,
            OrganizerSeeder::class,
            EventSeeder::class,
            TiketSeeder::class,     // membaca event lewat Contract, bukan model Event
        ]);
    }
}
