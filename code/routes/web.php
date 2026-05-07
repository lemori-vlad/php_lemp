<?php

use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rooms/{roomId}/available-slots', [RoomsController::class, 'getAvailableSlots']);
