<?php

namespace App\Http\Controllers\CompanyFreelancer;

use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Actions\FollowCompany;
use Illuminate\Http\JsonResponse;
use App\Actions\FollowContributor;
use App\Http\Controllers\Controller;
use App\Http\Requests\FollowCompanyRequest;
use App\Http\Requests\FollowContributorRequest;


class FollowController extends Controller
{
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
}
