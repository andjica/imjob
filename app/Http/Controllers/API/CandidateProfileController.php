<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Interfaces\CandidateProfileInterface;

class CandidateProfileController extends Controller
{
    protected $candidateProfileService;

    public function __construct(CandidateProfileInterface $candidateProfileService)
    {
        $this->candidateProfileService = $candidateProfileService;
    }

    public function store(Request $request)
    {
        $candidateProfile = $this->candidateProfileService->store($request);
        return response()->json([
            'message' => 'Candidate profile created successfully',
            'data' => $candidateProfile
        ], 200);
    }
}