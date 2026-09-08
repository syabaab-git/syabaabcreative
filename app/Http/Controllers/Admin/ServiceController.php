<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'semua');
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'latest');

        $applySearchSort = function($q) use ($search, $sort) {
            if ($search != '') {
                $q->where('title', 'like', '%' . $search . '%');
            }
            switch ($sort) {
                case 'oldest': $q->oldest(); break;
                case 'name_asc': $q->orderBy('title', 'asc'); break;
                case 'name_desc': $q->orderBy('title', 'desc'); break;
                case 'price_desc': $q->orderBy('base_price', 'desc'); break;
                case 'price_asc': $q->orderBy('base_price', 'asc'); break;
                case 'latest': default: $q->latest(); break;
            }
            return $q;
        };

        $categories = ServiceCategory::orderBy('name')->get();
        $servicesByTab = [];
        $totals = [];

        // Query Semua
        $qSemua = Service::with('category');
        $applySearchSort($qSemua);
        $servicesByTab['semua'] = $qSemua->paginate(10, ['*'], 'semua_page')->withQueryString();
        $totals['semua'] = $qSemua->count();

        foreach ($categories as $cat) {
            $q = Service::with('category')->where('service_category_id', $cat->id);
            $applySearchSort($q);
            $servicesByTab[$cat->slug] = $q->paginate(10, ['*'], "{$cat->slug}_page")->withQueryString();
            $totals[$cat->slug] = $q->count();
        }

        return view('admin.services.index', compact('servicesByTab', 'totals', 'categories', 'activeTab', 'search', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'estimated_days' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'package_name' => 'nullable|array',
            'package_price' => 'nullable|array',
            'package_description' => 'nullable|array',
            'package_estimated_days' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->input('action') === 'publish';

        // Parse packages from dynamic inputs
        $packages = [];
        if ($request->has('package_name') && is_array($request->package_name)) {
            foreach ($request->package_name as $index => $name) {
                if (!empty($name)) {
                    $packages[] = [
                        'name' => $name,
                        'price' => $request->package_price[$index] ?? 0,
                        'description' => $request->package_description[$index] ?? '',
                        'estimated_days' => $request->package_estimated_days[$index] ?? '',
                    ];
                }
            }
        }
        $validated['packages'] = empty($packages) ? null : $packages;

        if (Service::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . uniqid();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('services/thumbnails', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return redirect()->route('admin.services.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'estimated_days' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'package_name' => 'nullable|array',
            'package_price' => 'nullable|array',
            'package_description' => 'nullable|array',
            'package_estimated_days' => 'nullable|array',
        ]);

        if ($request->title !== $service->title) {
            $validated['slug'] = Str::slug($validated['title']);
            if (Service::where('slug', $validated['slug'])->where('id', '!=', $service->id)->exists()) {
                $validated['slug'] = $validated['slug'] . '-' . uniqid();
            }
        }

        $validated['is_active'] = $request->input('action') === 'publish';

        $packages = [];
        if ($request->has('package_name') && is_array($request->package_name)) {
            foreach ($request->package_name as $index => $name) {
                if (!empty($name)) {
                    $packages[] = [
                        'name' => $name,
                        'price' => $request->package_price[$index] ?? 0,
                        'description' => $request->package_description[$index] ?? '',
                        'estimated_days' => $request->package_estimated_days[$index] ?? '',
                    ];
                }
            }
        }
        $validated['packages'] = empty($packages) ? null : $packages;

        if ($request->hasFile('thumbnail')) {
            if ($service->thumbnail) {
                Storage::disk('public')->delete($service->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('services/thumbnails', 'public');
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->thumbnail) {
            Storage::disk('public')->delete($service->thumbnail);
        }
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Toggle the active status of the service (Archive / Publish).
     */
    public function toggleStatus(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        $status = $service->is_active ? 'diterbitkan' : 'diarsipkan';
        return back()->with('success', "Layanan berhasil $status.");
    }
}
