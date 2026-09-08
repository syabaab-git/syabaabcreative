<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Models\Order;
use App\Models\OrderUpdate;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderUpdateController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:10240', // max 10MB
        ]);

        $update = new OrderUpdate([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('order-updates', 'public');
            $update->file_path = $path;
            $update->file_name = $file->getClientOriginalName();
        }

        $update->save();

        // Broadcast the event
        try {
            broadcast(new MessageSent($update))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Broadcast failed: " . $e->getMessage());
        }

        $sender = auth()->user();
        $title = "Pesan baru dari {$sender->name}";
        $preview = strip_tags($validated['content']);
        if (strlen($preview) > 50) {
            $preview = substr($preview, 0, 47) . '...';
        }
        $message = "{$preview}";
        
        if ($sender->id === $order->user_id) {
            // Jika member yang mengirim, beri notifikasi ke admin dan staff
            $admins = \App\Models\User::whereHas('roles', function($q) {
                $q->whereIn('name', ['super-admin', 'admin', 'staff']);
            })->get();
            foreach ($admins as $admin) {
                $url = $admin->hasRole('staff') && !$admin->hasRole('admin') && !$admin->hasRole('super-admin')
                    ? route('staff.orders.show', $order) 
                    : route('admin.orders.show', $order);
                $avatar = $sender->avatar ? \Illuminate\Support\Facades\Storage::url($sender->avatar) : null;
                try {
                    $admin->notify(new SystemNotification($message, $title, $url, $avatar, 'chat'));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Notification failed: " . $e->getMessage());
                }
            }
        } else {
            // Jika admin/staff yang mengirim, beri notifikasi ke member (pemesan)
            if ($order->user) {
                $url = route('member.orders.show', $order);
                $avatar = $sender->avatar ? \Illuminate\Support\Facades\Storage::url($sender->avatar) : null;
                try {
                    $order->user->notify(new SystemNotification($message, $title, $url, $avatar, 'chat'));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Notification failed: " . $e->getMessage());
                }
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            $update->load('user');
            return response()->json([
                'success' => true,
                'update' => [
                    'id' => $update->id,
                    'user_id' => $update->user_id,
                    'content' => $update->content,
                    'file_path' => $update->file_path ? Storage::url($update->file_path) : null,
                    'file_name' => $update->file_name,
                    'created_at' => $update->created_at->toIso8601String(),
                    'read_at' => $update->read_at,
                    'user' => [
                        'id' => $update->user->id,
                        'name' => $update->user->name,
                        'avatar' => $update->user->avatar ? Storage::url($update->user->avatar) : null,
                    ]
                ]
            ]);
        }

        return back()->with('success', 'Pembaruan pesanan berhasil dikirim.');
    }

    public function markAsRead(Request $request, Order $order)
    {
        $validated = $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'integer|exists:order_updates,id'
        ]);

        $now = now();
        OrderUpdate::whereIn('id', $validated['message_ids'])
            ->whereNull('read_at')
            ->where('user_id', '!=', auth()->id())
            ->update(['read_at' => $now]);

        try {
            broadcast(new MessageRead($order->id, $validated['message_ids'], $now->toIso8601String()))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Broadcast failed: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'read_at' => $now->toIso8601String()]);
    }

    public function update(Request $request, OrderUpdate $orderUpdate)
    {
        if ($orderUpdate->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        if ($orderUpdate->created_at->diffInMinutes(now()) > 30 && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Pesan tidak dapat diubah karena sudah lebih dari 30 menit.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $orderUpdate->content = $validated['content'];

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($orderUpdate->file_path) {
                Storage::disk('public')->delete($orderUpdate->file_path);
            }

            $file = $request->file('attachment');
            $path = $file->store('order-updates', 'public');
            $orderUpdate->file_path = $path;
            $orderUpdate->file_name = $file->getClientOriginalName();
        }

        $orderUpdate->save();

        return back()->with('success', 'Pembaruan pesanan berhasil diubah.');
    }

    public function destroy(OrderUpdate $orderUpdate)
    {
        if ($orderUpdate->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        if ($orderUpdate->created_at->diffInMinutes(now()) > 30 && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Pesan tidak dapat dihapus karena sudah lebih dari 30 menit.');
        }

        if ($orderUpdate->file_path) {
            Storage::disk('public')->delete($orderUpdate->file_path);
        }

        $orderUpdate->delete();

        return back()->with('success', 'Pembaruan pesanan berhasil dihapus.');
    }
}
