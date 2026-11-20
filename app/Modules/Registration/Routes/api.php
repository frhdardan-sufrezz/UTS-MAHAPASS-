<?php

use App\Modules\Registration\Http\Controllers\KatalogController;
use App\Modules\Registration\Http\Controllers\PendaftaranController;
use App\Modules\Registration\Http\Controllers\ProfilController;
use App\Support\Http\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['api', ForceJsonResponse::class])->name('api.')->group(function () {
    // Publik
    Route::get('/events', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/events/{id}', [KatalogController::class, 'show'])->whereNumber('id')->name('katalog.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('role:peserta')->group(function () {
            Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
            Route::get('/pendaftaran/saya', [PendaftaranController::class, 'saya'])->name('pendaftaran.saya');
            Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
            Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
        });

        Route::post('/pendaftaran/{id}/batal', [PendaftaranController::class, 'batal'])
            ->middleware('role:peserta,admin')->whereNumber('id')->name('pendaftaran.batal');

        Route::get('/admin/pendaftaran', [PendaftaranController::class, 'admin'])
            ->middleware('role:admin')->name('admin.pendaftaran.index');
    });
});
