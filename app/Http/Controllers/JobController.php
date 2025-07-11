<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\City;
use App\Models\Country;
use App\Models\JobType;
use App\Models\Category;
use App\Models\JobSkill;
use App\Models\Candidate;
use App\Actions\CreateJob;
use App\Actions\UpdateJob;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreJobRequest;
use App\Models\RecruitmentProcess;

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
    

    public function delete($id)
    {
        $job = Job::findOrFail($id);
    
        // 1. Obriši sve povezane JobSkills
        JobSkill::where('job_id', $job->id)->delete();
    
        // 2. Pronađi sve kandidate povezane sa ovim poslom
        $candidates = Candidate::where('job_id', $job->id)->get();
    
        // 3. Za svakog kandidata obrisi sve njegove procese
        foreach ($candidates as $candidate) {
            RecruitmentProcess::where('candidate_id', $candidate->id)->delete();
            $candidate->delete();
        }
    
        // 4. Na kraju obriši sam posao
        $job->delete();
    
        return redirect()->back()->with('sucess', 'Job is deleted successfully');
    }

    public function hasAlreadyApplied($jobId, $candidateId)
    {
        $alreadyApplied = Candidate::where('job_id', $jobId)
            ->where('candidate_id', $candidateId)
            ->exists();

        return response()->json([
            'applied' => $alreadyApplied
        ]);
    }
    
}
