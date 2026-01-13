<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ModuleCompletion;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'started_at',
        'completed_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check apakah enrollment ini sudah completed
     */
    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    /**
     * Get progress persentase
     */
    public function getProgress(): float
    {
        if ($this->course->modules->isEmpty()) {
            return 0;
        }

        $totalModules = $this->course->modules()->count();
        $completedModules = ModuleCompletion::where('user_id', $this->user_id)
            ->where('course_id', $this->course_id)
            ->count();

        return $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
    }
}
