<?php
namespace App\Interfaces;

interface ChatInterface
{
    public function getMessagesBetween(int $userId, int $receiverId);
}
