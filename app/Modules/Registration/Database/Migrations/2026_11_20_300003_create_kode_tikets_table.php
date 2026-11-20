<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Satu pendaftaran (pesanan) punya banyak kode tiket: satu kode untuk tiap lembar tiket.
    public function up(): void
    {
        Schema::create('kode_tikets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete(); // One-to-Many
            $table->string('kode', 20)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kode_tikets');
    }
};
