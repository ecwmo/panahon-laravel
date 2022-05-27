<?php

use Illuminate\Support\Facades\Route;

Route::view('/{any}', 'home')
    ->middleware(['auth'])
    ->where('any', '.*');
