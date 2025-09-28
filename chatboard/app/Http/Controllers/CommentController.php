<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('comments', 'public');
        }

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'image' => $path,
        ]);

        return back()->with('success', 'Comment added!');
    }
}
