<?php

namespace App\Http\Controllers\CompanyFreelancer;

use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Actions\FollowCompany;
use Illuminate\Http\JsonResponse;
use App\Actions\FollowContributor;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeStatusRecruiterContributorRequest;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\FollowCompanyRequest;
use App\Http\Requests\FollowContributorRequest;
use App\Interfaces\CompanyRecruiterInterface;
use App\Interfaces\ContributorRecruiterInterface;

class FollowController extends Controller
{
    protected CompanyRecruiterInterface $companyRecruiterServices;
    protected ContributorRecruiterInterface $contributorRecruiterServices;

    public function __construct(CompanyRecruiterInterface $companyRecruiterServices, ContributorRecruiterInterface $contributorRecruiterServices)
    {
        $this->companyRecruiterServices = $companyRecruiterServices;
        $this->contributorRecruiterServices = $contributorRecruiterServices;
    }

    //company - recruiter
    public function followCompany(FollowCompanyRequest $request, FollowCompany $followCompany): JsonResponse
    {
        $followCompany->execute((int) $request->get('company_id'));

        return response()->json([
            'success' => true,
            'message' => 'Follow request sent successfully.',
        ]);
    }

    //contributor - recruiter
    public function followRecruiter(ChangeStatusRequest $request): JsonResponse
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
            $changeStatusRequest = new ChangeStatusRequest([
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
    

    /**
     * @throws Exception
     */
    public function followContributor(FollowContributorRequest $request, FollowContributor $followContributor): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->recruiter) {
            return response()->json([
                'success' => false,
                'message' => 'You must be a recruiter to follow contributors.',
            ], 403);
        }

        try {
            $followContributor->execute($user->recruiter, (int) $request->get('follow_id'));

            return response()->json([
                'success' => true,
                'message' => 'Follow request sent successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function changeStatus(ChangeStatusRequest $request)
    {
        
        try {
            $this->companyRecruiterServices->changeStatus($request);
            return redirect()->back()->with('success', 'Follow request status updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    
    }
}
