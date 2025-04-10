<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\JobType;
use App\Models\Category;
use App\Actions\CreateJob;
use App\Actions\UpdateJob;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreJobRequest;

class JobController extends Controller
{

    public function __construct(protected JobRepository $jobRep) {}

    public function store(StoreJobRequest $request, CreateJob $createJob): RedirectResponse
    {
        $createJob->execute($request->validated());

        $user = auth()->user();
        if ($user?->company) {
            if ($user->company->companyType->name == "Freelancer") {
                return redirect()->route('company-freelancer-active-jobs')->with('success', 'You created job successfully');
            } else {
                return redirect()->route('company-dashboard-active-jobs')->with('success', 'You created job successfully');
            }
        } else {
            return redirect()->route('recruiter-active-jobs')->with('success', 'You created job successfully');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        $job = $this->jobRep->find($id);
        $recruiterWithCompanies = $user->recruiter->activeCompanies;
        if (!$job) {
            return redirect()->route('company-freelancer-active-jobs')->with('error', 'Job not found.');
        }
        //return dd($job->skills);
        return view('company-freelancer.pages.job.edit', [
            'job'        => $job,
            'countries'  => Country::all(),
            'cities' => City::all(),
            'categories' => Category::all(),
            'jobTypes'   => JobType::all(),
            'recruiterWithCompanies' => $recruiterWithCompanies
        ]);
    }

    public function update(StoreJobRequest $request, $id, UpdateJob $updateJob)
    {
        $job = $this->jobRep->find($id) ?? abort(404);
    
        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }
    
        // Use UpdateJob action to update the job
        $updatedJob = $updateJob->execute($id, $request->validated());
    
        if (!$updatedJob) {
            if (auth()->user()->role->name == 'recruiter') {
                return redirect()->route('recruiter-active-jobs')->with('error', 'Failed to update job.');
            }
    
            if (auth()->user()->company->companyType->name == "Freelancer") {
                return redirect()->route('company-freelancer-active-jobs')->with('error', 'Failed to update job.');
            } else {
                return redirect()->route('company-dashboard-active-jobs')->with('error', 'Failed to update job.');
            }
        }
    
        if (auth()->user()->role->name == 'recruiter') {
            return redirect()->route('recruiter-active-jobs')->with('success', 'Job updated successfully.');
        }
    
        if (auth()->user()->company->companyType->name == "Freelancer") {
            return redirect()->route('company-freelancer-active-jobs')->with('success', 'Job updated successfully.');
        } else {
            return redirect()->route('company-dashboard-active-jobs')->with('success', 'Job updated successfully.');
        }
    }
    
}
