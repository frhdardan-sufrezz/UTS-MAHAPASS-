<?php

namespace App\Modules\Event\Database\Seeders;

use App\Modules\Event\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Konser', 'Lomba'] as $nama) {
            Kategori::updateOrCreate(['slug' => Str::slug($nama)], ['nama' => $nama]);
        }
    }
}
