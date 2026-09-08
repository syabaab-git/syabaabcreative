<?php

namespace App\Events;

use App\Models\OrderUpdate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderUpdate;

    /**
     * Create a new event instance.
     */
    public function __construct(OrderUpdate $orderUpdate)
    {
        $this->orderUpdate = $orderUpdate->load('user');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('order.' . $this->orderUpdate->order_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'update' => [
                'id' => $this->orderUpdate->id,
                'user_id' => $this->orderUpdate->user_id,
                'content' => $this->orderUpdate->content,
                'file_path' => $this->orderUpdate->file_path ? \Illuminate\Support\Facades\Storage::url($this->orderUpdate->file_path) : null,
                'file_name' => $this->orderUpdate->file_name,
                'created_at' => $this->orderUpdate->created_at->toIso8601String(),
                'user' => [
                    'id' => $this->orderUpdate->user->id,
                    'name' => $this->orderUpdate->user->name,
                    'avatar' => $this->orderUpdate->user->avatar ? \Illuminate\Support\Facades\Storage::url($this->orderUpdate->user->avatar) : null,
                ]
            ]
        ];
    }
}
