<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'description',
        'price',
        'level',
        'is_published'
    ];

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
        // Menggunakan tabel 'enrollments' sesuai keinginanmu
        return $this->belongsToMany(User::class, 'enrollments');
    }
}
