<?php

use App\Http\Controllers\RoomsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/rooms/{roomId}/available-slots', [RoomsController::class, 'getAvailableSlots']);
Route::post('/rooms/{roomId}/reserve', [RoomsController::class, 'reserveSlot']);
