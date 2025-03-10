<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Interfaces\ContributorInterface;
use App\Models\ContributorRecruiter;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class FrontController extends Controller
{
    protected $contributorServices;

    public function __construct(
        ContributorInterface $contributorServices
    ) {
        $this->contributorServices = $contributorServices;
    }
    public function dashboard(): Factory|View|Application
    {
        return view("recruiter.pages.index");
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
        return view("recruiter.pages.edit");
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
