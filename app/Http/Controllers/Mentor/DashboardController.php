<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $mentorId = auth()->id();

        // Top Statistics
        $totalCourses = Course::where('mentor_id', $mentorId)->count();
        
        $totalStudents = Enrollment::whereHas('course', function($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->distinct('user_id')->count('user_id');

        $averageRating = Course::where('mentor_id', $mentorId)->avg('rating') ?? 0;

        // Tab Navigation & Filters
        $activeTab = $request->query('tab', 'kelas');
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'latest');

        // Data for 'Kelas Saya' tab
        $coursesQuery = Course::withCount('enrollments')
            ->with(['category', 'lessons' => function($q) {
                $q->latest();
            }, 'assignments' => function($q) {
                $q->latest();
            }])
            ->where('mentor_id', $mentorId);

        // Data for 'Tugas' tab (Assuming Quiz Attempts as student tasks)
        $tasksQuery = \App\Models\AssignmentSubmission::with(['user', 'assignment.course'])
            ->whereHas('assignment.course', function($q) use ($mentorId) {
                $q->where('mentor_id', $mentorId);
            });

        // Search logic
        if (!empty($search)) {
            if ($activeTab === 'kelas') {
                $coursesQuery->where('title', 'like', "%{$search}%");
            } else {
                $tasksQuery->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('assignment', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            }
        }

        // Sort logic
        if ($activeTab === 'kelas') {
            switch ($sort) {
                case 'oldest': $coursesQuery->oldest(); break;
                case 'name_asc': $coursesQuery->orderBy('title', 'asc'); break;
                case 'name_desc': $coursesQuery->orderBy('title', 'desc'); break;
                case 'latest': default: $coursesQuery->latest(); break;
            }
        } else {
            switch ($sort) {
                case 'oldest': $tasksQuery->oldest(); break;
                case 'latest': default: $tasksQuery->latest(); break;
            }
        }

        $coursesList = $coursesQuery->paginate(10)->withQueryString();
        $tasksList = $tasksQuery->paginate(10)->withQueryString();

        // Stats for tabs
        $totalKelasTab = Course::where('mentor_id', $mentorId)->count();
        $totalTugasTab = \App\Models\AssignmentSubmission::whereHas('assignment.course', function($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->count();

        return view('mentor.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'averageRating',
            'activeTab',
            'coursesList',
            'tasksList',
            'totalKelasTab',
            'totalTugasTab'
        ));
    }
}
