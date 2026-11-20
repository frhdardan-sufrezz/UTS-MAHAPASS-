<?php

namespace App\Modules\Event\Database\Factories;

use App\Modules\Event\Models\Kampus;
use App\Modules\Event\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizerFactory extends Factory
{
    protected $model = Organizer::class;

    public function definition(): array
    {
        $jenis = fake()->randomElement(Organizer::JENIS);

        return [
            'nama' => $jenis.' '.fake()->randomElement(['Informatika', 'Teknik', 'Ekonomi', 'Seni', 'Musik', 'Fotografi', 'Robotika']),
            'jenis' => $jenis,
            'kampus_id' => Kampus::query()->inRandomOrder()->value('id') ?? Kampus::factory(),
        ];
    }
}
