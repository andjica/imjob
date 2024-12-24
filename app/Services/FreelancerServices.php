<?php

namespace App\Services;

use App\Models\Recruiter;
use App\Interfaces\FreelancerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FreelancerServices implements FreelancerInterface
{
    
    public function getFreelancerById(int $freelancerId)
    {
        return Recruiter::with(['user', 'freelancerCompany.company.country', 'category', 'subCategory'])
            ->findOrFail($freelancerId);
    }

    public function updateFreelancer(Request $request)
    {
        
                // Validate the input data
            $validatedData = $request->validate([
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birthday' => 'required|date',
                'title_function' => 'required|string|max:255',
                'experience_level' => 'required|in:junior,mid,senior',
                'availability' => 'required|in:morning,afternoon,evening,full_day',
                'phone_number' => 'required|string|max:20',
                
            ]);
           
            // Find the freelancer
            $freelancer = Recruiter::where('user_id', auth()->user()->id)->first() ?? abort(404);
            
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete the old profile image if it exists
                if ($freelancer->profile_image && Storage::exists('public/' . $freelancer->profile_image)) {
                    Storage::delete('public/' . $freelancer->profile_image);
                }

                // Store the new image and get the path
                $imagePath = $request->file('profile_image')->store('public/profile_images');
                $validatedData['profile_image'] = str_replace('public/', '', $imagePath);
            }

            // Update user-related fields (first name, last name, email)
            $freelancer->user->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                
            ]);
            
            // Update freelancer-specific fields
            $freelancer->update([
                'birthday' => $validatedData['birthday'],
                'title_function' => $validatedData['title_function'],
                'experience_level' => $validatedData['experience_level'],
                'availability' => $validatedData['availability'],
                'phone_number' => $validatedData['phone_number'],
                'profile_image' => $validatedData['profile_image'] ?? $freelancer->profile_image,
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully!');

        

    }

    public function updateProfileImage(int $freelancerId, Request $request)
    {
        $freelancer = Recruiter::findOrFail($freelancerId);

        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($freelancer->profile_image && Storage::exists('public/' . $freelancer->profile_image)) {
                Storage::delete('public/' . $freelancer->profile_image);
            }

            // Store the new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $freelancer->profile_image = $imagePath;
            $freelancer->save();
        }

        return $freelancer;
    }

}

