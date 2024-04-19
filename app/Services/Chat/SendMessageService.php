<?php

namespace App\Services\Chat;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;

class SendMessageService
{
    public function run(User $sender, string $content, ?int $receiverId = null): Message
    {
        $message = new Message(['content' => $content, 'sender_id' => $sender->id]);

        if (str($sender->name)->contains('admin')) {
            $message->receiver_id = $receiverId;
        }

        if ($message->save()) {
            $message->load('sender', 'receiver');

            broadcast(new MessageSent($message))->toOthers();

            return $message;
        }

        abort(400, 'Abort!');
    }
}
