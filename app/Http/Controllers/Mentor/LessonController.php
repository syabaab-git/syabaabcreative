<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\LessonPublishedNotification;
use Illuminate\Support\Facades\Notification;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        if ($course->mentor_id !== auth()->id()) abort(403);
        return view('mentor.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->mentor_id !== auth()->id()) abort(403);

        if ($request->has('links')) {
            $links = $request->input('links');
            if (is_array($links)) {
                foreach ($links as $key => $link) {
                    if (!empty($link['url'])) {
                        if (!preg_match("~^(?:f|ht)tps?://~i", $link['url'])) {
                            $links[$key]['url'] = "https://" . $link['url'];
                        }
                    }
                }
                $request->merge(['links' => $links]);
            }
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'body'             => 'nullable|string',
            'duration_minutes' => 'required|integer|min:0',
            'is_preview'       => 'boolean',
            'scheduled_at'     => 'nullable|date',
            'description'      => 'nullable|string',
            'links'            => 'nullable|array',
            'links.*.url'      => 'nullable|url',
            'links.*.label'    => 'nullable|string|max:255',
            'attachments'      => 'nullable|array',
            'attachments.*'    => 'nullable|file|mimes:pdf,zip,doc,docx,rar,txt,jpg,png,mp4,mov|max:10240',
        ]);

        // Auto sort_order (append to end)
        $validated['sort_order'] = $course->lessons()->max('sort_order') + 1;

        // Process links array — filter empty
        $links = collect($request->input('links', []))
            ->filter(fn($l) => !empty($l['url']))
            ->values()
            ->toArray();
        $validated['links'] = !empty($links) ? $links : null;

        // Process file attachments — upload each
        $uploadedAttachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $uploadedAttachments[] = [
                    'path'  => $file->store('lessons/attachments', 'public'),
                    'name'  => $file->getClientOriginalName(),
                    'mime'  => $file->getClientMimeType(),
                    'size'  => $file->getSize(),
                ];
            }
        }
        $validated['attachments'] = !empty($uploadedAttachments) ? $uploadedAttachments : null;

        // Remove raw array inputs before creating
        unset($validated['links'], $validated['attachments']);

        $lesson = $course->lessons()->create(array_merge($validated, [
            'links'       => !empty($links) ? $links : null,
            'attachments' => !empty($uploadedAttachments) ? $uploadedAttachments : null,
        ]));

        if ($course->is_published) {
            $students = $course->enrollments()->with('user')->get()->pluck('user');
            if ($students->count() > 0) {
                $notification = new LessonPublishedNotification($lesson);
                if ($lesson->scheduled_at && $lesson->scheduled_at->isFuture()) {
                    $notification->delay($lesson->scheduled_at);
                }
                Notification::send($students, $notification);
            }
        }

        return redirect()->route('mentor.courses.show', $course)->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        if ($course->mentor_id !== auth()->id() || $lesson->course_id !== $course->id) abort(403);
        return view('mentor.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        if ($course->mentor_id !== auth()->id() || $lesson->course_id !== $course->id) abort(403);

        if ($request->has('links')) {
            $links = $request->input('links');
            if (is_array($links)) {
                foreach ($links as $key => $link) {
                    if (!empty($link['url'])) {
                        if (!preg_match("~^(?:f|ht)tps?://~i", $link['url'])) {
                            $links[$key]['url'] = "https://" . $link['url'];
                        }
                    }
                }
                $request->merge(['links' => $links]);
            }
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'body'             => 'nullable|string',
            'duration_minutes' => 'required|integer|min:0',
            'is_preview'       => 'boolean',
            'scheduled_at'     => 'nullable|date',
            'description'      => 'nullable|string',
            'links'            => 'nullable|array',
            'links.*.url'      => 'nullable|url',
            'links.*.label'    => 'nullable|string|max:255',
            'attachments'      => 'nullable|array',
            'attachments.*'    => 'nullable|file|mimes:pdf,zip,doc,docx,rar,txt,jpg,png,mp4,mov|max:10240',
        ]);

        // Process links
        $links = collect($request->input('links', []))
            ->filter(fn($l) => !empty($l['url']))
            ->values()
            ->toArray();

        // Process file attachments — append to existing
        $existingAttachments = $lesson->attachments ?? [];
        $newAttachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $newAttachments[] = [
                    'path'  => $file->store('lessons/attachments', 'public'),
                    'name'  => $file->getClientOriginalName(),
                    'mime'  => $file->getClientMimeType(),
                    'size'  => $file->getSize(),
                ];
            }
        }

        // Handle removed attachments
        $keepPaths = $request->input('keep_attachments', []);
        $filteredExisting = array_filter($existingAttachments, fn($a) => in_array($a['path'], $keepPaths));

        // Delete removed files
        foreach ($existingAttachments as $att) {
            if (!in_array($att['path'], $keepPaths)) {
                Storage::disk('public')->delete($att['path']);
            }
        }

        $allAttachments = array_merge(array_values($filteredExisting), $newAttachments);

        // Keep sort_order unchanged
        $validated['sort_order'] = $lesson->sort_order;

        $oldScheduledAt = $lesson->scheduled_at;

        unset($validated['links'], $validated['attachments']);

        $lesson->update(array_merge($validated, [
            'links'       => !empty($links) ? $links : null,
            'attachments' => !empty($allAttachments) ? $allAttachments : null,
        ]));

        if ($course->is_published) {
            $students = $course->enrollments()->with('user')->get()->pluck('user');
            if ($students->count() > 0) {
                // Notifikasi Jadwal Baru
                if ($lesson->scheduled_at != $oldScheduledAt) {
                    $notification = new LessonPublishedNotification($lesson);
                    if ($lesson->scheduled_at && $lesson->scheduled_at->isFuture()) {
                        $notification->delay($lesson->scheduled_at);
                    }
                    Notification::send($students, $notification);
                }

                // Notifikasi Pembaruan (Database + Realtime)
                if (empty($oldScheduledAt) || $lesson->scheduled_at == $oldScheduledAt) {
                    Notification::send($students, new \App\Notifications\LessonUpdatedNotification(
                        "Pembaruan Materi: " . $lesson->title,
                        "Mentor telah memperbarui materi atau menambahkan file baru."
                    ));
                }
            }
        }

        return redirect()->route('mentor.courses.show', $course)->with('success', 'Materi diperbarui.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        if ($course->mentor_id !== auth()->id() || $lesson->course_id !== $course->id) abort(403);

        // Delete all attachment files
        if ($lesson->attachments) {
            foreach ($lesson->attachments as $att) {
                Storage::disk('public')->delete($att['path']);
            }
        }

        $lesson->delete();
        return redirect()->route('mentor.courses.show', $course)->with('success', 'Materi dihapus.');
    }

    public function archive(Course $course, Lesson $lesson)
    {
        if ($course->mentor_id !== auth()->id() || $lesson->course_id !== $course->id) abort(403);

        $lesson->update(['is_archived' => !$lesson->is_archived]);
        
        $status = $lesson->is_archived ? 'diarsipkan' : 'dipulihkan';
        return redirect()->route('mentor.courses.show', ['course' => $course->id, 'lesson_id' => $lesson->id])->with('success', "Materi berhasil {$status}.");
    }
}
