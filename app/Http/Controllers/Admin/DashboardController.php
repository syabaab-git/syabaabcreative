<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;

        // Total pesanan selesai dan pendapatan bulan ini
        $completedOrdersThisMonth = Order::where('status', 'completed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $revenueThisMonth = \App\Models\FinanceTransaction::where('type', 'income')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        // Data Grafik Bulanan (Jan - Des)
        $monthlyOrderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyOrderData[] = Order::where('status', 'completed')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', $currentYear)
                ->count();
        }

        // Data Grafik Mingguan (Bulan ini)
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
        $weeklyOrderData = [];
        $weeklyLabels = [];
        $currentWeekStart = $startOfMonth->copy();
        $weekCount = 1;

        while ($currentWeekStart <= $endOfMonth) {
            $currentWeekEnd = $currentWeekStart->copy()->addDays(6)->endOfDay();
            if ($currentWeekEnd > $endOfMonth) {
                $currentWeekEnd = $endOfMonth->copy();
            }

            $weeklyOrderData[] = Order::where('status', 'completed')
                ->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
                ->count();
            
            $weeklyLabels[] = "Minggu " . $weekCount;
            $currentWeekStart = $currentWeekEnd->copy()->addDay()->startOfDay();
            $weekCount++;
        }
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'adminUsers' => User::whereHas('roles', function ($q) {
                $q->where('name', 'super-admin');
            })->count(),

            'activeCourses' => Course::where('is_published', true)->count(),
            'activeStudents' => \App\Models\Enrollment::where('status', 'approved')->count(),
            'activeMentors' => User::whereHas('roles', function($q) {
                $q->where('name', 'mentor');
            })->count(),
            
            'activeServices' => Service::where('is_active', true)->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            
            'totalPortfolios' => Portfolio::count(),
            'totalTestimonials' => Testimonial::count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'totalRevenue' => \App\Models\FinanceTransaction::where('type', 'income')->sum('amount'),
            'recentOrders' => Order::latest()->take(5)->get(),
            'onlineUsersCount' => \DB::table('sessions')
                ->where('last_activity', '>', time() - 300)
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count('user_id'),
            'onlineUsers' => User::with('roles')->whereIn('id', function($query) {
                $query->select('user_id')
                    ->from('sessions')
                    ->where('last_activity', '>', time() - 300)
                    ->whereNotNull('user_id');
            })->take(15)->get(),
            'pendingEnrollments' => \App\Models\Enrollment::with(['user', 'course'])->where('status', 'pending')->orderBy('created_at', 'desc')->get(),
            
            'completedOrdersThisMonth' => $completedOrdersThisMonth,
            'revenueThisMonth' => $revenueThisMonth,
            'monthlyOrderData' => json_encode($monthlyOrderData),
            'weeklyOrderData' => json_encode($weeklyOrderData),
            'weeklyLabels' => json_encode($weeklyLabels),
        ]);
    }

    public function onlineUsers()
    {
        $threshold = time() - 300; // 5 minutes

        $onlineUsers = User::with('roles')->whereIn('id', function($query) use ($threshold) {
            $query->select('user_id')
                ->from('sessions')
                ->where('last_activity', '>', $threshold)
                ->whereNotNull('user_id');
        })->get(['id', 'name', 'avatar', 'email']);

        $formattedUsers = $onlineUsers->map(function($user) {
            $roleName = $user->roles->first()?->name;
            $roleLabel = match($roleName) {
                'super-admin' => 'Admin',
                'mentor' => 'Mentor',
                'agency-staff' => 'Staff',
                'member' => 'Member',
                default => 'User'
            };

            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
                'initial' => strtoupper(substr($user->name, 0, 1)),
                'role' => $roleLabel,
            ];
        });

        return response()->json([
            'count' => $formattedUsers->count(),
            'users' => $formattedUsers
        ]);
    }
}
