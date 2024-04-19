<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'encrypted',
        ];
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where(
            fn(Builder $q) => $q
                ->where('sender_id', '=', $userId)
                ->orWhere('receiver_id', '=', $userId),
        );
    }

    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receiver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }
}
