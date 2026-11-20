<?php

namespace App\Modules\Event\Database\Factories;

use App\Modules\Event\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        $nama = fake()->unique()->word();

        return ['nama' => ucfirst($nama), 'slug' => Str::slug($nama).'-'.fake()->unique()->numberBetween(1, 9999)];
    }
}
