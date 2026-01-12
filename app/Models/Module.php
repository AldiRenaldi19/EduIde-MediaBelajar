<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['course_id', 'title', 'slug', 'content', 'order', 'video_url', 'content_type', 'content_url', 'attachment_mime', 'thumbnail'];

    protected $casts = [
        // keep content as string/text
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
