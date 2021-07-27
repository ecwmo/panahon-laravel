<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
if (config('app.suburl') != '') {
    Route::get('/'.config('app.suburl'), [HomeController::class, 'index']); # workaround for subdirectory
}

Auth::routes();

Route::resource('/stations', ObservationsStationController::class)->except(['index', 'show'])->middleware(['auth','role:ADMIN']);
Route::resource('/stations', ObservationsStationController::class)->only(['index', 'show']);

