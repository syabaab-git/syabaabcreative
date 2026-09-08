<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function show(Course $course, Assignment $assignment)
    {
        // Pastikan user memiliki akses ke course ini
        $enrollment = $course->enrollments()->where('user_id', auth()->id())->first();
        if (!$enrollment) abort(403);

        $submission = $assignment->submissions()->where('user_id', auth()->id())->first();

        return view('member.learning.assignment', compact('course', 'assignment', 'submission'));
    }

    public function store(Request $request, Course $course, Assignment $assignment)
    {
        $enrollment = $course->enrollments()->where('user_id', auth()->id())->first();
        if (!$enrollment) abort(403);

        $validated = $request->validate([
            'content' => 'required_without:file|nullable|string',
            'file' => 'required_without:content|nullable|file|max:10240',
        ]);

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', auth()->id())
            ->first();

        $filePath = $submission ? $submission->file_path : null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments/submissions', 'public');
        }

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'user_id' => auth()->id()],
            [
                'content' => $validated['content'] ?? ($submission ? $submission->content : null),
                'file_path' => $filePath,
                'status' => 'submitted',
            ]
        );

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
