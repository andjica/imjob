<?php

namespace App\Http\Controllers\CompanyFreelancer;

use App\Actions\FollowCompany;
use App\Http\Controllers\Controller;
use App\Http\Requests\FollowCompanyRequest;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\CompanyFreelancerInterface;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CompanyTypeInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\FreelancerInterface;
use App\Interfaces\SubCategoryInterface;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use App\Interfaces\JobTypeInterface;
use App\Repositories\JobRepository;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    public function __construct(
        private CompanyFreelancerInterface $companyFreelancerServices,
        private CategoryInterface $categoryServices,
        private FreelancerInterface $freelancerServices,
        private CountryInterface $countriesServices,
        private SubCategoryInterface $subCategoriesServices,
        private CityInterface $citiesServices,
        private CompanyTypeInterface $companyTypesServices,
        private CompanyInterface $companyServices,
        private JobTypeInterface $jobTypesServices,
        private JobRepository $jobRep
    ) {
    }

    public function dashboard()
    {
        /** @var User $user */
        $user   = auth()->user();
        $userId = $user->id;

        $freelancer = $this->companyFreelancerServices->findFreelancer($userId) ?? abort(404);
        return view('company-freelancer.pages.index', compact('freelancer'));
    }

    public function editFreelancer()
    {
        $categories   = $this->categoryServices->getAll();
        $freelancerId = auth()->user()->recruiter->id;
        $freelancer   = $this->freelancerServices->getFreelancerById($freelancerId);

        $countries     = $this->countriesServices->getCountries();
        $subCategories = $this->subCategoriesServices->getAll();
        $cities        = $this->citiesServices->getAll();
        $companyTypes  = $this->companyTypesServices->getAll();
        return view('company-freelancer.pages.freelancer.edit', compact(
            'categories',
            'freelancer',
            'countries',
            'subCategories',
            'cities',
            'companyTypes'
        ));
    }

    public function editCompany()
    {
        $user    = auth()->user()->id;
        $company = $this->companyServices->getCompanyByRecruiter($user);

        $categories    = $this->categoryServices->getAll();
        $categoryId    = $company->category_id;
        $subCategories = $this->subCategoriesServices->getAllByCategoryId($categoryId);

        $countries = $this->countriesServices->getCountries();
        $cities    = $this->citiesServices->getCitiesByCountry($company->country_id);

        $companyTypes = $this->companyTypesServices->getAll();

        return view('company-freelancer.pages.company.edit', compact(
            'company',
            'categories',
            'countries',
            'subCategories',
            'cities',
            'companyTypes'
        ));
    }

    public function settings()
    {
        $freelancerId = auth()->user()->recruiter->id;
        $freelancer   = $this->freelancerServices->getFreelancerById($freelancerId);
        return view('company-freelancer.pages.settings', compact('freelancer'));
    }

    public function findCompanies(Request $request): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $searchString = $request->get('search') ?? null;
        $companies = $this->companyServices->getAllCompanies($searchString);
        $connectedCompanies = $user->recruiter->companies;

        $connectedOnPending = $user->recruiter->companies()
        ->wherePivot('status', 'Pending')
        ->get();
      
        $connectedSuccessfully = $user->recruiter->companies()
        ->wherePivot('status', 'Active')
        ->get();
       
        return view('company-freelancer.pages.find-companies', compact('companies', 'connectedCompanies', 
        'connectedSuccessfully', 'connectedOnPending'));
    }

    public function followCompany(FollowCompanyRequest $request, FollowCompany $followCompany): JsonResponse
    {
        $followCompany->execute((int) $request->get('company_id'));

        // Example response
        return response()->json([
            'success' => true,
            'message' => 'Follow request sent successfully.',
        ]);
    }

    public function detailsCompany(Company $company): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $isConnected = $user->recruiter->companies->contains($company);
        $isOwnCompany = $user->recruiter->company?->id === $company->id;
        $similarCompanies = $this->companyServices->getCompaniesByCategory($company->category->id);

        return view('company-freelancer.pages.company.details', compact(
                'company',
                'similarCompanies',
                'isConnected',
                'isOwnCompany',
            )
        );
    }

    public function createJob(): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();

        $recruiterWithCompanies = $user->recruiter->activeCompanies;
        $countries = $this->countriesServices->getCountries();
        $categories = $this->categoryServices->getAll();
        $jobTypes = $this->jobTypesServices->getAll();

        return view('company-freelancer.pages.job.create', compact('countries', 'categories', 'jobTypes', 'recruiterWithCompanies'));
    }


    // public function getJob()
    // {
        
    //     return view('company-freelancer.pages.job.get-one', compact('job'));
    // }

    
    public function recruitmentProcess($id)
    {
        $job = $this->jobRep->find($id) ?? abort(404);
        return view('company-freelancer.pages.recruitment.job-recruitment', compact('job'));
    }


    public function candidatRecruitmentProcess()
    {
        return view('company-freelancer.pages.recruitment.candidat-recruitment-process');
    }

    public function getActiveJobs()
    {
        $recruiterId = auth()->user()->recruiter->id ?? abort(404);
        
        $jobs = $this->jobRep->findActiveByRecruiterId($recruiterId);
        
        return view('company-freelancer.pages.job.active-jobs', compact('jobs'));
    }

    public function getInactiveJobs()
    {
        $recruiterId = auth()->user()->recruiter->id ?? abort(404);
        
        $jobs = $this->jobRep->findInactiveByRecruiterId($recruiterId);
       
        return view('company-freelancer.pages.job.inactive-jobs', compact('jobs'));
    }

    



}
