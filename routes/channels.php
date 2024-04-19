<?php

use App\Broadcasting\AdminAllChatsChannel;
use App\Broadcasting\MessageChannel;
use App\Broadcasting\UserAuthChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{userId}', UserAuthChannel::class);
Broadcast::channel('admin.all.chats', AdminAllChatsChannel::class);
Broadcast::channel('chat.{receiver}', MessageChannel::class);
