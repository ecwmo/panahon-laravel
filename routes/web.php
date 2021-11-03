<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObservationsStationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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
    Route::get('/' . config('app.suburl'), [HomeController::class, 'index']); # workaround for subdirectory
}

Auth::routes();

Route::get('stations/data-table', [ObservationsStationController::class, 'table'])->name('stations.table');
Route::get('stations/{id}/logs', [ObservationsStationController::class, 'showLogs']);
Route::get('stations/{id}/data-logs', [ObservationsStationController::class, 'fetchLogs']);
Route::resource('/stations', ObservationsStationController::class)->except(['index', 'show'])->middleware(['auth', 'role:ADMIN']);
Route::resource('/stations', ObservationsStationController::class)->only(['index', 'show']);

Route::get('roles/data-table', [RoleController::class, 'table'])->name('roles.table');
Route::resource('/roles', RoleController::class)->except(['show'])->middleware(['auth', 'role:SUPERADMIN']);

Route::get('users/data-table', [UserController::class, 'table'])->name('users.table');
Route::resource('/users', UserController::class)->except(['show'])->middleware(['auth', 'role:SUPERADMIN']);
// Route('/users/data-table', 'UsersController@getUsersForDataTable')->name('users.table');
