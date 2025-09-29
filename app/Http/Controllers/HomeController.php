<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('home_featured_posts', 3600, function () { // cache 1 jam
            return Post::with([
                'category:id,name',
                'user:id,name'
            ])
                ->select('id', 'title', 'image_url', 'image_public_id', 'text', 'category_id', 'user_id', 'created_at', 'updated_at')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
        });

        return view('welcome', compact('posts'));
    }
}
