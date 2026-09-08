<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Testimonial extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'service_id', 'name', 'avatar', 'role', 'message', 'rating', 'is_featured',
    ];
    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}