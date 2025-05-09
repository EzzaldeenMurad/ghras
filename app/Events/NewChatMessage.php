<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // إنشاء قناة خاصة بكل زوج من المستخدمين
        $ids = [$this->message->sender_id, $this->message->receiver_id];
        sort($ids);
        return new PrivateChannel('chat.' . $ids[0] . '.' . $ids[1]);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'sender' => $this->message->sender,
            'receiver' => $this->message->receiver
        ];
    }
}
