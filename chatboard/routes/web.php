<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage for everyone, showing latest posts
Route::get('/', [PostController::class, 'index'])->name('home');

// Search route
Route::get('/search', [SearchController::class, 'handleSearch'])->name('search');

// Tag-specific posts route
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

// Dashboard for logged-in users
Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require authentication
Route::middleware('auth')->group(function () {
    // Profile routes from Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post resource routes (excluding index which is public)
    Route::resource('posts', PostController::class)->except(['index']);

    // Comments store route (nested under posts)
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
});

require __DIR__.'/auth.php';