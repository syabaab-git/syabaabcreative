<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LearningController extends Controller
{
    public function show(Course $course)
    {
        $user = auth()->user();
        
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda belum terdaftar di kursus ini.');
        }

        $course->load(['lessons' => function ($query) {
            $query->where('is_archived', false)
                  ->where(function($q) {
                      $q->whereNull('scheduled_at')
                        ->orWhere('scheduled_at', '<=', now());
                  })->orderBy('sort_order');
        }]);

        $activeLessonId = request('lesson_id') ?? $course->lessons->first()?->id;
        $activeLesson = $activeLessonId ? $course->lessons->where('id', $activeLessonId)->first() : null;

        $completedLessonIds = LessonProgress::where('enrollment_id', $enrollment->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        $completedassignmentIds = \App\Models\AssignmentSubmission::where('user_id', $user->id)
            ->whereIn('assignment_id', $course->assignments->pluck('id'))
            ->whereColumn('score', '>=', 'passing_score') // Need to join assignment to get passing_score, or simpler: just get graded ones that passed
            ->join('assignments', 'assignment_submissions.assignment_id', '=', 'assignments.id')
            ->whereRaw('assignment_submissions.score >= assignments.passing_score')
            ->pluck('assignment_id')
            ->unique()
            ->toArray();

        return view('member.learning.show', compact('course', 'enrollment', 'activeLesson', 'completedLessonIds', 'completedassignmentIds'));
    }

    public function complete(Lesson $lesson)
    {
        $user = auth()->user();
        $course = $lesson->course;

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda belum terdaftar di kursus ini.');
        }

        $progress = LessonProgress::firstOrCreate(
            ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
            ['is_completed' => false]
        );

        if (!$progress->is_completed) {
            $progress->update([
                'is_completed' => true,
                'completed_at' => now()
            ]);

            // Recalculate progress
            $totalLessons = $course->lessons()->count();
            $completedLessons = LessonProgress::where('enrollment_id', $enrollment->id)
                ->where('is_completed', true)
                ->count();

            $percentage = $totalLessons > 0 ? (int)round(($completedLessons / $totalLessons) * 100) : 0;
            
            $enrollment->update([
                'progress' => $percentage,
                'completed_at' => $percentage === 100 ? now() : null,
            ]);

            // Generate certificate if 100% AND no quiz OR quiz already passed
            if ($percentage === 100) {
                // Update Leaderboard
                \App\Models\LeaderboardScore::recalculateForUser($user->id);

                $canGenerateCertificate = true;
                if ($course->assignments()->count() > 0) {
                    $passedAssignments = \App\Models\AssignmentSubmission::where('user_id', $user->id)
                        ->whereIn('assignment_id', $course->assignments->pluck('id'))
                        ->join('assignments', 'assignment_submissions.assignment_id', '=', 'assignments.id')
                        ->whereRaw('assignment_submissions.score >= assignments.passing_score')
                        ->count();
                        
                    if ($passedAssignments < $course->assignments()->count()) {
                        $canGenerateCertificate = false;
                    }
                }

                if ($canGenerateCertificate) {
                    Certificate::firstOrCreate(
                        ['user_id' => $user->id, 'course_id' => $course->id],
                        [
                            'certificate_number' => 'CERT-' . strtoupper(Str::random(10)),
                            'issued_at' => now(),
                        ]
                    );
                }
            }
        }

        // Find next lesson
        $nextLesson = $course->lessons()
            ->where('is_archived', false)
            ->where(function($q) {
                $q->whereNull('scheduled_at')
                  ->orWhere('scheduled_at', '<=', now());
            })
            ->where('sort_order', '>', $lesson->sort_order)
            ->orderBy('sort_order')
            ->first();

        if ($nextLesson) {
            return redirect()->route('member.learning.show', ['course' => $course->slug, 'lesson_id' => $nextLesson->id])
                ->with('success', 'Materi ditandai selesai.');
        }

        // Semua materi selesai — redirect ke halaman sukses
        return redirect()->route('member.learning.completed', $course->slug)
            ->with('course_completed', true);
    }

    public function completed(Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            abort(403, 'Anda belum terdaftar di kursus ini.');
        }

        // Hanya bisa diakses jika progress 100%
        if ($enrollment->progress < 100) {
            return redirect()->route('member.learning.show', $course->slug);
        }

        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        return view('member.learning.completed', compact('course', 'enrollment', 'certificate'));
    }
}
