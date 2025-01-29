<?php 

namespace App\Services;

use App\Interfaces\ContributorInterface;
use App\Models\Contributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
}

