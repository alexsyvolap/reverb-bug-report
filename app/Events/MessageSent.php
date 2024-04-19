<?php

namespace App\Events;

use App\Http\Resources\Chat\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private int $id;

    public function __construct(private readonly Message $message)
    {
        $this->id = str($this->message->sender->name)->contains('admin')
            ? $this->message->receiver_id
            : $this->message->sender_id;
    }

    public function broadcastWith(): array
    {
        return ['message' => new MessageResource($this->message)];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->id),
            new PrivateChannel('admin.all.chats'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message';
    }
}
