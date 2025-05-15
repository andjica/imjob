<?php
namespace App\Http\Controllers\API;
use App\Interfaces\CityInterface;
use App\Http\Controllers\Controller;
use App\Interfaces\CandidateProfileInterface;
use App\Interfaces\CountryInterface;
use App\Models\Candidate;
use App\Models\User;
use App\Repositories\JobRepository;
use DateTime;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $countryServices;
    protected $cityServices;
    protected $jobServices;

    protected $candidatProfileServices;

    public function __construct(CountryInterface $countryServices, CityInterface $cityServices, JobRepository $jobServices, CandidateProfileInterface $candidatProfileServices)
    {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;
        $this->jobServices = $jobServices;
        $this->candidatProfileServices = $candidatProfileServices;
    }

    public function getCountries()
    {
        $countries = $this->countryServices->getCountries();

        return response()->json([
            'countries' => $countries,
        ]);
    }

    public function getPhoneCode($countryId)
    {
        $phone = $this->countryServices->getPhoneCode($countryId);

        return response()->json([
            'phone' => $phone,
        ]);
    }

    public function getCitiesByCountry($coutryId)
    {
        $cities = $this->cityServices->getCitiesByCountry($coutryId);
        
        return response()->json([
            'cities' => $cities,
        ]);
    }

    public function activeJobs()
    {
        $jobsRandomFive = $this->jobServices->randomActiveJobs();

        return response()->json([
            'randomFiveJobs' => $jobsRandomFive
        ]);

    }

    public function showJob($jobId)
    {
        $job = $this->jobServices->find($jobId);
        $job->load('city', 'country', 'category', 'subCategory', 'skills','jobType');
        return response()->json([
            'message' => 'Ok',
            'job' => $job
        ], 200);
    }

    public function applyJob(Request $request, $jobId, $candidatId)
    {
       $job = $this->jobServices->find($jobId);
       
       if(!$job)
       {
         return response()->json(['message'=> 'Not found job', 404]);
       }

       $candidat = $this->candidatProfileServices->getById($candidatId);

       if(!$candidat)
       {
         return response()->json(['message'=> 'Not found candidat', 404]);
       }

       $user = User::find($request->user_id);

       if(!$user) 
       {
            return response()->json(['message'=> 'Uset not found', 404]);
       }
       $candidatJob = new Candidate();

        $candidatJob->candidate_id = $candidat->id;
        $candidatJob->job_id = $job->id;
        $candidatJob->user_id = $user->id;
        $candidatJob->status = "pending";
        $candidatJob->applied_at = new DateTime();

        $candidatJob->save();

        if($candidatJob)
        {
            return response()->json(['message'=> 'Created successfully.', 201]);
        }
    }

    public function alreadyApplyJob($jobId, $candidateId)
    {
        $candidateJob = Candidate::where('job_id', $jobId)->where('candidate_id',$candidateId)->first();
    
        if($candidateJob)
        {
            return response()->json(['message' => 'Already exist'],409);
        }
        else
        {
            return response()->json(['message' => 'Can apply to job'], 200);
        }
    }
}