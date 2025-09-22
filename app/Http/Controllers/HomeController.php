<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Eager load categories to avoid N+1 query
        $posts = Post::with('category')->orderBy('created_at', 'desc')->get();

        return view('welcome', compact('posts'));
    }
}
