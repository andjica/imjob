<?php

namespace App\Listeners;

use App\Events\NewFollowNotification;
use App\Notifications\FollowNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFollowNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(NewFollowNotification $event)
    {
        // Poslati notifikaciju kompaniji koja je zapraćena
        $event->company->notify(new FollowNotification($event->follower));
    }
}
