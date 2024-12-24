<?php 

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Interfaces\CompanyInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CompanyServices implements CompanyInterface
{
    //get all active companies
    public function getAllCompanies(?string $search = null): LengthAwarePaginator
    {
        $query = Company::where('active', 1);

        if (!is_null($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->orderBy('updated_at', 'desc')->paginate(10);
    }

    

    public function countActiveCompanies()
    {
        $countActiveCompanies = Company::where('active',  1)->get();
        return $countActiveCompanies->count();
    }

    public function getAllInactiveCompanies()
    {
        $inactiveCompanies = Company::where('active', 0)
        ->with('user') 
        ->orderBy('created_at', 'desc')
        ->get();

        return $inactiveCompanies;
    }

    public function acceptCompany(int $id) : Company
    {
        $company = Company::find($id) ?? abort(404);

        $company->active = 1;

        try{
            $company->save();
            return $company;
        }
        catch(\Exception $e)
        {
            return abort(500);
        }

    }

    public function rejectCompany(int $id): bool
    {
        $findCompany = Company::find($id) ?? abort(404);

        
        try{
            $findCompany->delete();
            return true;
        }
        catch(\Exception $e)
        {
            return abort(500);
        }
    }

    
    public function create(Request $request)
    {
        $validated = $request->validate([
            'countryId' => 'required|exists:countries,id', // Validate country exists in the countries table
            'ownerTitle' => 'required|string|max:255',
            'companyTypeId' => 'required|exists:company_types,id',
            'categoryId' => 'required|exists:categories,id',
            'subCategoryId' => 'required|exists:sub_categories,id',
            // 'numberofEmployees' => 'required|integer|min:1|max:100000',
            'companyName' => 'required|string|max:255', // Company name is required
            'registrationNumber' => 'required|string|unique:companies,registration_number', // Ensure unique registration number
            'taxNumber' => 'required|string|unique:companies,tax_number', // Ensure unique tax number
            'phoneNumber' => 'required|string|max:20', // Phone number is required
            'email' => 'required|email|unique:companies,email', // Ensure unique email
            'address' => 'required|string|max:255', // Address is required
            'cityId' => 'required|exists:cities,id', // Ensure city_id exists in cities table
            'logo' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048', // Logo is optional, validate if uploaded
        ]);
        

        $company = new Company();
        $company->country_id = $request->countryId;
        $company->company_type_id = $request->companyTypeId;
        $company->category_id = $request->categoryId;
        $company->sub_category_id = $request->subCategoryId;
        $company->city_id = $request->cityId;
        $company->user_id = auth()->user()->id ?? abort(404);
        $company->owner_title = $request->ownerTitle;
        $company->name = $request->companyName;
        $company->registration_number = $request->registrationNumber;
        $company->tax_number = $request->taxNumber;
        $company->phone_number = $request->phoneNumber;
        $company->email = $request->email;
        $company->active = 0;
        // $company->number_of_employees = $request->numberofEmployees;
        $company->address = $request->address;
       
        // Handling logo upload if present
        if ($request->hasFile('logo')) {
            // Store the logo in the 'company_logos' folder within the 'public' directory
            $logoPath = $request->file('logo')->store('uploads/company_logos', 'public');
            
            // Generate the URL to access the uploaded logo
            $logoUrl = asset('storage/' . $logoPath);

            $company->logo = $logoPath;
           

            try{
                $company->save(); 
                return $company;
            }
            catch(\Exception)
            {
                return abort(500);
            }
           

        } else {
            // Handle when no logo is uploaded (optional)
            $logoPath = null;
            $logoUrl = null;
                // Save company withouth logo :)
           
                try{
                    $company->save(); 
                    return $company;
                }
                catch(\Exception)
                {
                    return abort(500);
                }
               
        }
        
       
       
    }

    public function update(Request $request)
    {
        $company = Company::where('user_id', auth()->user()->id)->first() ?? abort(404);

        $validated = $request->validate([
            'countryId' => 'required|exists:countries,id', // Validate country exists in the countries table
            'ownerTitle' => 'required|string|max:255',
            'categoryId' => 'required|exists:categories,id',
            'subCategoryId' => 'required|exists:sub_categories,id',
            'companyName' => 'required|string|max:255', // Company name is required
            'registrationNumber' => 'required|string|', // Ensure unique registration number
            'taxNumber' => 'required|string', // Ensure unique tax number
            'phoneNumber' => 'required|string|max:20', // Phone number is required
            'email' => ['required','email', Rule::unique('companies', 'email')->ignore($company->id),],
            'address' => 'required|string|max:255', // Address is required
            'cityId' => 'required|exists:cities,id', // Ensure city_id exists in cities table
            'logo' => 'nullable|mimes:jpg,jpeg,png,svg|max:2048', // Logo is optional, validate if uploaded
        ]);
        

        $company->name = $request->companyName;
        $company->country_id = $request->countryId;
        $company->company_type_id = $company->company_type_id;
        $company->category_id = $request->categoryId;
        $company->sub_category_id = $request->subCategoryId;
        $company->city_id = $request->cityId;
        $company->user_id = auth()->user()->id ?? abort(404);
        $company->owner_title = $request->ownerTitle;
        $company->name = $request->companyName;
        $company->registration_number = $request->registrationNumber;
        $company->tax_number = $request->taxNumber;
        $company->phone_number = $request->phoneNumber;
        $company->email = $request->email;
        $company->active = $company->active;
        // $company->number_of_employees = $request->numberofEmployees;
        $company->address = $request->address;
       
        
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists and the company already has a logo
            if (!empty($company->logo) && Storage::exists('public/' . $company->logo)) {
                Storage::delete('public/' . $company->logo);
            }
           
            
        
            // Store the new logo in the 'company_logos' folder
            $logoPath = $request->file('logo')->store('uploads/company_logos', 'public');
        
            // Save only the file name in the database
            $company->logo = $logoPath;
            $company->save();
        }
    
        // try {
            $company->save();
            return $company;
        // } catch (\Exception $e) {
        //     return abort(500, 'Error updating company: ' . $e->getMessage());
        // }   
        
    }

    public function getCompanyByRecruiter(int $recruiterId): object
    {
       
    
        return Company::where('user_id', $recruiterId)->with(['country', 'city', 'category', 'subCategory'])->first();
        
    }
    
    

    
}