<?php
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// This route returns all posts as JSON.
// In a real app, you would use API resources and Sanctum for authentication.
Route::get('/posts', function() {
    return Post::with(['user:id,name', 'tags:id,name'])->latest()->get();
});
