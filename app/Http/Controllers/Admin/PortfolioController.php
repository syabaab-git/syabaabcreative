<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('service')->latest()->paginate(10);
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.portfolios.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url|max:255',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('portfolios/thumbnails', 'public');
        }

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function show(Portfolio $portfolio)
    {
        return redirect()->route('admin.portfolios.index');
    }

    public function edit(Portfolio $portfolio)
    {
        $services = Service::all();
        return view('admin.portfolios.edit', compact('portfolio', 'services'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_url' => 'nullable|url|max:255',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('thumbnail')) {
            if ($portfolio->thumbnail) {
                Storage::disk('public')->delete($portfolio->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('portfolios/thumbnails', 'public');
        }

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->thumbnail) {
            Storage::disk('public')->delete($portfolio->thumbnail);
        }
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil dihapus.');
    }
}
