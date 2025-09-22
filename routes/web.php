<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

// Google OAuth Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Auth Routes
Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

// Dashboard (protected route)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Login page route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
