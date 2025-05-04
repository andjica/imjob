<?php

namespace App\Services;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CandidatProfile;
use App\Interfaces\CandidateProfileInterface;

class CandidateProfileService implements CandidateProfileInterface
{
  
    public function store(Request $request)
    {
    
        $profile = new CandidatProfile();
        $profile->user_id = $request->user_id;
        $user = User::find($request->user_id);
        if ($user) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();
        }
        $profile->country_id = $request->country_id;
        $profile->city_id = $request->city_id;
        $profile->phone = $request->phone;
        $profile->birthday = $request->birthday;
        $profile->current_title_job = $request->current_title_job;
        $profile->current_company = $request->current_company;
        $profile->years_of_experience = $request->years_of_experience;
        $profile->school_name = $request->school_name;
        $profile->school_degree = $request->school_degree;
        $profile->school_year_start = $request->school_year_start;
        $profile->school_year_end = $request->school_year_end;
    
        // Upload profile image ako postoji
        if ($request->hasFile('profile_image')) {
            $profile->profile_image = $request->file('profile_image')
                ->store('/uploads/mobile/candidate/profile_image', 'public');
        }
    
        // Upload CV
        if ($request->hasFile('cv')) {
            $profile->cv = $request->file('cv')
                ->store('/uploads/mobile/candidate/cv', 'public');
        }
    
        $profile->save();
    
        return response()->json([
            'message' => 'Candidate profile created successfully',
            'data' => $profile->load('country', 'city', 'user'),
        ]);
    }
    
}
