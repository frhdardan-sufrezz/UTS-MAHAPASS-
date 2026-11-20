<?php

use App\Modules\Ticket\Http\Controllers\TiketController;
use App\Support\Http\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('api/admin')
    ->middleware(['api', ForceJsonResponse::class, 'auth:sanctum', 'role:admin'])
    ->name('api.admin.tiket.')
    ->group(function () {
        Route::get('/events/{eventId}/tiket', [TiketController::class, 'index'])->whereNumber('eventId')->name('index');
        Route::post('/events/{eventId}/tiket', [TiketController::class, 'store'])->whereNumber('eventId')->name('store');
        Route::put('/tiket/{id}', [TiketController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/tiket/{id}', [TiketController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });
