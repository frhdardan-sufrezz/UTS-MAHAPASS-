<?php

use App\Modules\Event\Http\Controllers\EventController;
use App\Support\Http\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('api/admin/events')
    ->middleware(['api', ForceJsonResponse::class, 'auth:sanctum', 'role:admin'])
    ->name('api.admin.events.')
    ->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{id}', [EventController::class, 'show'])->whereNumber('id')->name('show');
        Route::put('/{id}', [EventController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [EventController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });
