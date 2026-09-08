<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Service;
use App\Models\User;
use App\Models\Order;
use App\Models\Project;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $courses = collect();
        $services = collect();
        $users = collect();
        $orders = collect();
        $projects = collect();

        if ($query) {
            $user = auth()->user();

            if (!$user) {
                // Visitor/Guest: Global Services and Courses
                $courses = Course::with('category', 'mentor')
                    ->where('is_published', true)
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();

                $services = Service::with('category')
                    ->where('is_active', true)
                    ->where(function($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();
            } else if ($user->hasRole('super-admin')) {
                // Admin: All Data
                $courses = Course::with('category', 'mentor')
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();
                    
                $services = Service::with('category')
                    ->where(function($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();
                    
                $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->get();
                    
                $orders = Order::where('order_number', 'like', "%{$query}%")
                    ->orWhere('customer_name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->get();
                    
                $projects = Project::where('title', 'like', "%{$query}%")
                    ->get();
                    
            } else if ($user->hasRole('agency-staff')) {
                // Staff: Only Agency Data
                $services = Service::with('category')
                    ->where(function($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();
                    
                $orders = Order::where('order_number', 'like', "%{$query}%")
                    ->orWhere('customer_name', 'like', "%{$query}%")
                    ->get();
                    
                $projects = Project::where('title', 'like', "%{$query}%")
                    ->get();
                    
            } else if ($user->hasRole('mentor')) {
                // Mentor: Only their Class Scope
                $courses = Course::with('category', 'mentor')
                    ->where('mentor_id', $user->id)
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();
                    
            } else {
                // Member: Only their Class Scope
                $courses = Course::with('category', 'mentor')
                    ->whereHas('enrollments', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->get();
            }
        }

        return view('front.search', compact('courses', 'services', 'users', 'orders', 'projects', 'query'));
    }
}
