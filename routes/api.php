<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\loginKing;
use App\Http\Controllers\pemainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// route game sebagai pemain
Route::get('/game/{slug}', [GameController::class, 'show'])->middleware('auth:sanctum'); //untuk membuat agar hanya bisa diakses pleh orang yang hanya memiliki token/sudah login

// route game sebagai developer
Route::post('/game', [GameController::class, 'store'])->middleware('auth:sanctum'); //auth gate dilakukan dalam controller saja
Route::get('/game', [GameController::class, 'index'])->middleware('auth:sanctum');


Route::put('/login/{id}', [loginKing::class, 'update'])->middleware('auth:sanctum');
Route::apiResource('/login', loginKing::class);
Route::get('/logout', [loginKing::class, 'logout'])->middleware('auth:sanctum'); //perlu middleware untuk mendefinisikan user()
Route::apiResource('/register', loginKing::class);
Route::apiResource('/pengguna', pemainController::class);
