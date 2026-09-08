<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\SystemNotification;

class StoreFlashNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Jika response adalah redirect dan ada session 'success'
        // kita simpan sebagai notifikasi database agar bisa dilihat di navbar/notification list
        if ($response->isRedirection() && session()->has('success') && auth()->check()) {
            // Cek session ini belum diproses sebelumnya dalam request ini
            // (karena redirect bisa chain atau hal lainnya, tapi session() hanya bertahan 1 request)
            $user = auth()->user();
            $message = session()->get('success');
            
            try {
                $user->notify(new SystemNotification($message));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send flash notification: " . $e->getMessage());
            }
        }

        return $response;
    }
}
