<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return 
            [new PrivateChannel('chat.' . $this->message->receiver_id),
             new PrivateChannel('chat.' . $this->message->user_id),];
    }

    /**
     * Data to broadcast with the event
     */
    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'text' => $this->message->text,
                'file_path' => $this->message->file_path,
                'file_type' => $this->message->file_type,
                'created_at' => $this->message->created_at->toDateTimeString(),
                'user_id' => $this->message->user_id,
                'receiver_id' => $this->message->receiver_id,
                'sender' => [
                    'id' => $this->message->sender->id,
                    'name' => $this->message->sender->name ?? ($this->message->sender->first_name . ' ' . $this->message->sender->last_name),
                    'email' => $this->message->sender->email,
                ]
            ]
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}
