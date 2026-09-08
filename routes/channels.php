<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('online-users', function ($user) {
    return ['id' => $user->id, 'name' => $user->name, 'role' => $user->roles->first()?->name ?? 'member'];
});

Broadcast::channel('admin.dashboard', function ($user) {
    return $user->hasRole('admin');
});

Broadcast::channel('order.{id}', function ($user, $id) {
    $order = \App\Models\Order::find($id);
    if (!$order) return false;
    
    if ($user->hasRole('admin') || $user->hasRole('super-admin') || $user->hasRole('staff') || $user->id === $order->user_id) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar ? \Illuminate\Support\Facades\Storage::url($user->avatar) : null
        ];
    }
    return false;
});
