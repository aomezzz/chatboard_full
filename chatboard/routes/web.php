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
| Routes สำหรับหน้าเว็บทั้งหมด
|
*/

// หน้า Home (แสดงโพสต์ล่าสุด)
Route::get('/', [PostController::class, 'index'])->name('home');

// ค้นหาโพสต์
Route::get('/search', [SearchController::class, 'handleSearch'])->name('search');

// โพสต์ตามแท็ก
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

// Dashboard (เฉพาะผู้ที่ล็อกอินแล้ว)
Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// กลุ่ม Route ที่ต้องล็อกอินก่อน
Route::middleware('auth')->group(function () {
    
    // Profile (จาก Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Route สำหรับ Post (ยกเว้น index เพราะอยู่ในหน้า public)
    Route::resource('posts', PostController::class)->except(['index']);

    // สร้างคอมเมนต์ใหม่สำหรับโพสต์
    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');

    // แก้ไข/อัปเดต/ลบ คอมเมนต์ (ต้องล็อกอินและมีสิทธิ์)
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Auth Routes จาก Laravel Breeze
require __DIR__.'/auth.php';