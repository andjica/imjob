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

    public $company;
    public $follower;

    public function __construct(Company $company, Recruiter $follower)
    {
        $this->company = $company;
        $this->follower = $follower;
    }

    public function broadcastOn()
    {
        return new Channel('company.' . $this->company->id);
    }

    public function broadcastAs()
    {
        return 'new-follow';
    }
}
