<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');

            $uploadResult = Cloudinary::uploadApi()->upload($uploadedFile->getRealPath(), [
                'folder' => 'posts_images',
            ]);

            $data['image_url'] = $uploadResult['secure_url'];
            $data['image_public_id'] = $uploadResult['public_id'];
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);

        $previousPost = Post::where('created_at', '<', $post->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        $nextPost = Post::where('created_at', '>', $post->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
    }

    public function edit(Post $post)
    {
        if (!$this->canModifyPost($post)) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        if (!$this->canModifyPost($post)) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');

            // Hapus image lama di Cloudinary
            if ($post->image_public_id) {
                try {
                    Cloudinary::uploadApi()->destroy($post->image_public_id);
                } catch (\Exception $e) {
                    Log::error("Cloudinary delete error: " . $e->getMessage());
                }
            }

            // Upload file baru
            $uploadResult = Cloudinary::uploadApi()->upload($uploadedFile->getRealPath(), [
                'folder' => 'posts_images',
            ]);

            $data['image_url'] = $uploadResult['secure_url'];
            $data['image_public_id'] = $uploadResult['public_id'];
        } else {
            // Pertahankan image_url dan image_public_id lama jika tidak ada gambar baru
            $data['image_url'] = $post->image_url;
            $data['image_public_id'] = $post->image_public_id;
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (!$this->canModifyPost($post)) {
            abort(403, 'Unauthorized action.');
        }

        if ($post->image_public_id) {
            try {
                Cloudinary::uploadApi()->destroy($post->image_public_id);
            } catch (\Exception $e) {
                Log::error("Cloudinary delete error: " . $e->getMessage());
            }
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    /**
     * Helper method untuk mengecek authorization
     */
    private function canModifyPost(Post $post): bool
    {
        return $post->user_id === Auth::id() || Auth::user()->is_admin;
    }
}
