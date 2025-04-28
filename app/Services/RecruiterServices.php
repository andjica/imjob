<?php 

namespace App\Services;

use App\Models\Company;
use App\Models\Country;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use App\Models\FreelancerCompany;
use App\Interfaces\RecruiterInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RecruiterServices implements RecruiterInterface
{
    public function getOne(int $id)
    {
        $recruiter = Recruiter::find($id) ?? abort(404);
        return $recruiter;
    }
    public function getOneByUserId(int $byUserId)
    {
        $recruiter = Recruiter::where('user_id', $byUserId)->first() ?? abort(404);
        return $recruiter;
    }
    //get all recruiters
    public function getAllRecruiters(?string $search = null): LengthAwarePaginator
    {
        $query = Recruiter::query();
        // Include the `users` table in the query using a join or relationship
        $query->with('user')
        ->when($search, function ($q) use ($search) {
        $q->where('title_function', 'like', '%' . $search . '%') // Search by title in Recruiters table
          ->orWhereHas('user', function ($userQuery) use ($search) {
              $userQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%'); // Search in Users table
          });
        
    });
        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    //recruiters who are not in connection with thath specific company
    public function getAvailableRecruiters(int $companyId): Collection
    {
        return Recruiter::whereNotIn('id', function ($query) use ($companyId) {
            $query->select('recruiter_id')
                  ->from('company_recruiter')
                  ->where('company_id', $companyId);
        })->get();
    }

    //find company and get all connections with recruiters - with all status
    public function getPendingRecruitersByCompany(int $companyId): Collection
    {
        $company = Company::findOrFail($companyId);
        return $company->pendingRecruiters; 
    }

    //find company and get all connections - where status is Active
    public function getActiveRecruitersByCompany(int $companyId)
    {
        $company = Company::findOrFail($companyId);
        return $company->activeRecruiters;
    }
    public function updateRecruiter(Request $request)
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
        $recruiter = Recruiter::where('user_id', auth()->user()->id)->firstOrFail();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($recruiter->profile_image && Storage::exists('public/uploads/recruiters/' . $recruiter->profile_image)) {
                Storage::delete('public/uploads/recruiters/' . $recruiter->profile_image);
            }

            // Store new image in 'storage/uploads/recruiters/'
            $imagePath = $request->file('profile_image')->store('uploads/recruiters', 'public');
            $validatedData['profile_image'] = $imagePath;
        }

        // Update user-related fields
        $recruiter->user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
        ]);

        // Update freelancer-specific fields
        $recruiter->update([
            'birthday' => $validatedData['birthday'],
            'title_function' => $validatedData['title_function'],
            'experience_level' => $validatedData['experience_level'],
            'availability' => $validatedData['availability'],
            'phone_number' => $validatedData['phone_number'],
            'profile_image' => $validatedData['profile_image'] ?? $recruiter->profile_image,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

     //store freelancer
     public function store(Request $request)
     {
        $validatedData = $request->validate([
            'birthday' => 'required|date|before:today',
            'countryId' => 'nullable|exists:countries,id',
            'cityId' => 'nullable|exists:cities,id',
            'experienceLevel' => 'required|in:junior,mid,senior',
            'availability' => 'required|in:morning,afternoon,evening,full_day',
            //'phoneNumber' => 'nullable|string|max:255',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);
         $freelancer = new Recruiter();
         
         // Handle profile image upload
         if ($request->hasFile('profileImage')) {
             $fileName = time() . '.' . $request->file('profileImage')->getClientOriginalExtension();
             $filePath = $request->file('profileImage')->storeAs('uploads/recruiters', $fileName, 'public');
             $validatedData['profileImage'] = $filePath;
             $freelancer->profile_image = $filePath;
         }
         $user = auth()->user();
        //  if (!$user->company) {
        //     return redirect()->back()->with('error', 'You are not associated with any company.');
        // }
        //  $company = $user->company;
        //  if (!$company) {
        //     return redirect()->back()->with('error', 'You must be associated with a company to perform this action.');
        // }
        // $country = Country::find($company->country_id);

         $freelancer->user_id = auth()->user()->id;
         $freelancer->birthday = $validatedData['birthday'];
         $freelancer->experience_level = $validatedData['experienceLevel'];
         $freelancer->availability = $validatedData['availability'];
         //$freelancer->phone_number = '+' . trim($country->phone_code) . trim($validatedData['phoneNumber']);
 
    
        
         //if recruiter has company is freelancer 
         // Assuming the authenticated user belongs to a company
        $role = auth()->user()->role;


         if($role->name === "company")
         { 
            $companyId = auth()->user()->company->id;
             $company = Company::find($companyId);
             $freelancer->country_id = $company->country_id;
             $freelancer->city_id = $company->city_id;
             $freelancer->phone_number = $company->phone_number;
             $freelancer->is_freelancer = 1;
             $freelancer->title_function = "main in his own company ".auth()->user()->company->name;

             $freelancer->save();
 
              // Check if freelancer already exists in the company pivot table
         
                 // return $companyId;
                 $existingFreelancerAndCompany = FreelancerCompany::where('company_id', $companyId)->where('freelancer_id', $freelancer->id)->first();
                 if ($existingFreelancerAndCompany) {
                     return redirect()->back()->with('error', 'This freelancer is already associated with your company.');
                 }
                 else
                 {
             
                   // Save freelancer-company relation
                     $freelancerCompany = new FreelancerCompany();
                     $freelancerCompany->freelancer_id = $freelancer->id;
                     $freelancerCompany->company_id = $companyId;
                     $freelancerCompany->save();
                 }
                 return redirect('/home')->with('success', 'Freelancer information saved successfully!');
         }
         else
         {
            $freelancer->country_id = $request->get('country_id');
            $freelancer->city_id = $request->get('city_id');
            $freelancer->title_function = null;
            $freelancer->is_freelancer = 0;
            $freelancer->save();
            return redirect('/home')->with('success', 'Recruiter information saved successfully!');
         }
     }
}