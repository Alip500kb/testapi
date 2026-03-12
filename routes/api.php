<?php

use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\loginKing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/game', GameController::class);
Route::apiResource('/login', loginKing::class);
Route::apiResource('/register', loginKing::class);
// Route::apiResource('/login', function (Request $request) {
//     return $request->user('pemains');
// })->middleware('auth:sanctum');
