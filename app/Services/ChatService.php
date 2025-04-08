<?php

namespace App\Services;

use App\Interfaces\ChatInterface;
use App\Models\Message;

class ChatService implements ChatInterface
{
    public function getMessagesBetween(int $userId, int $receiverId)
    {
        return Message::with('sender', 'receiver')
            ->where(function ($query) use ($userId, $receiverId) {
                $query->where('user_id', $userId)
                      ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($userId, $receiverId) {
                $query->where('user_id', $receiverId)
                      ->where('receiver_id', $userId);
            })
            ->orderBy('created_at')
            ->get();
    }
}
