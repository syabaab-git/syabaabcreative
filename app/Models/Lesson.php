<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lesson extends Model
{
    protected $fillable = [
        'course_id', 'title', 'body', 'duration_minutes', 'sort_order', 'is_preview', 'scheduled_at',
        'description', 'links', 'attachments', 'is_archived',
    ];
    protected $casts = [
        'is_preview' => 'boolean',
        'is_archived' => 'boolean',
        'scheduled_at' => 'datetime',
        'links' => 'array',
        'attachments' => 'array',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}