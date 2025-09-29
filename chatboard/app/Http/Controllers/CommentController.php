<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
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

    /**
     * Show the form for editing the comment.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment->update($validated);

        return redirect()
            ->route('posts.show', $comment->post)
            ->with('success', 'Comment updated!');
    }

    /**
     * Delete the comment.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        // ลบรูปถ้ามี
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()
            ->route('posts.show', $postId)
            ->with('success', 'Comment deleted!');
    }
}
