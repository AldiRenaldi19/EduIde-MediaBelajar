<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'thumbnail',
        'description',
        'price',
        'level',
        'is_published'
    ];

    /**
     * Accessor untuk Thumbnail URL
     * Cara pakai di Blade: {{ $course->thumbnail_url }}
     */
    public function getThumbnailUrlAttribute(): string
    {
        $thumb = trim($this->thumbnail);

        // 1. Jika sudah berupa URL penuh (misal: link eksternal)
        if (filter_var($thumb, FILTER_VALIDATE_URL)) {
            return $thumb;
        }

        // 2. Jika ada nama file/path, arahkan ke Cloudinary
        if (!empty($thumb)) {
            $cloudName = env('CLOUDINARY_CLOUD_NAME', '');

            // Bersihkan path agar tidak terjadi double '/' atau double 'upload/'
            $cleanPath = ltrim($thumb, '/');
            if (Str::contains($cleanPath, 'upload/')) {
                $parts = explode('upload/', $cleanPath);
                $cleanPath = end($parts);
            }

            return "https://res.cloudinary.com/{$cloudName}/image/upload/f_auto,q_auto/{$cleanPath}";
        }

        // 3. Fallback jika data kosong
        return 'https://placehold.co/600x400/1a1a2e/ffffff?text=No+Image';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order', 'asc');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }
}
