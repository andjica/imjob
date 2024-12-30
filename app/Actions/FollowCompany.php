<?php

namespace App\Actions;

use App\Enums\CompanyRecruiterStatus;
use App\Interfaces\CompanyInterface;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\User;

class FollowCompany
{
    public function __construct(private CompanyInterface $companyService)
    {
    }

    public function execute(int $companyToFollowId, ?Company $follower = null): CompanyRecruiter
    {
        $companyToFollow = $this->getCompany($companyToFollowId);
        $follower        = $this->getFollower($follower);

        return $this->createCompanyRecruiter($companyToFollow, $follower);
    }

    private function getCompany(int $companyId): Company
    {
        return $this->companyService->get($companyId);
    }

    private function createCompanyRecruiter(Company $companyToFollow, Company $follower): CompanyRecruiter
    {
        return CompanyRecruiter::create([
            'recruiter_id' => $follower->user->recruiter->id,
            'company_id'   => $companyToFollow->id,
            'status'       => CompanyRecruiterStatus::PENDING,
        ]);
    }

    private function getFollower(?Company $follower): Company
    {
        if (!$follower) {
            /** @var User $user */
            $user     = auth()->user();
            $follower = $user->company;
        }

        return $follower;
    }
}
