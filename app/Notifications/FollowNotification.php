<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Recruiter;

class FollowNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $follower;

    public function __construct(Recruiter $follower)
    {
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; //send to db and reel time
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->follower->name} followed your company",
            'follower_id' => $this->follower->id,
        ];
    }
}
