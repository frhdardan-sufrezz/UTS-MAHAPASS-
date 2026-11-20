<?php

use App\Modules\Registration\Http\Controllers\KatalogController;
use App\Modules\Registration\Http\Controllers\PendaftaranController;
use App\Modules\Registration\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    // Publik
    Route::get('/', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/events/{id}', [KatalogController::class, 'show'])->whereNumber('id')->name('katalog.show');

    // Peserta
    Route::middleware(['auth:sanctum', 'role:peserta'])->group(function () {
        Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::get('/tiket-saya', [PendaftaranController::class, 'saya'])->name('tiket.saya');
        Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    });

    // Peserta (miliknya sendiri) & Admin (semua)
    Route::post('/pendaftaran/{id}/batal', [PendaftaranController::class, 'batal'])
        ->middleware(['auth:sanctum', 'role:peserta,admin'])->whereNumber('id')->name('pendaftaran.batal');

    // Admin
    Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin/pendaftaran', [PendaftaranController::class, 'admin'])
        ->name('admin.pendaftaran.index');
});
