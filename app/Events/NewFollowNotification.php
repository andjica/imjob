<?php
namespace App\Events;

use App\Models\Company;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewFollowNotification implements ShouldBroadcastNow
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

        // Recruiter prati company
        if ($follower instanceof Recruiter && $followedEntity instanceof Company) {
            $this->channelName = 'company.' . $followedEntity->id;
            $this->recruiter_id = $follower->id;
            $this->company_id = $followedEntity->id;
        }

        // Company prati recruitera
        elseif ($follower instanceof Company && $followedEntity instanceof Recruiter) {
            $this->channelName = 'recruiter.' . $followedEntity->id;
            $this->company_id = $follower->id;
            $this->recruiter_id = $followedEntity->id;
        }

        Log::info("📣 NewFollowNotification — From: " . get_class($follower) . " ID: " . $follower->id . " → To: " . get_class($followedEntity) . " ID: " . $followedEntity->id);
    }

    public function broadcastOn()
    {
        return [
            new Channel('company.' . $this->company_id),
            new Channel('recruiter.' . $this->recruiter_id),
        ];
    }

    public function broadcastAs()
    {
        return 'new-follow';
    }

    public function broadcastWith()
    {
        return [
            'company_id' => $this->company_id,
            'recruiter_id' => $this->recruiter_id,
            'follower_type' => $this->follower instanceof Company ? 'company' : 'recruiter',
            'followed_type' => $this->followedEntity instanceof Company ? 'company' : 'recruiter',
        ];
    }
}
