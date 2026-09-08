<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Project;
use App\Models\FinanceTransaction;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('service')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->paginate(10);
        return view('staff.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('service', 'user', 'files', 'payments');
        return view('staff.orders.show', compact('order'));
    }

    public function history()
    {
        $orders = Order::with('service')->whereIn('status', ['completed', 'cancelled'])->latest()->paginate(10);
        return view('staff.orders.history', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'estimation_date' => 'nullable|date',
        ]);

        $oldStatus = $order->status;
        $oldEstimation = $order->estimation_date;

        $newStatus = $validated['status'];

        DB::transaction(function () use ($order, $validated, $oldStatus, $newStatus) {
            $order->update([
                'status' => $newStatus,
                'estimation_date' => $validated['estimation_date'] ?? $order->estimation_date,
            ]);

            if ($oldStatus !== 'completed' && $newStatus === 'completed') {
                FinanceTransaction::create([
                    'type' => 'income',
                    'amount' => $order->amount ?? ($order->service->price ?? 0),
                    'description' => 'Pendapatan dari pesanan layanan: ' . ($order->service->title ?? 'Tidak diketahui') . ' (Klien: ' . $order->customer_name . ')',
                    'order_id' => $order->id,
                ]);
            }
            
            // Auto create project if order is processing and doesn't have a project
            if ($newStatus === 'processing' && !$order->project) {
                Project::create([
                    'order_id' => $order->id,
                    'staff_id' => auth()->id(),
                    'title' => 'Project: ' . ($order->service->title ?? 'Custom Layanan'),
                    'status' => 'pending',
                    'progress' => 0,
                    'deadline' => $order->estimation_date ?? now()->addDays(7)
                ]);
            }
        });

        // Notifications logic
        try {
            if ($order->user) {
                if ($oldStatus !== $newStatus) {
                    $msg = "Status pesanan Anda untuk layanan '" . ($order->service->title ?? 'Layanan') . "' telah diubah menjadi " . ucfirst($newStatus) . ".";
                    $order->user->notify(new SystemNotification($msg, "Status Pesanan Diperbarui"));
                } elseif (isset($validated['estimation_date']) && $validated['estimation_date'] !== $order->estimation_date) {
                    $order->user->notify(new SystemNotification(
                        "Estimasi penyelesaian pesanan Anda diperbarui menjadi " . \Carbon\Carbon::parse($validated['estimation_date'])->format('d M Y, H:i') . ".",
                        "Estimasi Pesanan Diperbarui"
                    ));
                }
            }
        } catch (\Exception $e) {
            // Abaikan error notifikasi
        }

        if ($newStatus === 'completed') {
            return redirect()->route('staff.orders.success')->with('success', 'Pesanan berhasil diselesaikan dan dicatat dalam riwayat layanan.');
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
