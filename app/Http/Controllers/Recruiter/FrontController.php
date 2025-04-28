<?php

namespace App\Http\Controllers\Recruiter;

use App\Models\Job;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\JobType;
use App\Models\Category;
use App\Models\Candidate;
use App\Models\Recruiter;
use App\Models\Contributor;
use FontLib\Table\Type\fpgm;
use Illuminate\Http\Request;
use App\Actions\CreateMeeting;
use App\Models\CompanyRecruiter;
use App\Models\RecruitmentProcess;
use App\Services\CandidateService;
use App\Models\RecruitmentSubphase;
use App\Repositories\JobRepository;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\JobTypeInterface;
use App\Models\ContributorRecruiter;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\RecruiterInterface;
use Illuminate\Contracts\View\Factory;
use App\Interfaces\ContributorInterface;
use App\Http\Requests\StoreMeetingRequest;
use App\Services\RecruitmentProcessWorkflow;
use App\Http\Requests\CandidateStatusRequest;
use App\Models\AvailableRecruitmentSubphases;
use App\Http\Requests\CompleteSubphaseRequest;
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
        JobRepository $jobRep,private CandidateService $candidateService,
        private RecruitmentProcessWorkflow $recruitmentProcessWorkflow
        
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
        $countries = $this->countriesServices->getCountries();

        //prvo polje u blejdu treba da izgleda {{$recruiter->country->name}} {{$recruiter->city->name}}
        return view("recruiter.pages.edit", compact("recruiter", 'countries'));
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
                'similarCompanies'
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
        
 
        $user = auth()->user() ?? abort(404);
        $recruiterId = $user->recruiter->id;

        $recruiter = $this->recruiterServices->getOne($recruiterId);
       
        $searchString = $request->get('query') ?? null;
        $jobs = $this->jobRep->findAllByRecruterId($recruiterId);
        // return dd($jobs);
        $activeCompanies = $this->companyServices->getCompaniesByRecruiter($recruiter);
        // return dd($activeCompanies);
        return view("recruiter.pages.job.active-jobs",compact('jobs','recruiter'));
    }
    public function getInactiveJobs(Request $request)
    {
        $user = auth()->user() ?? abort(404);
        $recruiterId = $user->recruiter->id;

        $recruiter = $this->recruiterServices->getOne($recruiterId);
       
        $searchString = $request->get('query') ?? null;
        $jobs = $this->jobRep->findInactiveByRecruterId($recruiterId);
        // return dd($jobs);
        return view("recruiter.pages.job.inactive-jobs",compact('jobs'));
    }

    public function settings(): Factory|View|Application
    {
        $user = auth()->user();

        return view('recruiter.pages.settings', compact('user'));
    }

    public function recruitmentProcess(Job $job): Factory|View|Application
    {
        $candidates = $job->candidates()->with('user', 'candidate')->get();
        //return dd($candidates);
        return view('recruiter.pages.recruitment.job-recruitment', compact('job', 'candidates'));   
    }

    public function candidateRecruitmentProcess(Candidate $candidate): Factory|View|Application
    {
        $currentLoginUser = auth()->user();
        if ($candidate->status !== 'accept' || !$candidate->recruitmentProcess) {
            abort(404);
        }
        
        $recruitmentProcess = $candidate->recruitmentProcess()->with('subphases')->first();
        
        $availablePhases = AvailableRecruitmentSubphases::where('phase', $candidate->recruitmentProcess->current_phase)->get();
    
        $candidateId = $candidate->id;
        $candidateSubphases = Candidate::with('recruitmentSubPhases')->find($candidateId);
        //return dd($candidateSubphases);
        $meetings = $candidateSubphases->recruitmentSubPhases->toArray();
        $jobId = $candidate->job->id;
        
        /** @var User $user */
        $user = auth()->user();
        $contributors = $user->recruiter->contributors()
            ->wherePivot('status', ContributorRecruiter::ACTIVE)
            ->with('user')
            ->get();
         
        return view(
            'recruiter.pages.recruitment.candidat-recruitment-process',
            compact(
                'candidate',
                'recruitmentProcess',
                'availablePhases',
                'meetings',
                'contributors',
                'jobId',
            )
        );
    }

    /**
     * @throws Exception
     */
    public function changeCandidateStatus(CandidateStatusRequest $request, Candidate $candidate): RedirectResponse
    {
        $changeStatus = $this->candidateService->handleCandidate($candidate, $request->get('status'));
       
       
        return redirect()->back()->with('success', 'You change status to '.$changeStatus->status.'for Candidate '. $candidate->user->first_name.' '.$candidate->user->first_name . ' successfully');

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Status updated successfully.',
        // ]);
    }

    public function advanceProcess(RecruitmentProcess $process): RedirectResponse
    {
        $process = $this->recruitmentProcessWorkflow->advance($process);

        if(!$process) {
            return redirect()->back()->with('error', 'You must finish one or more subphases and then to go on the next level of recruitment process');
        }
        return redirect()->back()->with('success', 'You advanced process successfully.');
    }

  /**
     * @throws Exception
     */
    public function createMeeting(StoreMeetingRequest $request, Candidate $candidate, CreateMeeting $createMeeting): RedirectResponse
    {
        $createMeeting->execute($candidate, $request->validated());

        return redirect()->back()->with('success', 'Meeting created succssfully');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Meeting created successfully.',
        // ]);
    }

    public function completeSubphase(CompleteSubphaseRequest $request, RecruitmentSubphase $subphase): RedirectResponse
    {
        $subphase->completed = true;
        $subphase->feedback = $request->get('feedback');
        $subphase->save();

        return redirect()->back()->with('success', 'You accept deleted phase successfully.');
    }

    public function deleteSubphase(RecruitmentSubphase $subphase): RedirectResponse
    {
        $subphase->delete();

        return redirect()->back()->with('success', 'You accept deleted phase successfully.');
    }

    public function notifications(CompanyRecruiter $notifications, ContributorRecruiter $notificationsContributorRecruiter)
    {
        $newNotifications = $notifications->getCompaniesFollowRequest();
        $recruiterToCompaniesFollowRequest = $notifications->getRecruiterFollowRequestToCompanies();
        
        $connections = $notifications->getAllConnections();

        $newNotificationsFromContributor = $notificationsContributorRecruiter->getContributorFollowRequest();
        $recruiterToContributorFollowRequest = $notificationsContributorRecruiter->getRecruiterFollowRequestToContributor();
        $recruiterContributorConnections = $notificationsContributorRecruiter->getAllConnections();

        return view('recruiter.pages.notifications.all', 
            compact('newNotifications', 
            'connections',
            'recruiterToCompaniesFollowRequest',
            'newNotificationsFromContributor',
            'recruiterToContributorFollowRequest',
            'recruiterContributorConnections'
        ));
    }

    public function connections(CompanyRecruiter $notifications, ContributorRecruiter $notificationsContributorRecruiter)
    {
        $recruiterCompanyConnections = $notifications->getAllConnections();
        $recruiterContributorConnections = $notificationsContributorRecruiter->getAllConnections();

        return view('recruiter.pages.connection.all', compact('recruiterCompanyConnections','recruiterContributorConnections'));
    }

    public function editJob($id)
    {
        $user = auth()->user();
        $job = $this->jobRep->find($id);
        $recruiterWithCompanies = $user->recruiter->activeCompanies;
        if (!$job) {
            return redirect()->route('company-freelancer-active-jobs')->with('error', 'Job not found.');
        }
        //return dd($job->skills);
        return view('recruiter.pages.job.edit', [
            'job'        => $job,
            'countries'  => Country::all(),
            'cities' => City::all(),
            'categories' => Category::all(),
            'jobTypes'   => JobType::all(),
            'recruiterWithCompanies' => $recruiterWithCompanies
        ]);
    }

    public function chats(ContributorRecruiter $notificationsContributorRecruiter)
    {
        $user = auth()->user();
        $contributors = $user->recruiter->contributors()
            ->wherePivot('status', ContributorRecruiter::ACTIVE)
            ->with('user')
            ->get();
    
        return view('recruiter.pages.chat', compact('contributors'));
    }

}
