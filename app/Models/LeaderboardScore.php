<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'total_points',
        'quiz_avg_score',
        'courses_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function recalculateForUser($userId)
    {
        $leaderboard = self::firstOrCreate(
            ['user_id' => $userId, 'course_id' => null],
            ['total_points' => 0, 'quiz_avg_score' => 0, 'courses_completed' => 0]
        );

        // 1. Calculate Assignment Avg Score
        $avgScore = AssignmentSubmission::where('user_id', $userId)
            ->whereNotNull('score')
            ->avg('score') ?? 0;
        
        // 2. Calculate Courses Completed and Speed Bonus
        $enrollments = Enrollment::with('course.lessons')->where('user_id', $userId)->whereNotNull('completed_at')->get();
        $coursesCompleted = $enrollments->count();
        
        $speedBonus = 0;
        foreach ($enrollments as $enr) {
            if (!$enr->course) continue;
            $totalDuration = $enr->course->lessons->sum('duration_minutes');
            $timeTaken = $enr->completed_at->diffInMinutes($enr->created_at);
            
            if ($totalDuration > 0) {
                if ($timeTaken < ($totalDuration * 0.5)) {
                    $speedBonus += 50;
                } elseif ($timeTaken <= ($totalDuration * 0.75)) {
                    $speedBonus += 25;
                }
            }
        }

        $leaderboard->quiz_avg_score = $avgScore;
        $leaderboard->courses_completed = $coursesCompleted;
        $leaderboard->total_points = ($avgScore * 0.5) + ($coursesCompleted * 100) + $speedBonus;
        $leaderboard->save();

        return $leaderboard;
    }
}
