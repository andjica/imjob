<?php 

namespace App\Services;

use App\Models\Contributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ContributorInterface;
use App\Models\ContributorType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContributorServices implements ContributorInterface
{
    /**
     * Create a new Contributor using Eloquent
     *
     * @param Request $request
     * @return Contributor
     * @throws \Exception
     */
    public function create(Request $request)
    {
        // Validate request inside the service
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contributors,email',
            'contributorTypeId' => 'required|integer',
            'customContributorType' => 'nullable|string|max:255',
            'countryId' => 'required|integer',
            'cityId' => 'required|integer',
        ]);

        // If validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

      
            $contributor = new Contributor();
            $contributor->user_id = auth()->id(); 
            $contributor->name = $request->get('name');
            $contributor->email = $request->get('email');
            $contributor->contributor_type_id = $request->get('contributorTypeId');
            $contributor->custom_contributor_type = $request->get('customContributorType', null);
            $contributor->country_id = $request->get('countryId');
            $contributor->city_id = $request->get('cityId');
            
            try {

                $contributor->save();

                return $contributor;
            } catch (\Exception $e) {
                Log::error("Contributor creation failed: " . $e->getMessage());
                throw new \Exception("Something went wrong while creating the contributor.");
            }
    }

    public function getAll(?string $search = null): LengthAwarePaginator
    {   
        $query = Contributor::with('contributorType')->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('contributorType', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        return $query->paginate(20);
    }

    public function getContributor(int $contributorId)
    {
        $contributor = Contributor::find($contributorId) ?? abort(404);

        return $contributor;
    }

     /**
     * Update the authenticated contributor's profile
     *
     * @param Request $request
     * @return Contributor
     * @throws \Exception
     */
    public function update(Request $request)
    {
        // Get the authenticated user's contributor profile
        $contributor = auth()->user()->contributor;

        if (!$contributor) {
            throw new \Exception("Contributor profile not found.");
        }

        // Validate request inside the service
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contributors,email,' . $contributor->id,
            'contributorTypeId' => 'required|integer',
            'customContributorType' => 'nullable|string|max:255',
            'countryId' => 'required|integer',
            'cityId' => 'required|integer',
        ]);
       
        // If validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        
        try {

            $contributor->name = $request->get('name');
            $contributor->email = $request->get('email');
            $contributor->contributor_type_id = $request->get('contributorTypeId');
            $contributorType = ContributorType::find($request->get('contributorTypeId'));
         
            if($contributorType->name !== 'Other(Specify)')
            {
                $contributor->custom_contributor_type = null;
            }
            else
            {
                $contributor->custom_contributor_type = $request->get('customContributorType');
            }
            
            $contributor->country_id = $request->get('countryId');
            $contributor->city_id = $request->get('cityId');
            
            $contributor->save();

            return redirect()->back()->with('success', 'You update contributor profile successfully');
        } catch (\Exception $e) {
            Log::error("Contributor update failed: " . $e->getMessage());
            throw new \Exception("Something went wrong while updating the contributor.");
        }
    }
}

