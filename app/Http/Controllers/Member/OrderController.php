<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\Order::with('service')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('member.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = \App\Models\Order::with(['service', 'files', 'payments', 'updates.user'])->where('order_number', $id)->firstOrFail();
        
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Get WhatsApp settings
        $whatsappNumber = \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890';
        $whatsappTemplate = \App\Models\Setting::where('key', 'whatsapp_template')->value('value') ?? '';
        
        // Replace placeholders in template
        $whatsappMessage = str_replace(
            ['[Nama]', '[Nomor_Pesanan]', '[Layanan]', '[Harga]', '[Paket]'],
            [
                $order->customer_name, 
                $order->order_number, 
                $order->service->title ?? 'Layanan', 
                'Rp ' . number_format($order->amount, 0, ',', '.'),
                $order->package_name ?? '-'
            ],
            $whatsappTemplate
        );

        $whatsappUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNumber) . '?text=' . urlencode($whatsappMessage);

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        return view('member.orders.show', compact('order', 'whatsappUrl', 'settings'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan berstatus pending yang dapat dibatalkan.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('member.orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function previewReceipt(string $id)
    {
        $order = \App\Models\Order::where('order_number', $id)->firstOrFail();
        if ($order->user_id !== auth()->id()) abort(403);
        if (empty($order->receipt_file) || !\Illuminate\Support\Facades\Storage::disk('public')->exists($order->receipt_file)) {
            abort(404);
        }

        return view('admin.orders.receipt_preview', compact('order'));
    }

    public function downloadReceipt(string $id)
    {
        $order = \App\Models\Order::where('order_number', $id)->firstOrFail();
        if ($order->user_id !== auth()->id()) abort(403);
        if (empty($order->receipt_file) || !\Illuminate\Support\Facades\Storage::disk('public')->exists($order->receipt_file)) {
            abort(404);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($order->receipt_file, 'struk_' . $order->order_number . '.pdf');
    }
}
