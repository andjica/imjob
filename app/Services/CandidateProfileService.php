<?php

namespace App\Services;

use App\Interfaces\CandidateProfileInterface;
use App\Models\Candidate;
use Exception;
use Illuminate\Http\Request;

class CandidateProfileService implements CandidateProfileInterface
{
    public function store(Request $request)
    {
        return response()->json([
            'message' => $request->all()
        ]);
    }
}