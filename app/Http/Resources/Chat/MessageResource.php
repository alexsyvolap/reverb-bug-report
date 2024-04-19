<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\User\MessageUserResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method __construct(Message $resource)
 * @property Message $resource
 */
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'content' => $this->resource->content,
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
            'sender' => MessageUserResource::make($this->whenLoaded('sender')),
            'receiver' => MessageUserResource::make($this->whenLoaded('receiver'))
        ];
    }
}
