<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::latest()->paginate(10);
        return view('admin.course-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.course-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Ensure unique slug
        if (CourseCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . uniqid();
        }

        CourseCategory::create($validated);

        return redirect()->route('admin.course-categories.index')->with('success', 'Kategori kursus berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCategory $courseCategory)
    {
        // Not used currently, redirect to index
        return redirect()->route('admin.course-categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course-categories.edit', compact('courseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseCategory $courseCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->name !== $courseCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
            if (CourseCategory::where('slug', $validated['slug'])->where('id', '!=', $courseCategory->id)->exists()) {
                $validated['slug'] = $validated['slug'] . '-' . uniqid();
            }
        }

        $courseCategory->update($validated);

        return redirect()->route('admin.course-categories.index')->with('success', 'Kategori kursus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $courseCategory)
    {
        $courseCategory->delete();

        return redirect()->route('admin.course-categories.index')->with('success', 'Kategori kursus berhasil dihapus.');
    }
}
