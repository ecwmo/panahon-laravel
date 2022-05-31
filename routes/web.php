<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

$baseURL = config('app.base_url');
if ($baseURL != '') {
    $baseURL = "{$baseURL}/";
} else {
    $baseURL = "/";
}

Route::get($baseURL, [HomeController::class, 'index'])->name('home');

Route::view('/{any?}', 'home')
    ->where('any', '.*');
