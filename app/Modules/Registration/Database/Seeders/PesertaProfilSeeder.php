<?php

namespace App\Modules\Registration\Database\Seeders;

use App\Modules\Registration\Models\Peserta;
use Illuminate\Database\Seeder;

/**
 * Saat mendaftar, peserta tidak mengisi No. HP. Data ini dilengkapi
 * belakangan lewat menu Profil. Seeder ini meniru kondisi itu untuk data demo.
 */
class PesertaProfilSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Peserta::orderBy('id')->get() as $peserta) {
            $peserta->update([
                'no_hp' => fake()->numerify('08##########'),
            ]);
        }
    }
}
