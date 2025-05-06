<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated'], 401);
})->name('login');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/chat', function () {
    return view('chat');
})->middleware('auth');
