<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\loginKing;
use App\Http\Controllers\pemainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/game', GameController::class)->middleware('auth:sanctum'); //untuk membuat agar hanya bisa diakses pleh orang yang hanya memiliki token/sudah login
Route::apiResource('/login', loginKing::class);
Route::get('/logout', [loginKing::class, 'logout'])->middleware('auth:sanctum'); //perlu middleware untuk mendefinisikan user()
Route::apiResource('/register', loginKing::class);
Route::apiResource('/pengguna', pemainController::class);
