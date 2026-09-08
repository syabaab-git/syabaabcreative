<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use App\Notifications\LessonUpdatedNotification;

class AssignmentSubmissionController extends Controller
{
    public function show(\App\Models\Assignment $assignment, AssignmentSubmission $submission)
    {
        $course = $assignment->course;

        if ($course->mentor_id !== auth()->id()) abort(403);

        return view('mentor.assignments.submissions.show', compact('submission', 'assignment', 'course'));
    }

    public function update(Request $request, \App\Models\Assignment $assignment, AssignmentSubmission $submission)
    {
        $course = $assignment->course;

        if ($course->mentor_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'status' => 'graded'
        ]);

        // Kirim Notifikasi ke Siswa
        $submission->user->notify(new LessonUpdatedNotification(
            "Tanggapan Tugas: " . $assignment->title,
            "Mentor telah memberikan nilai dan tanggapan pada tugas Anda."
        ));

        return redirect()->route('mentor.courses.show', $course)->with('success', 'Tanggapan berhasil diberikan.');
    }
}
