<?php

namespace App\Broadcasting;

use App\Models\User;

class MessageChannel
{
    public function join(User $user, User $receiver): array|bool
    {
        return (int)$user->id === (int)$receiver->id;
    }
}
