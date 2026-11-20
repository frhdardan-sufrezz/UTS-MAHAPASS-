<?php

namespace App\Modules\Event\Database\Factories;

use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\Kampus;
use App\Modules\Event\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $mulai = fake()->dateTimeBetween('+3 days', '+60 days');

        return [
            'organizer_id' => Organizer::query()->inRandomOrder()->value('id') ?? Organizer::factory(),
            'kampus_id' => Kampus::query()->inRandomOrder()->value('id') ?? Kampus::factory(),
            'judul' => 'Event '.fake()->words(3, true),
            'deskripsi' => fake()->paragraphs(2, true),
            'lokasi' => fake()->randomElement(['Aula Utama', 'Gedung Serbaguna', 'Auditorium', 'Lapangan Kampus', 'Student Center']),
            'mulai' => $mulai,
            'selesai' => (clone $mulai)->modify('+4 hours'),
            'status' => 'published',
        ];
    }
}
