<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ObservationsStationController;
use App\Http\Controllers\API\GLabsController;
use App\Http\Controllers\API\GLabsLoadController;
use App\Http\Controllers\API\SMController;

Route::name('api.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::resource('stations', ObservationsStationController::class)->only(['index', 'show']);
    Route::get('/stations/{id}/logs', [ObservationsStationController::class, 'fetchLogs']);

    Route::get('/globelabs', [GLabsController::class, 'index'])->name('glabs.index');
    Route::post('/globelabs', [GLabsController::class, 'post'])->name('glabs.post');
    Route::post('/globelabs/load', [GLabsLoadController::class, 'post'])->name('glabs.load');

    Route::get('/sm', [SMController::class, 'index'])->name('sm.index');
    Route::post('/sm', [SMController::class, 'post'])->name('sm.post');

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('auth/user', [AuthController::class, 'userInfo']);
        Route::resource('station', ObservationsStationController::class)->except(['index', 'show']);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
});
