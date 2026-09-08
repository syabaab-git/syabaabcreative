<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = \App\Models\Course::with(['mentor', 'category'])
            ->where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('front.courses.index', compact('courses'));
    }

    public function show(\App\Models\Course $course)
    {
        if (!$course->is_published) {
            abort(404);
        }

        $course->load(['mentor', 'category', 'lessons' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        // Check if the authenticated user is enrolled
        $enrollment = null;
        if (auth()->check()) {
            $enrollment = \App\Models\Enrollment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->first();
        }

        return view('front.courses.show', compact('course', 'enrollment'));
    }
}
