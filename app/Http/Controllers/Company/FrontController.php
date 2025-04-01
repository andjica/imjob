<?php

namespace App\Http\Controllers\Company;

use App\Models\Job;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use App\Interfaces\CityInterface;
use App\Repositories\JobRepository;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\JobTypeInterface;
use App\Models\ContributorRecruiter;
use App\Interfaces\CategoryInterface;
use App\Services\CompanyTypeServices;
use App\Interfaces\RecruiterInterface;
use Illuminate\Contracts\View\Factory;
use App\Interfaces\CompanyTypeInterface;
use App\Interfaces\SubCategoryInterface;
use App\Models\AvailableRecruitmentSubphases;
use App\Models\CompanyRecruiter;
use Illuminate\Contracts\Foundation\Application;

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
        $user = auth()->user();
        $companyId = $user->company->id;
        $company = $this->companyServices->get($companyId);
        if(!$company instanceof Company)
        {
            return redirect('/company/dashboard/information/create');
        }
        return view('company.pages.index', compact('company'));
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

        $user = auth()->user();


        $connectedOnPending = $user->company->recruiters()
        ->wherePivot('status', 'Pending')
        ->get();

        $connectedSuccessfully = $user->company->recruiters()
        ->wherePivot('status', 'Active')
        ->get();
        return view('company.pages.recruiters.find', compact('recruiters', 'connectedOnPending', 'connectedSuccessfully'));
    }

    public function findCompanies(Request $request)
    {
        $search = $request->input('search');
        $companies = $this->companyServices->getAllCompanies($search);

        $company = auth()->user()->company;
        
        return view('company.pages.company.find', compact('recruiters', 'company'));
    }

   
    public function addEmployees(Request $request)
    {
        $search = $request->input('search');
        $companyId = auth()->user()->company->id;
        $recruiters = $this->recruiterServices->getAvailableRecruiters($companyId);
       
        //$pendingRecruiters = $this->recruiterServices->getPendingRecruitersByCompany($companyId);
        $activeRecruiters = $this->recruiterServices->getActiveRecruitersByCompany($companyId);
        
        return view('company.pages.add-employees', compact('recruiters', 'activeRecruiters'));
    
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
         $companyId = $user->company->id;

         //get recruiters who are connected with logged company
         $recruiters = $this->recruiterServices->getActiveRecruitersByCompany($companyId);
         
         return view('company.pages.job.create', compact('countries', 'categories', 'jobTypes', 'recruiters'));
    }

    public function getActiveJobs(Request $request)
    {
        $companyId = auth()->user()->company->id ?? abort(404);

        $searchString = $request->get('query') ?? null;
        $jobs = $this->jobRep->searchJobsFromCompany($searchString, $companyId);
        // return dd($jobs);
        return view('company.pages.job.active-jobs', compact('jobs'));
    }

    public function getActiveJobsByRecruiter($recruiterId)
    {
        $user = auth()->user();
        $companyId = $user->company->id ?? abort(404);

        $jobs = $this->jobRep->findAllByCompanyIdandRecruterId($companyId, $recruiterId);
        $recruiter = $this->recruiterServices->getOne($recruiterId);
        return view('company.pages.job.active-jobs-by-recruiter', compact('jobs', 'recruiter'));
    }

    public function getActiveRecruiters()
    {
        
        $companyId = auth()->user()->company->id;
        $activeRecruiters = $this->recruiterServices->getActiveRecruitersByCompany($companyId);
        
        return view('company.pages.recruitment.active-recruiters', compact('activeRecruiters'));
    }
    public function getjobsInRecruitmentProcess()
    {
        
    }
    public function getInactiveJobs()
    {
       
        $companyId = auth()->user()->company->id;

        $jobs = $this->jobRep->findInactiveFromCompanyId($companyId);
        return view('company.pages.job.inactive-jobs', compact('jobs'));
    }

    public function followRecruiter(Request $request){
        $requestAll = $request->all();

        return response()->json([
            'request' => $requestAll
        ]);
    }

    public function recruitmentProcess(Job $job): Factory|View|Application
    {
        
        $candidates = $job->candidates()->with('user', 'candidate')->get();
        
        return view('company.pages.recruitment.job-recruitment', compact('job', 'candidates'));
    }

    public function candidateRecruitmentProcess(Candidate $candidate): Factory|View|Application
    {
        
        if ($candidate->status !== 'accept' || !$candidate->recruitmentProcess) {
            abort(404);
        }

        $job = $candidate->job;
        
        $candidates = $job->candidates()
        ->with('user', 'candidate')
        ->where('id', '!=', $candidate->id)
        ->get();
        
        $recruitmentProcess = $candidate->recruitmentProcess()->with('subphases')->first();
        
        $availablePhases = AvailableRecruitmentSubphases::where('phase', $candidate->recruitmentProcess->current_phase)->get();
    
        $candidateId = $candidate->id;
        $candidateSubphases = Candidate::with('recruitmentSubPhases')->find($candidateId);
        //return dd($candidateSubphases);
        //$meetings = $candidateSubphases->recruitmentSubPhases->toArray();
        
        $recruiterId = $candidate->job->recruiter->id;
        $recruiter = $this->recruiterServices->getOne($recruiterId);
      
        /** @var User $user */
        //$user = auth()->user();
        // //$contributors = $user->recruiter->contributors();
        //     ->wherePivot('status', ContributorRecruiter::ACTIVE)
        //     ->get();

            return view(
                'company.pages.recruitment.candidat-recruitment-process',
                compact(
                    'candidate',
                    'recruitmentProcess',
                    'availablePhases',
                    'recruiter',
                    'job',
                    'candidates'
                )
            );
    }

    public function getNotifications(CompanyRecruiter $notifications)
    {
        $recruiterToCompanyFollowRequest = $notifications->getRequestFromRecruiterToCompany();
        $companyToRecruiterRequest = $notifications->getBasciCompanyFollowRequest();
        
        $connections = $notifications->getAllConnections();
    
       
        return view('company.pages.notification.all', compact('companyToRecruiterRequest','recruiterToCompanyFollowRequest', 'connections'));
    }

    public function getConnections(CompanyRecruiter $connections)
    {
        $connections = $connections->getAllConnections();

        return view('company.pages.connection.all', compact('connections'));

    }

    public function getRecruiter($id)
    {
        $recruiter = $this->recruiterServices->getOne($id);

        $recruiter->user;
        $recruiter->category;
        $recruiter->sub_category;

        // return dd($recruiter);

        return view('company.pages.recruiters.view', compact('recruiter'));
    }
}
