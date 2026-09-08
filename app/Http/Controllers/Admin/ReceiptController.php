<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ReceiptController extends Controller
{
    public function preview(Order $order)
    {
        // Return a simple HTML preview for modal
        return view('admin.orders.receipt_preview', compact('order'));
    }

    public function generate(Order $order)
    {
        $pdf = PDF::loadView('admin.orders.receipt_preview', compact('order'));
        $fileName = 'receipts/receipt_' . $order->order_number . '_' . time() . '.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());
        $order->update(['receipt_file' => $fileName]);

        return response()->json(['success' => true, 'url' => Storage::url($fileName)]);
    }

    public function send(Request $request, Order $order)
    {
        // Ensure PDF exists or generate
        if (empty($order->receipt_file) || !Storage::disk('public')->exists($order->receipt_file)) {
            $pdf = PDF::loadView('admin.orders.receipt_preview', compact('order'));
            $fileName = 'receipts/receipt_' . $order->order_number . '_' . time() . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());
            $order->update(['receipt_file' => $fileName]);
        }

        // Send email with attachment if email available
        if ($order->customer_email) {
            Mail::send([], [], function ($message) use ($order) {
                $message->to($order->customer_email)
                    ->subject('Struk Pesanan ' . $order->order_number)
                    ->setBody('Berikut struk pesanan Anda. Terima kasih.', 'text/plain');

                $path = Storage::disk('public')->path($order->receipt_file);
                if (file_exists($path)) {
                    $message->attach($path, ['as' => basename($path), 'mime' => 'application/pdf']);
                }
            });
        }

        $order->update(['receipt_sent_at' => now()]);

        return response()->json(['success' => true]);
    }
}
