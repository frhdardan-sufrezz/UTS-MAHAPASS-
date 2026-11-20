<?php

namespace App\Modules\Auth\Database\Seeders;

use App\Models\User;
use App\Modules\Auth\Events\UserTerdaftar;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Organizer',
            'email' => 'admin@mahapass.test',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $kampus = ['AMIKOM Yogyakarta', 'UII', 'UTY', 'UMY', 'UAD'];

        $peserta = [['Farhat Peserta', 'peserta@mahapass.test']];
        for ($i = 1; $i <= 5; $i++) {
            $peserta[] = [fake()->name(), "peserta{$i}@mahapass.test"];
        }

        foreach ($peserta as [$nama, $email]) {
            $user = User::factory()->create([
                'name' => $nama,
                'email' => $email,
                'password' => 'password',
                'role' => User::ROLE_PESERTA,
            ]);

            // Domain Event -> modul Registration yang membuat profil Peserta
            event(new UserTerdaftar($user->id, $user->name, fake()->randomElement($kampus)));
        }
    }
}
