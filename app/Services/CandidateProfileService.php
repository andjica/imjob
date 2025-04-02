<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use App\Models\CandidatProfile;
use App\Interfaces\CandidateProfileInterface;

class CandidateProfileService implements CandidateProfileInterface
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string|max:255',
            'profile_image' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'current_company' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // max 5MB
            'school_name' => 'required|string|max:255',
            'school_degree' => 'nullable|string|max:255',
            'school_year_start' => 'nullable|integer|min:1950|max:' . date('Y'),
            'school_year_end' => 'nullable|integer|min:1950|max:' . date('Y'),
        ]);
   
        
        //znaci cv odlazi u storage folder - pa u onda app/public/uploads/cv
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('/uploads/cv', 'public'); // čuva u storage/app/public/cv
            $validated['cv'] = $cvPath;
        }
    
        $profile = CandidatProfile::create($validated);
    
        return response()->json([
            'message' => 'Profile created successfully.',
            'data' => $profile
        ], 201);
      
    }
}