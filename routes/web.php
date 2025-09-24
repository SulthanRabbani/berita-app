<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{article}', [HomeController::class, 'show'])->name('article.show');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category.show');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Comment routes (require authentication)
Route::post('/article/{article}/comment', [CommentController::class, 'store'])
    ->name('comment.store')
    ->middleware('auth');
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
    ->name('comment.destroy')
    ->middleware('auth');

// Bookmark routes (require authentication)
Route::post('/article/{article}/bookmark', [BookmarkController::class, 'toggle'])
    ->name('bookmark.toggle')
    ->middleware('auth');
Route::get('/bookmarks', [BookmarkController::class, 'index'])
    ->name('bookmarks.index')
    ->middleware('auth');

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

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('user.profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('user.profile.password');
    Route::get('/profile/articles', [UserController::class, 'articles'])->name('user.articles');
    Route::get('/profile/comments', [UserController::class, 'comments'])->name('user.comments');
    Route::get('/user/{user}', [UserController::class, 'profile'])->name('user.show');
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
