<?php

namespace App\Events;

use App\Models\Message;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class MessageSent implements ShouldBroadcast
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
     */
    public function broadcastOn(): array
{
    \Log::info('Broadcasting on channel: chat.' . $this->message->receiver_id);
    return [
        new PrivateChannel('chat.' . $this->message->receiver_id),
    ];
}

    /**
     * Data sent to the frontend.
     */
    public function broadcastWith(): array
{
    \Log::info('Broadcasting message: ' . $this->message->id);
    return [
        'id' => $this->message->id,
        'conversation_id' => $this->message->conversation_id,
        'sender_id' => $this->message->sender_id,
        'receiver_id' => $this->message->receiver_id,
        'message' => $this->message->message,
        'message_type' => $this->message->message_type,
        'created_at' => $this->message->created_at,
    ];
}
}