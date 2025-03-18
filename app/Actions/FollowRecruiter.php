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

class FollowRecruiter
{
    public function __construct(private CompanyInterface $companyService)
    {
    }

    public function execute(int $recruiterToFollowId, ?Company $follower = null): CompanyRecruiter
    {
        $recruiterToFollow = $this->getRecruiter($recruiterToFollowId);
        $follower = $this->getFollower($follower);

       // Log::info("Emitujem event za kanal: recruiter.{$recruiterToFollow->id}");

        // Kreiramo zapis o praćenju
        $companyRecruiter = $this->createCompanyRecruiter($recruiterToFollow, $follower);
    
        // Emitujemo event da bi Laravel poslao notifikaciju
        //broadcast(new NewFollowNotification($recruiterToFollow, $follower));
    
        return $companyRecruiter;
    }

    private function getRecruiter(int $recruiterId): ?Recruiter
    {
        return Recruiter::find($recruiterId);
    }

    private function createCompanyRecruiter(Recruiter $recruiterToFollow, Company $follower): CompanyRecruiter
    {
        $existingRecord = CompanyRecruiter::where('recruiter_id', $recruiterToFollow->id)
        ->where('company_id', $follower->id)
        ->first();
        
        if ($existingRecord && $existingRecord->status == "Rejected") {
            $existingRecord->status = 'Pending';
            $existingRecord->save();

            return $existingRecord;
        }
        return CompanyRecruiter::create([
            'recruiter_id' => $recruiterToFollow->id,
            'company_id'   => $follower->id,
            'status'       => CompanyRecruiterStatus::PENDING,
            'invite_type' => 'Company'
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