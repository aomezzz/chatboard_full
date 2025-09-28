<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function handleSearch(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('home');
        }

        // Search for posts where the body contains the query
        // OR where the post has a tag whose name contains the query.
        $posts = Post::with(['user', 'tags'])
            ->where('body', 'LIKE', "%{$query}%")
            ->orWhereHas('tags', function ($tagQuery) use ($query) {
                $tagQuery->where('name', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->paginate(15);

        return view('search.results', [
            'posts' => $posts,
            'query' => $query,
        ]);
    }
}