<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface RecruiterInterface
{
    public function getOne(int $byUserId);
    public function getAllRecruiters(?string $search = null): LengthAwarePaginator;
    public function getAvailableRecruiters(int $companyId): Collection;
    public function getPendingRecruitersByCompany(int $companyId);
    public function getActiveRecruitersByCompany(int $companyId);
    public function updateRecruiter(Request $request);
    public function store(Request $request);
    
}