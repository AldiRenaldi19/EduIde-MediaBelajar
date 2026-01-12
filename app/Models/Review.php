<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Mass Assignment Protection
     * Menentukan kolom mana saja yang boleh diisi secara massal.
     */
    protected $fillable = [
        'name',
        'job',
        'message',
        'rating',
    ];
}
