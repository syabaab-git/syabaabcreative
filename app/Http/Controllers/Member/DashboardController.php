<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\QuizAttempt;
use App\Models\LeaderboardScore;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $activeTab = $request->query('tab', 'kelas');
        $search = $request->query('search');
        $sort = $request->query('sort', 'latest');

        // Stats
        $enrolledCoursesCount = Enrollment::where('user_id', $user->id)->count();
        $certificatesCount = Certificate::where('user_id', $user->id)->count();
        $totalPoints = LeaderboardScore::where('user_id', $user->id)->value('score') ?? 0;

        // Get user's certificates and testimonials for courses
        $userCertificates = Certificate::where('user_id', $user->id)->get()->keyBy('course_id');
        $userTestimonials = Testimonial::where('user_id', $user->id)
            ->whereNotNull('course_id')
            ->get()
            ->keyBy('course_id');

        // --- TAB: KELAS ---
        $coursesQuery = Enrollment::with(['course.category', 'course.lessons', 'course.assignments'])
            ->where('user_id', $user->id);

        if ($search && $activeTab === 'kelas') {
            $coursesQuery->whereHas('course', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($sort === 'oldest' && $activeTab === 'kelas') {
            $coursesQuery->oldest('created_at');
        } elseif ($sort === 'name_asc' && $activeTab === 'kelas') {
            $coursesQuery->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->orderBy('courses.title', 'asc')
                ->select('enrollments.*');
        } elseif ($sort === 'name_desc' && $activeTab === 'kelas') {
            $coursesQuery->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->orderBy('courses.title', 'desc')
                ->select('enrollments.*');
        } else {
            $coursesQuery->latest('created_at'); // default: latest
        }

        $allCourses = $coursesQuery->get();
        $activeCourses = $allCourses->where('progress', '<', 100)->values();
        $completedCourses = $allCourses->where('progress', '>=', 100)->values();
        $totalKelasTab = $allCourses->count();

        // --- TAB: LAYANAN ---
        $ordersQuery = \App\Models\Order::with(['service', 'project'])
            ->where('user_id', $user->id);

        if ($search && $activeTab === 'layanan') {
            $ordersQuery->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('service', function($sq) use ($search) {
                      $sq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        if ($sort === 'oldest' && $activeTab === 'layanan') {
            $ordersQuery->oldest('created_at');
        } else {
            $ordersQuery->latest('created_at');
        }

        $allOrders = $ordersQuery->get();
        $activeOrders = $allOrders->whereNotIn('status', ['completed', 'cancelled'])->values();
        $completedOrders = $allOrders->whereIn('status', ['completed', 'cancelled'])->values();
        $totalLayananTab = $allOrders->count();

        // Count unread chat notifications for badge on Layanan Saya tab
        $unreadChatCount = $user->unreadNotifications
            ->filter(fn($n) => ($n->data['type'] ?? null) === 'chat')
            ->count();

        return view('member.dashboard', compact(
            'enrolledCoursesCount', 
            'certificatesCount', 
            'totalPoints', 
            'activeTab', 
            'activeCourses', 
            'completedCourses',
            'totalKelasTab', 
            'activeOrders',
            'completedOrders',
            'totalLayananTab',
            'unreadChatCount',
            'userCertificates',
            'userTestimonials'
        ));
    }
}
