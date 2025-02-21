<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Company;
use App\Models\Recruiter;
use App\Models\CompanyRecruiter;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CompanyInterface;
use App\Enums\CompanyRecruiterStatus;
use App\Events\NewFollowNotification; 

class FollowCompany
{
    public function __construct(private CompanyInterface $companyService)
    {
    }

    public function execute(int $companyToFollowId, ?Company $follower = null): CompanyRecruiter
    {
        $companyToFollow = $this->getCompany($companyToFollowId);
        $follower = $this->getFollower($follower);

        
        Log::info("Emitujem event za kanal: company.{$companyToFollow->id}");

        // Kreiramo zapis o praćenju
        $companyRecruiter = $this->createCompanyRecruiter($companyToFollow, $follower);
    
        // Emitujemo event da bi Laravel poslao notifikaciju
        broadcast(new NewFollowNotification($companyToFollow, $follower));
    
        return $companyRecruiter;
    }

    private function getCompany(int $companyId): ?Company
    {
        return $this->companyService->get($companyId);
    }

    private function createCompanyRecruiter(Company $companyToFollow, Recruiter $follower): CompanyRecruiter
    {
        return CompanyRecruiter::create([
            'recruiter_id' => $follower->id,
            'company_id'   => $companyToFollow->id,
            'status'       => CompanyRecruiterStatus::PENDING,
        ]);
    }

    private function getFollower(?Company $follower): Recruiter
    {
        if (!$follower) {
            /** @var User $user */
            $user     = auth()->user();
            $follower = $user->recruiter;
        }

        return $follower;
    }
}
