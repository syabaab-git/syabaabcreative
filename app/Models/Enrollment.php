<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Enrollment extends Model
{
    protected $fillable = ['user_id', 'course_id', 'progress', 'completed_at', 'status'];
    protected $casts = [
        'completed_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function booted()
    {
        static::created(function ($enrollment) {
            // Find all admins and super-admins
            $admins = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'super-admin']);
            })->get();

            foreach ($admins as $admin) {
                try {
                    $admin->notify(new \App\Notifications\NewEnrollmentNotification($enrollment));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to notify admin of new enrollment: " . $e->getMessage());
                }
            }
        });
    }
}