<?php 

namespace App\Services;

use App\Models\Company;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use App\Models\FreelancerCompany;
use App\Interfaces\RecruiterInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RecruiterServices implements RecruiterInterface
{
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

    //store freelancer
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            //'recruiterInformation' => 'required|string|max:255',
            'birthday' => 'required|date|before:today',
            //'categoryId' => 'exists:categories,id',
            //'subCategoryId' => 'exists:sub_categories,id',
            // 'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'experienceLevel' => 'required|in:junior,mid,senior',
            'availability' => 'required|in:morning,afternoon,evening,full_day',
            
        ], [
            // Custom error messages
            'recruiterInformation.required' => 'Recruiter information is required.',
            'birthday.required' => 'Birthday is required.',
            'birthday.before' => 'The birthday must be a date before today.',
            //'categoryId.required' => 'Category is required.',
            //'categoryId.exists' => 'The selected category is invalid.',
            //'subCategoryId.required' => 'Subcategory is required.',
            //'subCategoryId.exists' => 'The selected subcategory is invalid.',
            // 'profileImage.required' => 'Profile image is required.',
            // 'profileImage.image' => 'The profile image must be an image file.',
            // 'profileImage.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif.',
            // 'profileImage.max' => 'The profile image size must not exceed 5MB.',
            'experienceLevel.required' => 'Experience level is required.',
            'experienceLevel.in' => 'The selected experience level is invalid.',
            'availability.required' => 'Availability is required.',
            'availability.in' => 'The selected availability is invalid.',
        ]);
        $freelancer = new Recruiter();
        // Handle profile image upload
        if ($request->hasFile('profileImage')) {
            $fileName = time() . '.' . $request->file('profileImage')->getClientOriginalExtension();
            $filePath = $request->file('profileImage')->storeAs('uploads/recruiters', $fileName, 'public');
            $validatedData['profileImage'] = $filePath;
            $freelancer->profile_image = $filePath;
        }
       
          // Save the validated data
        //new recruiter or freelancer
       
        //$freelancer->recruiter_information = $validatedData['recruiterInformation'];
        $freelancer->user_id = auth()->user()->id;
        $freelancer->birthday = $validatedData['birthday'];
        //$freelancer->category_id = $validatedData['categoryId'];
        //$freelancer->sub_category_id = $validatedData['subCategoryId'];
        //$freelancer->profile_image = $validatedData['profileImage'];
        $freelancer->experience_level = $validatedData['experienceLevel'];
        $freelancer->availability = $validatedData['availability'];
        $freelancer->phone_number = $request->phoneNumber;

        
        $freelancer->title_function = "main in his own company ".auth()->user()->company->name;
        

        //if recruiter has company is freelancer 
        $companyId = auth()->user()->company->id; // Assuming the authenticated user belongs to a company

        if($companyId)
        {
            $company = Company::find($companyId);
            $freelancer->country_id = $company->country_id;
            $freelancer->city_id = $company->city_id;
            $freelancer->is_freelancer = 1;
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
            $freelancer->save();
            return redirect('/home')->with('success', 'Recruiter information saved successfully!');
        }
 

        
    }

    public function getAvailableRecruiters(int $companyId): Collection
    {
        return Recruiter::whereNotIn('id', function ($query) use ($companyId) {
            $query->select('recruiter_id')
                  ->from('company_recruiter')
                  ->where('company_id', $companyId);
        })->get();
    }

}