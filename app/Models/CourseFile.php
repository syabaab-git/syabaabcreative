<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CourseFile extends Model
{
    protected $fillable = [
        'course_id',
        'name',
        'file_path',
        'size',
        'mime_type',
        'scope',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getSizeFormattedAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return number_format($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
