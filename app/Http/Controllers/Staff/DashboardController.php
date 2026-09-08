<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Pesanan yang belum selesai
        $newOrders = \App\Models\Order::whereIn('status', ['pending', 'processing'])->count();
        
        // Proyek berjalan untuk staf ini
        $activeProjects = \App\Models\Project::where('staff_id', $userId)
            ->whereIn('status', ['pending', 'in_progress', 'review'])
            ->count();
            
        // Proyek selesai
        $completedProjects = \App\Models\Project::where('staff_id', $userId)
            ->where('status', 'completed')
            ->count();

        // 5 Pesanan terbaru
        $recentOrders = \App\Models\Order::with('service', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Proyek aktif dengan deadline terdekat
        $myProjects = \App\Models\Project::with('order.service')
            ->where('staff_id', $userId)
            ->whereIn('status', ['pending', 'in_progress', 'review'])
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'newOrders', 
            'activeProjects', 
            'completedProjects', 
            'recentOrders', 
            'myProjects'
        ));
    }
}
