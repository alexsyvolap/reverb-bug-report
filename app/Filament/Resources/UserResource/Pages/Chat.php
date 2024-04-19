<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Message;
use App\Services\Chat\SendMessageService;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Chat extends Page
{
    protected static string $resource = UserResource::class;

    use InteractsWithRecord;

    protected static string $view = 'filament.chat';

    public string $channelName = '';
    public Collection $messages;
    public string $content = '';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->setChannelName();

        $this->messages = Message::with('sender', 'receiver')
            ->byUser($this->record->getKey())
            ->latest()
            ->limit(15)
            ->get()
            ->reverse();
    }

    public function sendMessage(): void
    {
        if (!$this->content) {
            $this->addError('content', 'Content can\'t be empty.');
            return;
        }

        $this->messages[] = app(SendMessageService::class)->run(
            Auth::user(),
            $this->content,
            $this->record->id,
        );

        $this->content = '';
    }

    public function incomingMessage(array $message): void
    {
        $model = Message::with('sender', 'receiver')->find($message['message']['id']);

        $this->messages[] = $model;
    }

    public function getHeading(): string|Htmlable
    {
        return 'Chat with '.$this->record->name;
    }

    public function setChannelName(): void
    {
        $this->channelName = 'chat.'.$this->record->getKey();
    }
}
