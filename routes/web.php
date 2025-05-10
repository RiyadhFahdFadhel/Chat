<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function (){
    Route::get('/users', [MessageController::class, 'index'])->name('users');
    Route::get('/chat/{receiverId}', [MessageController::class, 'chat'])->name('chat');
    Route::post('/chat/{receiverId}/send', [MessageController::class, 'sendMessage']);
    Route::post('/chat/typing', [MessageController::class, 'typing']);
    Route::post('/online', [MessageController::class, 'setOnline']);
    Route::post('/offline', [MessageController::class, 'setOffline']);
});

