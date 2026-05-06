<?php

use App\Http\Controllers\HelloController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// just a test route
Route::get('/hello', [HelloController::class, 'supportedBranches']);
