<?php 
namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContributorInterface 
{
    public function create(Request $request);

    public function getAll(?string $search = null): LengthAwarePaginator;
    public function getContributor(int $contributorId);

    public function getAllRecruiters(?string $search = null): LengthAwarePaginator;
}