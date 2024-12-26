<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CompanyInterface;
use App\Interfaces\RecruiterInterface;
use App\Models\Company;

class FrontController extends Controller
{
    protected $companyService;
    protected $recruiterService;

    public function __construct(CompanyInterface $companyService, RecruiterInterface $recruiterService)
    {
        $this->companyService = $companyService;
        $this->recruiterService = $recruiterService;
    }
    public function dashboard()
    {
        
    }

    public function companies(Request $request)
    {
        $search = $request->input('search');
        $companies = $this->companyService->getAllCompanies($search);
        $countActiveCompanies = $this->companyService->countActiveCompanies(); 
        $inactiveCompanies = $this->companyService->getAllInactiveCompanies();

        return view('admin.pages.companies.all', compact('companies', 'countActiveCompanies', 'inactiveCompanies'));
    }

    public function recruiters(Request $request)
    {
        $search = $request->input('search');
        $recruiters = $this->recruiterService->getAllRecruiters($search);

        return view('admin.pages.recruiters.all', compact('recruiters'));
    }

    public function notifications(Request $request)
    {
        $inactiveCompanies = $this->companyService->getAllInactiveCompanies();
        
        $companies = $this->companyService->getAllCompanies(null);
        return view('admin.pages.notifications', compact('inactiveCompanies', 'companies'));
    }
}
