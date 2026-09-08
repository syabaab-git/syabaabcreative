<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    protected $fillable = [
        'enrollment_id', 'lesson_id', 'is_completed', 'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
