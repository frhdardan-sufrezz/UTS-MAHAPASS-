<?php

namespace App\Modules\Registration\Database\Factories;

use App\Modules\Registration\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesertaFactory extends Factory
{
    protected $model = Peserta::class;

    public function definition(): array
    {
        return [
            'user_id' => fake()->unique()->numberBetween(10000, 99999),
            'nama' => fake()->name(),
            'kampus' => fake()->randomElement(['AMIKOM Yogyakarta', 'UII', 'UTY', 'UMY', 'UAD']),
            'no_hp' => fake()->numerify('08##########'),
        ];
    }
}
