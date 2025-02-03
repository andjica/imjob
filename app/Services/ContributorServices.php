<?php 

namespace App\Services;

use App\Models\Contributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ContributorInterface;
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
}

