<?php

namespace App\Http\Controllers\Recruiter;

use App\Models\Company;
use App\Models\Recruiter;
use App\Models\Contributor;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\JobTypeInterface;
use App\Models\ContributorRecruiter;
use App\Interfaces\CategoryInterface;
use App\Interfaces\RecruiterInterface;
use Illuminate\Contracts\View\Factory;
use App\Interfaces\ContributorInterface;
use Illuminate\Contracts\Foundation\Application;

class FrontController extends Controller
{
    protected $contributorServices;
    protected $recruiterServices;
    protected $companyServices;
    protected $countriesServices;
    protected $categoryServices;
    protected $jobTypesServices;
    protected $jobRep;

    public function __construct(
        ContributorInterface $contributorServices,
        RecruiterInterface $recruiterServices,
        CompanyInterface $companyServices,
        JobTypeInterface $jobTypesServices,
        CountryInterface $countriesServices,
        CategoryInterface $categoryServices,
        JobRepository $jobRep
    ) {
        $this->contributorServices = $contributorServices;
        $this->recruiterServices = $recruiterServices;
        $this->companyServices = $companyServices;
        $this->countriesServices = $countriesServices;
        $this->categoryServices = $categoryServices;
        $this->jobTypesServices = $jobTypesServices;
        $this->jobRep=$jobRep;
    }


    public function dashboard(): Factory|View|Application
    {
        $user   = auth()->user();
        $userId = $user->id;

        $recruiter = $this->recruiterServices->getOneByUserId($userId);
        return view("recruiter.pages.index", compact("recruiter"));
    }

    public function findCompanies(Request $request): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $searchString = $request->get('query') ?? null;

        $companies = $this->companyServices->getAllCompanies($searchString);

        $connectedCompanies = $user->recruiter->companies;

        $connectedOnPending = $user->recruiter->companies()
            ->wherePivot('status', 'Pending')
            ->get();
        //return dd($connectedOnPending);
        $connectedSuccessfully = $user->recruiter->companies()
            ->wherePivot('status', 'Active')
            ->get();
        return view("recruiter.pages.company.find", compact(
            'companies',
            'connectedCompanies',
            'connectedSuccessfully',
            'connectedOnPending'
        ));
    }
    public function findContributors(Request $request): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $searchString = $request->get('query') ?? null;

        // Fetch contributors
        $contributors = $this->contributorServices->getAll($searchString);
        // Get connections of the recruiter
        $connectedOnPending = $user->recruiter->contributors()
            ->wherePivot('status', ContributorRecruiter::PENDING) // Use the constant
            ->pluck('contributors.id'); // Pluck only the IDs for easy lookup

        $connectedSuccessfully = $user->recruiter->contributors()
            ->wherePivot('status', ContributorRecruiter::ACTIVE) // Use the constant
            ->pluck('contributors.id'); // Pluck only the IDs for easy lookup

        // Pass variables to the view
        return view('recruiter.pages.contributor.find', compact(
            'contributors',
            'connectedOnPending',
            'connectedSuccessfully'
        ));
    }
    public function editRecruiter()
    {
        $user   = auth()->user();
        $userId = $user->id;

        $recruiter = $this->recruiterServices->getOneByUserId($userId);
        return view("recruiter.pages.edit", compact("recruiter"));
    }
    public function update(Request $request)
    {
        $this->recruiterServices->updateRecruiter($request);
        return redirect()->back()->with('success', 'You upddated information successfully');
    }
    public function detailsCompany(Company $company): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $isConnected = $user->recruiter->companies->contains($company);
        $isOwnCompany = $user->recruiter->company?->id === $company->id;
        $similarCompanies = $this->companyServices->getCompaniesByCategory($company->category->id);

        return view(
            'recruiter.pages.company.details',
            compact(
                'company',
                'similarCompanies',
                'isConnected',
                'isOwnCompany',
            )
        );
    }
    public function detailsContributor(Contributor $contributor): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $isConnected = $user->recruiter->contributors->contains($contributor);
        return view(
            'recruiter.pages.contributor.details',
            compact(
                'contributor',
                'isConnected',
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

        //get recruiters who are connected with logged company
        //$recruiters = $this->recruiterServices->getActiveRecruitersByCompany($companyId);
        return view('recruiter.pages.job.create-job', compact('countries', 'categories', 'jobTypes', 'recruiterWithCompanies'));
    }
    public function getActiveJobs(Request $request)
    {
        $companyId = auth()->user()->id ?? abort(404);

        $searchString = $request->get('query') ?? null;
        $jobs = $this->jobRep->searchJobsFromCompany($searchString, $companyId);
        
        $user = auth()->user();
        $recruiterId = $user->recruiter->id;

        $recruiter = $this->recruiterServices->getOne($recruiterId);
       
        $activeCompanies = $this->companyServices->getCompaniesByRecruiter($recruiter);
        return dd($activeCompanies);
        return view("recruiter.pages.job.active-jobs",compact('jobs'));
    }
    public function getInactiveJobs()
    {
        $companyId = auth()->user()->id;

        $jobs = $this->jobRep->findInactiveFromCompanyId($companyId);

        return view("recruiter.pages.job.inactive-jobs",compact('jobs'));
    }

    public function settings(): Factory|View|Application
    {
        $user = auth()->user();

        return view('recruiter.pages.settings', compact('user'));
    }
}
