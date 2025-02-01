<?php

namespace App\Actions;

use App\Enums\InviteType;
use App\Models\Contributor;
use App\Models\ContributorRecruiter;
use App\Models\Recruiter;
use Exception;
use Illuminate\Database\Eloquent\Model;

class FollowContributor
{
    /**
     * @throws Exception
     */
    public function execute(Model $follower, int $followedId): ?ContributorRecruiter
    {
        if ($follower instanceof Recruiter) {
            $followed = Contributor::find($followedId);
            if (!$followed) {
                throw new Exception("Contributor not found.");
            }

            return ContributorRecruiter::create([
                'recruiter_id' => $follower->id,
                'contributor_id' => $followed->id,
                'invite_type' => InviteType::RECRUITER
            ]);
        }

        if ($follower instanceof Contributor) {
            $followed = Recruiter::find($followedId);
            if (!$followed) {
                throw new Exception("Recruiter not found.");
            }

            return ContributorRecruiter::create([
                'recruiter_id' => $followed->id,
                'contributor_id' => $follower->id,
                'invite_type' => InviteType::CONTRIBUTOR
            ]);
        }

        throw new Exception("Invalid follow action.");
    }
}

