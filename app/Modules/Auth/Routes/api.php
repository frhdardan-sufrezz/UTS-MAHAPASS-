<?php

use App\Modules\Auth\Http\Controllers\AuthController;
use App\Support\Http\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware(['api', ForceJsonResponse::class])->name('api.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
    });
});
