<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

$subURL = config('misc.suburl');
if ($subURL != '') {
    $subURL = "{$subURL}/";
} else {
    $subURL = "/";
}

Route::get($subURL, [HomeController::class, 'index'])->name('home');

Route::view('/{any?}', 'home')
    ->where('any', '.*');
