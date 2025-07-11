<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Interfaces\CandidateProfileInterface;
use App\Interfaces\RecruitmentProcessInterface;

class RecruitmentController extends Controller
{

     protected RecruitmentProcessInterface $recruitmentService;

        public function __construct(RecruitmentProcessInterface $recruitmentService)
        {
            $this->recruitmentService = $recruitmentService;
        }

    public function getAppliedJobsByCandidate()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $candidatProfile = $user->candidateProfile;

        

        if (!$candidatProfile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $jobs = $candidatProfile->jobs()->with('company', 'country', 'city', 'recruiter','category', 'subCategory')
        ->orderBy('updated_at', 'desc')
        ->get();

        $count = $jobs->count();

        return response()->json(['success', 'jobs'=>$jobs, 'count'=>$count]);
    }

    public function showStatus(int $candidateJobId): JsonResponse
    {
        $data = $this->recruitmentService->getCandidateRecruitmentStatus($candidateJobId);
        return response()->json($data);
    }
}

