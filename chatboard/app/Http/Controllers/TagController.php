<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()->with('user', 'tags')->latest()->get();
        return view('dashboard', ['posts' => $posts, 'tag' => $tag]);
    }
}
