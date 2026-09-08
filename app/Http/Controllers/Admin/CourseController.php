<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'kelas');
        $search = $request->query('search');
        $sort = $request->query('sort', 'latest');

        // Course Query
        $courseQuery = Course::with(['category', 'mentor']);
        if ($activeTab === 'kelas') {
            if ($search) $courseQuery->where('title', 'like', "%{$search}%");
            if ($request->filled('category')) $courseQuery->where('course_category_id', $request->category);
            
            switch ($sort) {
                case 'oldest': $courseQuery->oldest(); break;
                case 'name_asc': $courseQuery->orderBy('title', 'asc'); break;
                case 'name_desc': $courseQuery->orderBy('title', 'desc'); break;
                case 'latest': default: $courseQuery->latest(); break;
            }
        } else {
            $courseQuery->latest();
        }
        $courses = $courseQuery->paginate(10, ['*'], 'course_page')->withQueryString();

        // Mentor Query
        $mentorQuery = User::whereHas('roles', function($q) {
            $q->where('name', 'mentor');
        })->withCount('courses');
        
        if ($activeTab === 'mentor') {
            if ($search) $mentorQuery->where('name', 'like', "%{$search}%");
            
            switch ($sort) {
                case 'oldest': $mentorQuery->oldest(); break;
                case 'name_asc': $mentorQuery->orderBy('name', 'asc'); break;
                case 'name_desc': $mentorQuery->orderBy('name', 'desc'); break;
                case 'latest': default: $mentorQuery->latest(); break;
            }
        } else {
            $mentorQuery->latest();
        }
        $mentors = $mentorQuery->paginate(10, ['*'], 'mentor_page')->withQueryString();

        // Student Query
        $studentQuery = User::whereHas('roles', function($q) {
            $q->where('name', 'member')->orWhere('name', 'siswa');
        })->with(['enrollments.course'])->withCount('enrollments');
        
        if ($activeTab === 'siswa') {
            if ($search) $studentQuery->where('name', 'like', "%{$search}%");
            
            switch ($sort) {
                case 'oldest': $studentQuery->oldest(); break;
                case 'name_asc': $studentQuery->orderBy('name', 'asc'); break;
                case 'name_desc': $studentQuery->orderBy('name', 'desc'); break;
                case 'latest': default: $studentQuery->latest(); break;
            }
        } else {
            $studentQuery->latest();
        }
        $students = $studentQuery->paginate(10, ['*'], 'student_page')->withQueryString();

        $categories = CourseCategory::orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'mentors', 'students', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CourseCategory::all();
        // Assuming mentors have a role or just getting all users for now. You might want to filter by role='mentor'
        // For simplicity, getting all users who could be mentors
        $mentors = User::whereHas('roles', function($q) {
            $q->where('name', 'mentor')->orWhere('name', 'super-admin');
        })->get();
        
        return view('admin.courses.create', compact('categories', 'mentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_category_id' => 'required|exists:course_categories,id',
            'mentor_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|string',
            'is_published' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        if (Course::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . uniqid();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['mentor', 'category']);
        $enrollments = $course->enrollments()
            ->with('user')
            ->where('status', 'approved')
            ->latest()
            ->paginate(15);
            
        return view('admin.courses.show', compact('course', 'enrollments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::all();
        $mentors = User::whereHas('roles', function($q) {
            $q->where('name', 'mentor')->orWhere('name', 'super-admin');
        })->get();
        return view('admin.courses.edit', compact('course', 'categories', 'mentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_category_id' => 'required|exists:course_categories,id',
            'mentor_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|string',
            'is_published' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->title !== $course->title) {
            $validated['slug'] = Str::slug($validated['title']);
            if (Course::where('slug', $validated['slug'])->where('id', '!=', $course->id)->exists()) {
                $validated['slug'] = $validated['slug'] . '-' . uniqid();
            }
        }

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }
}
