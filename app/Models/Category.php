<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Category extends Model
{
    protected $fillable = ['name'];

    protected static function booted()
    {
        // Event yang dijalankan sebelum kategori dihapus
        static::deleting(function ($category) {
            // Hapus semua gambar Cloudinary dari post yang terkait
            foreach ($category->posts as $post) {
                if ($post->image_public_id) {
                    try {
                        Cloudinary::uploadApi()->destroy($post->image_public_id);
                        Log::info("Cloudinary image deleted from category deletion: " . $post->image_public_id);
                    } catch (\Exception $e) {
                        Log::error("Cloudinary delete error (category): " . $e->getMessage());
                    }
                }
            }
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
