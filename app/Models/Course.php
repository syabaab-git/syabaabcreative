<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'course_category_id', 'mentor_id', 'thumbnail', 'title', 'slug', 'description', 'price', 'level', 'rating', 'students_count', 'is_published',
    ];
    protected $casts = [
        'is_published' => 'boolean',
        'rating' => 'decimal:2',
    ];
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function courseFiles()
    {
        return $this->hasMany(\App\Models\CourseFile::class);
    }
}