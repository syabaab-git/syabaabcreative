<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Portfolio;
use App\Models\Setting;

class LandingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('front.landing', [
            'settings' => $settings,

            'popularCourses' => Course::with('mentor', 'category')
                ->where('is_published', true)
                ->latest()
                ->take(3)
                ->get(),

            'services' => Service::with('category')
                ->where('is_active', true)
                ->take(3)
                ->get(),

            'testimonials' => Testimonial::where('is_featured', true)
                ->latest()
                ->take(6)
                ->get(),

            'portfolios' => Portfolio::where('is_featured', true)
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }
}
