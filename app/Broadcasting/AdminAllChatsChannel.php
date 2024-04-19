<?php

namespace App\Broadcasting;

use App\Models\User;

class AdminAllChatsChannel
{
    public function join(User $user): array|bool
    {
        return str($user->name)->contains('admin');
    }
}
