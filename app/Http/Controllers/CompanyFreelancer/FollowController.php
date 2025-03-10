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
use App\Models\Recruiter;

class FollowController extends Controller
{
    protected CompanyRecruiterInterface $companyRecruiterServices;

    public function __construct(CompanyRecruiterInterface $companyRecruiterServices)
    {
        $this->companyRecruiterServices = $companyRecruiterServices;
        
    }

    //recruiter or freelancer following company
    public function followCompany(FollowCompanyRequest $request, FollowCompany $followCompany): JsonResponse
    {
        $followCompany->execute((int) $request->get('company_id'));

        return response()->json([
            'success' => true,
            'message' => 'Follow request sent successfully.',
        ]);
    }

    

    /**
     * @throws Exception
     */

     //recruiter or freelancer following contributor
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

    //basic - agency, contributor following recruiter
    public function followRecruiter(Request $request) : JsonResponse
    {
        return response()->json(['stiglo'=>'stiglo']);
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

    public function delete(Request $request)
    {
        $recruiterId = $request->input('recruiter_id');

        $companyId = auth()->user()->company->id ?? abort(404);

        $delete = $this->companyRecruiterServices->delete($companyId, $recruiterId);

        return $delete;
    }
}
