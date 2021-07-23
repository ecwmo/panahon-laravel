<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ObservationsStationController;
use App\Http\Controllers\API\GLabsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::get('user', [AuthController::class, 'userInfo']);
});

Route::get('station', [ObservationsStationController::class, 'index']);
Route::get('station/{id}', [ObservationsStationController::class, 'show']);


// Route::get('station/latest/observation', [ObservationsStationController::class, 'fetchLatestObservations']);
Route::get('station/{id}/observation', [ObservationsStationController::class, 'fetchObservations']);

Route::get('globelabs', [GLabsController::class, 'index']);
Route::post('globelabs', [GLabsController::class, 'post']);
