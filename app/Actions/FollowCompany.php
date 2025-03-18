<?php
namespace App\Actions;

use App\Models\User;
use App\Models\Company;
use App\Models\Recruiter;
use App\Models\CompanyRecruiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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

        //Log::info("Emitujem event za kanal: company.{$companyToFollow->id}");
 
        $companyRecruiter = $this->createOrUpdateCompanyRecruiter($companyToFollow, $follower);
    

        event(new NewFollowNotification($follower, $companyToFollow));

        return $companyRecruiter;
    }

    private function getCompany(int $companyId): ?Company
    {
        return $this->companyService->get($companyId);
    }

    private function createOrUpdateCompanyRecruiter(Company $companyToFollow, Recruiter $follower): CompanyRecruiter
    {
       //check first if exist in db
        $existingRecord = CompanyRecruiter::where('recruiter_id', $follower->id)
            ->where('company_id', $companyToFollow->id)
            ->first();
        
        if ($existingRecord && $existingRecord->status == "Rejected") {
            $existingRecord->status = 'Pending';
            $existingRecord->save();

            return $existingRecord;
        }

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
