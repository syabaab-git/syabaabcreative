<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')
            ->where('mentor_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('mentor.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = CourseCategory::all();
        return view('mentor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_category_id' => 'required|exists:course_categories,id',
            'description' => 'required|string',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        $validated['price'] = 0; // Admin sets actual price later
        $validated['mentor_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['is_published'] = false; // default draft

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($validated);
        return redirect()->route('mentor.courses.index')->with('success', 'Kursus berhasil dibuat dan berstatus draft.');
    }

    public function show(Request $request, Course $course)
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }
        $course->load(['lessons' => function($q) {
            $q->orderBy('sort_order', 'asc');
        }, 'assignments.submissions.user', 'enrollments.user', 'courseFiles']);

        $lessonId = $request->query('lesson_id');
        $activeLesson = $lessonId 
            ? $course->lessons->where('id', $lessonId)->first() 
            : null;

        $assignmentId = $request->query('assignment_id');
        $activeAssignment = $assignmentId
            ? $course->assignments->where('id', $assignmentId)->first()
            : null;

        $courseFiles  = $course->courseFiles->where('scope', 'course');
        $globalFiles  = \App\Models\CourseFile::where('scope', 'global')->get();

        return view('mentor.courses.show', compact('course', 'activeLesson', 'activeAssignment', 'courseFiles', 'globalFiles'));
    }

    public function edit(Course $course)
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }
        $categories = CourseCategory::all();
        return view('mentor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_category_id' => 'required|exists:course_categories,id',
            'description' => 'required|string',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'thumbnail' => 'nullable|image|max:2048',
            'is_published' => 'boolean'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($validated);
        return redirect()->route('mentor.dashboard')->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();
        return redirect()->route('mentor.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }
}
