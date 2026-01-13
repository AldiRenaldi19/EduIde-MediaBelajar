<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleCompletion extends Model
{
    protected $fillable = ['user_id', 'module_id', 'course_id'];

    // Tidak perlu timestamps jika hanya butuh created_at, tapi defaultnya true
}
