<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('organizers')->restrictOnDelete(); // One-to-Many
            $table->foreignId('kampus_id')->constrained('kampus')->restrictOnDelete();        // One-to-Many
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('lokasi', 150);
            $table->string('poster_url', 500)->nullable(); // opsional: URL gambar poster
            $table->dateTime('mulai');
            $table->dateTime('selesai');
            $table->string('status', 15)->default('draft')->index(); // draft | published
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
