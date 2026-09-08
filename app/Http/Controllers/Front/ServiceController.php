<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Order;
use App\Models\User;
use App\Events\NewServiceOrder;
use App\Notifications\NewServiceOrderNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $categories = ServiceCategory::all();
        
        $query = Service::with('category')->where('is_active', true);

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('service_category_id', $request->category);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $services = $query->paginate(12)->withQueryString();

        // Rekomendasi Layanan (Random active services)
        $recommendedServices = Service::with('category')
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('front.services.index', compact('services', 'categories', 'recommendedServices'));
    }

    public function show(Service $service)
    {
        return view('front.services.show', compact('service'));
    }

    public function order(Request $request, Service $service)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'package_name' => ['nullable', 'string'],
            'requirement' => ['required', 'string'],
            'offer_price' => ['nullable', 'numeric', 'min:0'],
            'file' => ['nullable', 'file', 'max:5120'],
        ]);

        // Hapus format titik/koma dari input offer_price jika ada
        $offerPrice = null;
        if (!empty($request->offer_price_formatted)) {
            $offerPrice = (float) str_replace(['Rp', '.', ' '], '', $request->offer_price_formatted);
        } elseif (isset($validated['offer_price'])) {
            $offerPrice = $validated['offer_price'];
        }

        $minPrice = $service->base_price;
        if (!empty($validated['package_name']) && is_array($service->packages)) {
            foreach ($service->packages as $key => $val) {
                $n = is_array($val) ? ($val['name'] ?? '') : $key;
                $p = is_array($val) ? ($val['price'] ?? 0) : $val;
                
                if ($n === $validated['package_name']) {
                    $minPrice = $p;
                    break;
                }
            }
        }

        if ($offerPrice !== null && $offerPrice < $minPrice) {
            return back()->withInput()->withErrors([
                'offer_price' => 'Harga tawaran tidak boleh lebih rendah dari harga minimum paket (Rp ' . number_format($minPrice, 0, ',', '.') . ').'
            ]);
        }

        $finalAmount = $offerPrice ?: $minPrice;

        $order = Order::create([
            'order_number' => 'ORD-' . now()->format('YmdHis'),
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'whatsapp' => $validated['whatsapp'],
            'package_name' => $validated['package_name'] ?? null,
            'requirement' => $validated['requirement'],
            'amount' => $finalAmount,
            'status' => 'pending',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('order-files', 'public');

            $order->files()->create([
                'file_path' => $path,
                'file_type' => $request->file('file')->getClientOriginalExtension(),
                'uploaded_by' => 'client',
            ]);
        }

        // Fire Event for Real-time Dashboard Update
        event(new NewServiceOrder($order));

        // Send Database Notification to Admin & Staff
        $adminsAndStaff = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['super-admin', 'agency-staff']);
        })->get();
        Notification::send($adminsAndStaff, new NewServiceOrderNotification($order));

        return redirect()->route('services.success', $order);
    }

    public function success(Order $order)
    {
        // Pastikan hanya pemilik pesanan yang bisa melihat halaman success
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('front.services.success', compact('order'));
    }
}
