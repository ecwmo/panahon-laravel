<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SIMCardController;
use App\Http\Controllers\ObservationsStationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('stations', ObservationsStationController::class)->except(['index', 'show']);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::post('/simcard', [SIMCardController::class, 'post'])->name('simcard.post');
});

Route::resource('stations', ObservationsStationController::class)->only(['index', 'show']);
Route::get('/stations/{station}/logs', [ObservationsStationController::class, 'logs'])->name('station.logs');

Route::get('/simcard', [SIMCardController::class, 'index'])->name('simcard.index');

require __DIR__.'/auth.php';
