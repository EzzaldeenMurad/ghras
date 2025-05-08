<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Create a private channel between the two users
        $channelName = $this->getChannelName($this->message->sender_id, $this->message->receiver_id);
        return [
            new PrivateChannel($channelName),
        ];
    }

    /**
     * Generate a consistent channel name for two users regardless of who is sender/receiver
     */
    private function getChannelName($userId1, $userId2)
    {
        // Sort IDs to ensure consistent channel naming
        $ids = [$userId1, $userId2];
        sort($ids);
        return 'chat.' . $ids[0] . '.' . $ids[1];
    }
}
