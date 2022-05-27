<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ObservationsStationController;
use App\Http\Controllers\API\GLabsController;
use App\Http\Controllers\API\GLabsLoadController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('stations/{id}/logs', [ObservationsStationController::class, 'fetchLogs']);
Route::resource('stations', ObservationsStationController::class)->only(['index', 'show']);
Route::middleware('auth:api')->group(function () {
    Route::get('auth/user', [AuthController::class, 'userInfo']);
    Route::resource('stations', ObservationsStationController::class)->except(['index', 'show']);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

Route::get('globelabs', [GLabsController::class, 'index']);
Route::post('globelabs', [GLabsController::class, 'post']);

Route::post('globelabs/load', [GLabsLoadController::class, 'post']);
