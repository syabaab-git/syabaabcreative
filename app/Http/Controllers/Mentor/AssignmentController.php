<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function create(Course $course)
    {
        if ($course->mentor_id !== auth()->id()) abort(403);
        return view('mentor.assignments.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->mentor_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'scheduled_at' => 'nullable|date',
        ]);

        $assignment = $course->assignments()->create($validated);
        return redirect()->route('mentor.courses.show', $course)->with('success', 'Penugasan berhasil dibuat.');
    }

    public function edit(Course $course, Assignment $assignment)
    {
        if ($course->mentor_id !== auth()->id() || $assignment->course_id !== $course->id) abort(403);
        return view('mentor.assignments.edit', compact('course', 'assignment'));
    }

    public function update(Request $request, Course $course, Assignment $assignment)
    {
        if ($course->mentor_id !== auth()->id() || $assignment->course_id !== $course->id) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'scheduled_at' => 'nullable|date',
        ]);

        $assignment->update($validated);
        return redirect()->route('mentor.courses.show', $course)->with('success', 'Penugasan berhasil diperbarui.');
    }

    public function destroy(Course $course, Assignment $assignment)
    {
        if ($course->mentor_id !== auth()->id() || $assignment->course_id !== $course->id) abort(403);
        $assignment->delete();
        return redirect()->route('mentor.courses.show', $course)->with('success', 'Penugasan dihapus.');
    }

    public function archive(Course $course, Assignment $assignment)
    {
        if ($course->mentor_id !== auth()->id() || $assignment->course_id !== $course->id) abort(403);
        $assignment->update(['is_archived' => !$assignment->is_archived]);
        $status = $assignment->is_archived ? 'diarsipkan' : 'dipulihkan';
        return redirect()->route('mentor.courses.show', $course)->with('success', "Penugasan berhasil {$status}.");
    }
}
