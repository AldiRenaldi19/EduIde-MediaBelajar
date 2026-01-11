<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['course_id', 'title', 'slug', 'content', 'order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
