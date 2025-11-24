<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::get('/tweets/{tweet}/edit', [TweetController::class, 'edit'])->name('tweets.edit');
    Route::put('/tweets/{tweet}', [TweetController::class, 'update'])->name('tweets.update');
    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');
    // Profile edit/update routes (authenticated users only)
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/tweets/{tweet}/like', [LikeController::class, 'toggle'])->name('tweets.like');
});

// Public Routes
// Simple debug endpoint to inspect auth state (remove when finished)
Route::get('/_debug/auth', function () {
    return response()->json([
        'auth_check' => Auth::check(),
        'auth_id' => Auth::id(),
        'session_cookie' => request()->cookie(config('session.cookie')),
        'cookies_header' => request()->headers->get('cookie'),
    ]);
});

Route::get('/', [TweetController::class, 'index'])->name('home');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
