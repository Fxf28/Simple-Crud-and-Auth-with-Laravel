<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * The "booted" method of the model.
     * Event yang dijalankan sebelum user dihapus
     */
    protected static function booted()
    {
        static::deleting(function ($user) {
            try {
                // Hapus semua gambar Cloudinary dari post yang dimiliki user
                foreach ($user->posts as $post) {
                    if ($post->image_public_id) {
                        Cloudinary::uploadApi()->destroy($post->image_public_id);
                        Log::info("Cloudinary image deleted from user deletion: " . $post->image_public_id);
                    }
                }

                Log::info("All Cloudinary images deleted for user: " . $user->id);
            } catch (\Exception $e) {
                Log::error("Cloudinary delete error during user deletion: " . $e->getMessage());
            }
        });

        // Optional: Event setelah user dihapus
        static::deleted(function ($user) {
            Log::info("User deleted successfully: " . $user->id);
        });
    }
}
