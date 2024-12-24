<?php
namespace App\Services;

use App\Models\Recruiter;
use App\Models\Freelancer;
use App\Models\FreelancerCompany;
use App\Interfaces\CompanyFreelancerInterface;

class CompanyFreelancerServices implements CompanyFreelancerInterface
{
    /**
     * Check if a freelancer is associated with a company.
     *
     * @param int $freelancerId
     * @param int $companyId
     * @return bool
     */
    public function isFreelancerInCompany(int $freelancerId, int $companyId): bool
    {
        return FreelancerCompany::where('freelancer_id', $freelancerId)
            ->where('company_id', $companyId)
            ->exists();
    }

    /**
     * Find a freelancer by specific criteria.
     *
     * @param array $criteria
     * @return mixed
     */
    public function findFreelancer(int $userId)
    {
       
        return Recruiter::where('user_id', $userId)->where('is_freelancer', 1)->first();
    }
}
