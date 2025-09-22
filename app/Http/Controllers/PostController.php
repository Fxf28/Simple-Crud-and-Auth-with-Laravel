<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')   // eager load category to avoid N+1 query
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        Post::create($request->validated());

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $previousPost = Post::where('created_at', '<', $post->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        $nextPost = Post::where('created_at', '>', $post->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->update($request->validated());

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
