<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Post extends Model
{
    protected $fillable = [
        'title',
        'image_url',
        'image_public_id',
        'text',
        'category_id'
    ];

    protected static function booted()
    {
        // Event yang dijalankan sebelum post dihapus
        static::deleting(function ($post) {
            // Hapus gambar dari Cloudinary
            if ($post->image_public_id) {
                try {
                    Cloudinary::uploadApi()->destroy($post->image_public_id);
                    Log::info("Cloudinary image deleted: " . $post->image_public_id);
                } catch (\Exception $e) {
                    Log::error("Cloudinary delete error: " . $e->getMessage());
                }
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
