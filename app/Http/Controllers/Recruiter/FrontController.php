<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Interfaces\ContributorInterface;
use App\Interfaces\RecruiterInterface;
use App\Models\ContributorRecruiter;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class FrontController extends Controller
{
    protected $contributorServices;
    protected $recruiterServices;

    public function __construct(
        ContributorInterface $contributorServices, RecruiterInterface $recruiterServices
    ) {
        $this->contributorServices = $contributorServices;
        $this->recruiterServices = $recruiterServices;
    }


    public function dashboard(): Factory|View|Application
    {
        $user   = auth()->user();
        $userId = $user->id;

        $recruiter = $this->recruiterServices->getOneByUserId($userId);
        return view("recruiter.pages.index", compact("recruiter"));
    }

    public function findCompany()
    {
        return view("recruiter.pages.company.find");
    }
    public function findContributor(Request $request): Factory|View|Application
    {
        /** @var User $user */
        $user = auth()->user();
        $searchString = $request->get('query') ?? null;

        // Fetch contributors
        $contributors = $this->contributorServices->getAll($searchString);
        // return dd( $user);
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

    public function createJob()
    {
        return view("recruiter.pages.job.create");
    }
    public function getActiveJobs()
    {
        return view("recruiter.pages.job.active-jobs");
    }
    public function getInactiveJobs()
    {
        return view("recruiter.pages.job.inactive-jobs");
    }

    public function settings(): Factory|View|Application
    {
        $user = auth()->user();
        // dd($recruiter);
        return view('recruiter.pages.settings', compact('user'));
    }
}
