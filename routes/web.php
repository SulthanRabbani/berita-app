<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{article}', [HomeController::class, 'show'])->name('article.show');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::post('/logout', [GoogleController::class, 'logout'])->name('auth.logout');
});

// Dashboard (protected route)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Article Management
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class, [
        'names' => [
            'index' => 'admin.articles.index',
            'create' => 'admin.articles.create',
            'store' => 'admin.articles.store',
            'show' => 'admin.articles.show',
            'edit' => 'admin.articles.edit',
            'update' => 'admin.articles.update',
            'destroy' => 'admin.articles.destroy',
        ]
    ]);

    // Image upload for WYSIWYG editor
    Route::post('/articles/upload-image', [App\Http\Controllers\Admin\ArticleController::class, 'uploadImage'])
        ->name('admin.articles.upload-image');
});

// Login page route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
