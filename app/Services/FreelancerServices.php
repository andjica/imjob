<?php

namespace App\Services;

use App\Models\Recruiter;
use App\Interfaces\FreelancerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FreelancerServices implements FreelancerInterface
{
    /**
     * Get freelancer by ID with related data
     */
    public function getFreelancerById(int $freelancerId)
    {
        return Recruiter::with(['user', 'freelancerCompany.company.country', 'category', 'subCategory'])
            ->findOrFail($freelancerId);
    }

    /**
     * Update freelancer profile and handle image upload
     */
    public function updateFreelancer(Request $request)
    {
        // Validate request
        $validatedData = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'title_function' => 'required|string|max:255',
            'experience_level' => 'required|in:junior,mid,senior',
            'availability' => 'required|in:morning,afternoon,evening,full_day',
            'phone_number' => 'required|string|max:20',
        ]);

        // Find freelancer
        $freelancer = Recruiter::where('user_id', auth()->user()->id)->firstOrFail();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($freelancer->profile_image && Storage::exists('public/uploads/recruiters/' . $freelancer->profile_image)) {
                Storage::delete('public/uploads/recruiters/' . $freelancer->profile_image);
            }

            // Store new image in 'storage/uploads/recruiters/'
            $imagePath = $request->file('profile_image')->store('uploads/recruiters', 'public');
            $validatedData['profile_image'] = $imagePath;
        }

        // Update user-related fields
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

    /**
     * Update profile image only
     */
    public function updateProfileImage(int $freelancerId, Request $request)
    {
        // Find freelancer
        $freelancer = Recruiter::findOrFail($freelancerId);

        // Validate image input
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:4048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($freelancer->profile_image && Storage::exists('public/uploads/recruiters/' . $freelancer->profile_image)) {
                Storage::delete('public/uploads/recruiters/' . $freelancer->profile_image);
            }

            // Store new image
            $imagePath = $request->file('profile_image')->store('uploads/recruiters', 'public');
            $freelancer->profile_image = $imagePath;
            $freelancer->save();
        }

        return $freelancer;
    }
}
