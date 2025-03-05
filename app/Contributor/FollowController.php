<?php

namespace App\Contributor;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Interfaces\ContributorRecruiterInterface;
use App\Http\Requests\ChangeStatusRecruiterContributorRequest;

class FollowController extends Controller
{
    protected ContributorRecruiterInterface $contributorRecruiterServices;
    

    public function __construct(ContributorRecruiterInterface $contributorRecruiterServices)
    {
        $this->contributorRecruiterServices = $contributorRecruiterServices;
        
    }
    //contributor - recruiter
    public function followRecruiter(ChangeStatusRecruiterContributorRequest $request): JsonResponse
    {
        try {
            // Get the authenticated contributor's ID
            $contributorId = auth()->user()->contributor->id;
            $recruiterId = (int) $request->get('recruiter_id');
            $status = $request->get('status');
    
            // Ensure both IDs exist before proceeding
            if (!$contributorId || !$recruiterId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid contributor or recruiter ID.'
                ], 400);
            }
    
            // Create a request-like array to pass to the service method
            $changeStatusRequest = new ChangeStatusRecruiterContributorRequest([
                'contributor_id' => $contributorId,
                'recruiter_id' => $recruiterId,
                'status' => $status
            ]);
    
            // Call the service method to handle follow action
            $success = $this->contributorRecruiterServices->changeStatus($changeStatusRequest);
    
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Follow request updated successfully.',
                    'contributorId' => $contributorId
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update follow request.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
