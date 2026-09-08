<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Course;
use App\Models\Certificate;
use App\Models\Order;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all testimonials of the user
        $testimonials = Testimonial::where('user_id', $user->id)->get()->keyBy(function($item) {
            return $item->course_id ? 'course_' . $item->course_id : 'service_' . $item->service_id;
        });
        
        // Get certificates (for course reviews)
        $certificates = Certificate::where('user_id', $user->id)->with('course')->get();
        
        // Get completed orders (for service reviews)
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('service')
            ->get();
            
        return view('member.testimonials.index', compact('testimonials', 'certificates', 'completedOrders'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required_without:service_id|nullable|exists:courses,id',
            'service_id' => 'required_without:course_id|nullable|exists:services,id',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:500',
        ]);

        $user = auth()->user();

        // Check if user already submitted a testimonial for this course or service
        $query = Testimonial::where('user_id', $user->id);
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        } else {
            $query->where('service_id', $request->service_id);
        }
        $existing = $query->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk layanan atau kursus ini.');
        }

        Testimonial::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'service_id' => $request->service_id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'role' => $request->filled('course_id') ? 'Siswa' : 'Klien',
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'is_featured' => true, // Auto-feature to show on landing page
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        if ($testimonial->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:500',
        ]);

        $testimonial->update([
            'rating' => $validated['rating'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Ulasan Anda berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== auth()->id()) {
            abort(403);
        }

        $testimonial->delete();

        return back()->with('success', 'Ulasan Anda berhasil dihapus.');
    }
}
