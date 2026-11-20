<?php

use App\Modules\Event\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth:sanctum', 'role:admin'])
    ->prefix('admin/events')
    ->name('admin.events.')
    ->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EventController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::put('/{id}', [EventController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [EventController::class, 'destroy'])->whereNumber('id')->name('destroy');
    });
