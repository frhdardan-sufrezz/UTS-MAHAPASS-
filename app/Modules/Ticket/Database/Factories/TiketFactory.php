<?php

namespace App\Modules\Ticket\Database\Factories;

use App\Modules\Ticket\Models\Tiket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TiketFactory extends Factory
{
    protected $model = Tiket::class;

    public function definition(): array
    {
        return [
            'event_id' => 1, // di-override oleh seeder dengan id dari EventServiceInterface
            'nama' => 'Tiket Umum',
            'tipe' => Tiket::TIPE_UMUM,
            'harga' => fake()->randomElement([50000, 75000, 100000, 150000]),
            'kuota' => fake()->numberBetween(50, 200),
            'terjual' => 0,
        ];
    }

    public function umum(): static
    {
        return $this->state(fn () => ['nama' => 'Tiket Umum', 'tipe' => Tiket::TIPE_UMUM]);
    }

    public function mahasiswa(): static
    {
        return $this->state(fn (array $attrs) => [
            'nama' => 'Tiket Mahasiswa',
            'tipe' => Tiket::TIPE_MAHASISWA,
            'harga' => (int) ($attrs['harga'] * 0.6),
            'kuota' => fake()->numberBetween(20, 80),
        ]);
    }
}
