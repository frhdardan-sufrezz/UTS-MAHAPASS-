<?php

use App\Modules\Ticket\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth:sanctum', 'role:admin'])
    ->prefix('admin')
    ->name('admin.tiket.')
    ->group(function () {
        Route::get('/events/{eventId}/tiket', [TiketController::class, 'index'])->whereNumber('eventId')->name('index');
        Route::post('/events/{eventId}/tiket', [TiketController::class, 'store'])->whereNumber('eventId')->name('store');
        Route::get('/tiket/{id}/edit', [TiketController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::put('/tiket/{id}', [TiketController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/tiket/{id}', [TiketController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });
