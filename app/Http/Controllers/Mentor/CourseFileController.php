<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseFileController extends Controller
{
    public function store(Request $request, Course $course)
    {
        if ($course->mentor_id !== auth()->id()) abort(403);

        $request->validate([
            'name'  => 'required|string|max:255',
            'scope' => 'required|in:course,global',
            'file'  => 'required|file|max:10240', // 10MB
        ]);

        $file     = $request->file('file');
        $path     = $file->store("course-files/{$course->id}", 'public');
        $size     = $file->getSize();
        $mime     = $file->getMimeType();

        CourseFile::create([
            'course_id' => $course->id,
            'name'      => $request->name,
            'file_path' => $path,
            'size'      => $size,
            'mime_type' => $mime,
            'scope'     => $request->scope,
        ]);

        return redirect()->route('mentor.courses.show', ['course' => $course->id])
            ->with('success', 'File berhasil diunggah.');
    }

    public function destroy(Course $course, CourseFile $file)
    {
        if ($course->mentor_id !== auth()->id()) abort(403);
        if ($file->course_id !== $course->id) abort(403);

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->route('mentor.courses.show', ['course' => $course->id])
            ->with('success', 'File berhasil dihapus.');
    }
}
