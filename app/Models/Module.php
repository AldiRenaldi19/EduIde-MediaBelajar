<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['course_id', 'title', 'slug', 'content', 'order', 'video_url', 'content_type', 'content_url', 'attachment_mime', 'thumbnail'];

    protected $casts = [
        // keep content as string/text
    ];

    /**
     * Accessor untuk Thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        $thumb = trim($this->thumbnail);

        if (filter_var($thumb, FILTER_VALIDATE_URL)) {
            return $thumb;
        }

        if (!empty($thumb)) {
            $cloudName = env('CLOUDINARY_CLOUD_NAME', '');
            $cleanPath = ltrim($thumb, '/');
            if (\Illuminate\Support\Str::contains($cleanPath, 'upload/')) {
                $parts = explode('upload/', $cleanPath);
                $cleanPath = end($parts);
            }
            return "https://res.cloudinary.com/{$cloudName}/image/upload/f_auto,q_auto/{$cleanPath}";
        }

        return 'https://placehold.co/600x400/1a1a2e/ffffff?text=Module';
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
