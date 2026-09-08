<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->get();
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Mark a specific notification as read.
     */
    public function markRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // If the notification has a target URL in its data, redirect there. Otherwise, go back.
        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }

        return back();
    }

    /**
     * Mark notification preview as seen (called via AJAX when navbar dropdown is opened).
     * Stores timestamp in session so toasts won't re-appear for already-previewed notifications.
     */
    public function previewSeen(Request $request)
    {
        session(['notification_preview_seen_at' => now()->toIso8601String()]);
        return response()->json(['success' => true]);
    }
}
