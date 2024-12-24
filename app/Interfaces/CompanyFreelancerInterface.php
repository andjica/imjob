<?php

namespace App\Interfaces;

interface CompanyFreelancerInterface
{
   
    
    public function isFreelancerInCompany(int $freelancerId, int $companyId): bool;
    public function findFreelancer(int $userId);
}

