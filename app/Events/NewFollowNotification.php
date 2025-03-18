<?php

namespace App\Events;

use App\Models\Company;
use App\Models\Recruiter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewFollowNotification implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $follower;
    public $followedEntity;
    public $channelName;
    public $recruiter_id;
    public $company_id;

    public function __construct($follower, $followedEntity)
    {
        $this->follower = $follower;
        $this->followedEntity = $followedEntity;

        // ✅ Ako je recruiter follower, prati kompaniju
        if ($follower instanceof Recruiter) {
            $this->channelName = 'company.' . $followedEntity->id;
            $this->recruiter_id = $follower->id;
            $this->company_id = $followedEntity->id; // Praćena kompanija
        }
        // ✅ Ako je kompanija follower, prati recruitera
        elseif ($follower instanceof Company) {
            $this->channelName = 'recruiter.' . $followedEntity->id;
            $this->company_id = $follower->id;
            $this->recruiter_id = $followedEntity->id; // Praćeni recruiter
        }
    }

    public function broadcastOn()
    {
        return new Channel($this->channelName);
    }

    public function broadcastAs()
    {
        return 'new-follow';
    }
}
