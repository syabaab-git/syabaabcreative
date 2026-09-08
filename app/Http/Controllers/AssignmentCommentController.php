<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmission;
use App\Models\AssignmentComment;
use Illuminate\Http\Request;

class AssignmentCommentController extends Controller
{
    public function store(Request $request, AssignmentSubmission $submission)
    {
        $user = auth()->user();
        $assignment = $submission->assignment;
        $course = $assignment->course;

        // Authorization check:
        // 1. If user is the mentor of the course
        // 2. If user is the student who submitted the assignment
        $isMentor = $course->mentor_id === $user->id;
        $isStudent = $submission->user_id === $user->id;

        if (!$isMentor && !$isStudent) {
            abort(403, 'Anda tidak memiliki akses untuk memberikan komentar.');
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $submission->comments()->create([
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        // If mentor commented, notify the student. If student commented, notify the mentor.
        if ($isMentor) {
            $submission->user->notify(new \App\Notifications\LessonUpdatedNotification(
                "Komentar Baru pada Tugas: " . $assignment->title,
                "Mentor memberikan komentar baru pada tugas Anda."
            ));
        } else {
            $course->mentor->notify(new \App\Notifications\LessonUpdatedNotification(
                "Komentar Siswa pada Tugas: " . $assignment->title,
                "Siswa " . $user->name . " memberikan komentar baru pada tugas."
            ));
        }

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
