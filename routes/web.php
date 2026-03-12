<?php

use App\Http\Controllers\loginKing;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [loginKing::class, 'login']);
Route::post('/register', [loginKing::class, 'register']);

