<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // เพิ่ม 'comments.user' เพื่อโหลดคอมเมนต์และเจ้าของคอมเมนต์มาด้วย
        $posts = Post::with(['user', 'tags', 'comments.user'])
            ->latest()
            ->paginate(10); // ลดจำนวนลงเล็กน้อยเพราะต้องแสดงคอมเมนต์ด้วย
            
        return view('dashboard', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     * เพิ่มเมธอดนี้เข้ามาใหม่
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'tags' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = $request->user()->posts()->create([
            'body' => $validated['body'],
            'image' => $imagePath,
        ]);

        if (!empty($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', $validated['tags']));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if ($tagName) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);
        }

        // เปลี่ยนจาก route('home') เป็น route('dashboard') หรือตามที่เหมาะสม
        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('comments.user', 'user', 'tags');
        return view('posts.show', ['post' => $post]);
    }
}