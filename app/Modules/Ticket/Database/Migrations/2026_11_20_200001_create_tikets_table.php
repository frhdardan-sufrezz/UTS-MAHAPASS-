<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            // Sengaja tanpa foreign key ke tabel events: tabel modul Event tidak boleh diakses langsung.
            $table->unsignedBigInteger('event_id')->index();
            $table->string('nama', 100);
            $table->string('tipe', 15)->default('umum'); // umum | mahasiswa
            $table->unsignedInteger('harga')->default(0);
            $table->unsignedInteger('kuota');
            $table->unsignedInteger('terjual')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
