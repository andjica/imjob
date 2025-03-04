<?php

namespace App\Http\Controllers\Company;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CompanyTypeInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\JobTypeInterface;
use App\Interfaces\RecruiterInterface;
use App\Interfaces\SubCategoryInterface;
use App\Models\Company;
use App\Repositories\JobRepository;
use App\Services\CompanyTypeServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class FrontController extends Controller
{
    protected $countryServices;
    protected $cityServices;
    protected $recruiterServices;
    protected $companyServices;
    protected $companyTypeServices;
    protected $categoryServices;
    protected $subCategoryServices;
    protected $companyTypesServices;
    protected $jobTypeServices;
    protected $jobRep;

    public function __construct(CountryInterface $countryServices, CityInterface $cityServices, 
    RecruiterInterface $recruiterServices, CompanyInterface $companyServices,CompanyTypeServices $companyTypeServices,
    CategoryInterface $categoryServices, SubCategoryInterface $subCategoryServices, CompanyTypeInterface $companyTypesServices, JobTypeInterface $jobTypeServices, JobRepository $jobRep)
    {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;
        $this->recruiterServices = $recruiterServices;
        $this->companyServices = $companyServices;
        $this->companyTypeServices = $companyTypeServices;
        $this->categoryServices = $categoryServices;
        $this->subCategoryServices = $subCategoryServices;
        $this->companyTypesServices = $companyTypesServices;
        $this->jobTypeServices = $jobTypeServices;
        $this->jobRep = $jobRep;

    }

    public function dashboard()
    {
        $user = User::find(auth()->user()->id) ?? abort(404);
        $company = Company::where('user_id', $user->id)->first();
        if(!$company instanceof Company)
        {
            return redirect('/company/dashboard/information/create');
        }
        return view('company.pages.index');
    }

    public function informationCreate()
    {
        $countries = $this->countryServices->getCountries();
        $companyTypes = $this->companyTypeServices->getAll();
        $categories = $this->categoryServices->getAll();
        
        return view('company.pages.company.create', compact('countries', 'companyTypes', 'categories'));
    }

    

    public function findRecruiters(Request $request)
    {
        $search = $request->input('search');
        $recruiters = $this->recruiterServices->getAllRecruiters($search);

        $company = auth()->user()->company;
        
        return view('company.pages.recruiters.find', compact('recruiters', 'company'));
    }

    public function findCompanies(Request $request)
    {
        // da se proveri da li je dobra putanja i da li je dobro pozvana metoda
        $search = $request->input('search');
        $companies = $this->companyServices->getAllCompanies($search);

        $company = auth()->user()->company;
        
        return view('company.pages.company.find', compact('recruiters', 'company'));
    }

   
    public function addEmployees(Request $request)
    {
        $search = $request->input('search');
        $recruiters = $this->recruiterServices->getAllRecruiters($search);
        return view('company.pages.add-employees', compact('recruiters'));
    
    }

    public function settings(): Factory|View|Application
    {
        $companyId = auth()->user()->company->id;
        $company   = Company::find($companyId) ?? abort(404);
        return view('company.pages.settings', compact('company'));
    }
   
    public function editCompany()
    {
        $user = auth()->user()->id;
        $company = $this->companyServices->getCompanyByRecruiter($user);

        $categories    = $this->categoryServices->getAll();
        $categoryId    = $company->category_id;
        $subCategories = $this->subCategoryServices->getAllByCategoryId($categoryId);

        $countries = $this->countryServices->getCountries();
        $cities    = $this->cityServices->getCitiesByCountry($company->country_id);

        $companyTypes = $this->companyTypesServices->getAll();

        return view('company.pages.company.edit', compact(
            'company',
            'categories',
            'countries',
            'subCategories',
            'cities',
            'companyTypes'
        ));
    }

    public function createJob()
    {
         /** @var User $user */
         $user = auth()->user();

        //  $recruiterWithCompanies = $user->recruiter->activeCompanies;
         $countries = $this->countryServices->getCountries();
         $categories = $this->categoryServices->getAll();
         $jobTypes = $this->jobTypeServices->getAll();
 
         return view('company.pages.job.create', compact('countries', 'categories', 'jobTypes'));
    }

    public function getActiveJobs(Request $request)
    {
        $companyId = auth()->user()->company->id ?? abort(404);

        $searchString = $request->get('query') ?? null;
        $jobs = $this->jobRep->searchJobsFromCompany($searchString, $companyId);
        
        return view('company.pages.job.active-jobs', compact('jobs'));
    }

    public function getInactiveJobs()
    {
       
        $companyId = auth()->user()->company->id;

        $jobs = $this->jobRep->findInactiveFromCompanyId($companyId);
        return view('company.pages.job.inactive-jobs', compact('jobs'));
    }
}
