<?php

namespace App\Modules\Event\Database\Factories;

use App\Modules\Event\Models\Kampus;
use Illuminate\Database\Eloquent\Factories\Factory;

class KampusFactory extends Factory
{
    protected $model = Kampus::class;

    public function definition(): array
    {
        return [
            'nama' => 'Universitas '.fake()->unique()->lastName(),
            'singkatan' => strtoupper(fake()->unique()->lexify('???')),
            'kota' => fake()->randomElement(['Yogyakarta', 'Sleman', 'Bantul']),
        ];
    }
}
