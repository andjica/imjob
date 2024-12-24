<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface RecruiterInterface
{
    public function getAllRecruiters(?string $search = null): LengthAwarePaginator;

    public function store(Request $request);
}