<?php

namespace App\Interfaces;


use App\Models\Company;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface CompanyInterface
{
    public function get(int $id): ?Company;

    public function getAllCompanies(?string $search = null): LengthAwarePaginator;

    public function countActiveCompanies();

    public function getAllInactiveCompanies();

    public function acceptCompany(int $id) :  Company;

    public function rejectCompany(int $id) : bool;

    public function create(Request $request);
    public function update(Request $request);

    public function getCompanyByRecruiter(int $recruiterId) : object;
    public function getCompaniesByRecruiter(Recruiter $recruiter);

    public function getCompaniesByCategory(int $categoryId) : LengthAwarePaginator;
}
