<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Interfaces\CandidateProfileInterface;

class RecruitmentController extends Controller
{
    public function getAppliedJobsByCandidate()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $candidatProfile = $user->candidateProfile;

        

        if (!$candidatProfile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $jobs = $candidatProfile->jobs()->with('company', 'country', 'city', 'recruiter','category', 'subCategory')->get();

        $count = $jobs->count();

        return response()->json(['success', 'jobs'=>$jobs, 'count'=>$count]);
    }
}

