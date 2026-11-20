<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('pesertas')->cascadeOnDelete(); // One-to-Many
            $table->unsignedBigInteger('event_id')->index();  // referensi modul Event
            $table->unsignedBigInteger('tiket_id')->index();  // referensi modul Ticket
            $table->string('kode_tiket', 20)->unique();
            $table->unsignedSmallInteger('jumlah');
            $table->unsignedInteger('harga_satuan');
            $table->unsignedInteger('total');
            $table->string('status', 15)->default('lunas'); // lunas | dibatalkan
            // snapshot data saat pembelian (agar riwayat tetap utuh walau event/tiket berubah)
            $table->string('event_judul', 150);
            $table->string('tiket_nama', 100);
            $table->string('tiket_tipe', 15);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
