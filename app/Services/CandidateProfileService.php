<?php

namespace App\Services;

use Exception;
use App\Models\City;
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
            'profile_image' => 'nullable|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB
            'birthday' => 'nullable|date',
            'current_company' => 'nullable|string|max:255',
            'current_title_job' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer',
            'cv' => 'required|mimes:pdf,doc,docx|max:5120', // max 5MB
            'school_name' => 'required|string|max:255',
            'school_degree' => 'nullable|string|max:255',
            'school_year_start' => 'nullable|integer|min:1950|max:' . date('Y'),
            'school_year_end' => 'nullable|integer|min:1950|max:' . date('Y'),
        ]);
   
       
         if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('/uploads/mobile/candidate/profile_image', 'public'); 
            $validated['profile_image'] = $profileImagePath;
        }
        
        
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('/uploads/mobile/candidate/cv', 'public'); 
            $validated['cv'] = $cvPath;
        }
    
        $profile = CandidatProfile::create($validated);
    
        $cities = City::where('country_id', $profile->country_id)
        ->where('id', '!=',$profile->city_id)
        ->get();

        $data = $profile->load('country', 'city', 'user');
        return response()->json([
            'message' => 'Created candidate',
            'data' => $data,
            'cities' => $cities
        ]);
      
    }
}