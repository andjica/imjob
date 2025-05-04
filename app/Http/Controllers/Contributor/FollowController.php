<?php

namespace App\Http\Controllers\Contributor;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\ContributorRecruiter;
use Illuminate\Support\Facades\Redirect;
use App\Interfaces\ContributorRecruiterInterface;
use App\Http\Requests\ChangeStatusRecruiterContributorRequest;

class FollowController extends Controller
{
    protected ContributorRecruiterInterface $contributorRecruiterServices;

    public function __construct(ContributorRecruiterInterface $contributorRecruiterServices)
    {
        $this->contributorRecruiterServices = $contributorRecruiterServices;
    }

    // Contributor follows recruiter
    public function followRecruiter(ChangeStatusRecruiterContributorRequest $request): JsonResponse
    {
        try {
            if (!auth()->user() || !auth()->user()->contributor) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not a contributor.'
                ], 403);
            }

            $contributorId = auth()->user()->contributor->id;
            $recruiterId = (int) $request->get('recruiter_id');
            $status = $request->get('status');

            if (!$contributorId || !$recruiterId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid contributor or recruiter ID.'
                ], 400);
            }

            $record = ContributorRecruiter::where('contributor_id', $contributorId)
                ->where('recruiter_id', $recruiterId)
                ->first();

            if ($record) {
                $record->update(['status' => $status]);
            } else {
                ContributorRecruiter::create([
                    'contributor_id' => $contributorId,
                    'invite_type' => 'Contributor',
                    'recruiter_id' => $recruiterId,
                    'status' => $status
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Follow request updated successfully.',
                'contributorId' => $contributorId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

   // Recruiter accepts or rejects contributor
   public function acceptContributor(ChangeStatusRecruiterContributorRequest $request)
   {
       try {
           if (!auth()->user() || !auth()->user()->recruiter) {
               return redirect()->back()->with('error', 'You are not a recruiter.');
           }

           $recruiterId = auth()->user()->recruiter->id;
           $contributorId = (int) $request->get('contributor_id');
           $status = $request->get('status');

           if (!$contributorId || !$recruiterId) {
               return redirect()->back()->with('error', 'Invalid contributor or recruiter ID.');
           }

           if (!in_array($status, ['Active', 'Rejected'])) {
               return redirect()->back()->with('error', 'Invalid status. Allowed values: Active, Rejected.');
           }

           $record = ContributorRecruiter::where('contributor_id', $contributorId)
               ->where('recruiter_id', $recruiterId)
               ->first();

           if ($record) {
               $updateData = ['status' => $status];
               if ($status === 'Active') {
                   $updateData['from_date'] = Carbon::now();
               }
               $record->update($updateData);
           } else {
               $newData = [
                   'contributor_id' => $contributorId,
                   'recruiter_id' => $recruiterId,
                   'status' => $status
               ];
               if ($status === 'Active') {
                   $newData['from_date'] = Carbon::now();
               }
               ContributorRecruiter::create($newData);
           }

           return redirect()->back()->with('success', 'Contributor status updated successfully.');
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
       }
   }

   public function changeStatus(Request $request)
    {
       
        $validated = $request->validate([
            'contributor_id' => 'required|exists:contributors,id',
            'recruiter_id' => 'required|exists:recruiters,id',
            'status' => 'required|in:Active,Rejected',
        ]);

        $record = ContributorRecruiter::where('contributor_id', $validated['contributor_id'])
            ->where('recruiter_id', $validated['recruiter_id'])
            ->first();


        if (!$record) {
            return back()->with('error', 'Connection not found.');
        }

        // Update statusa
        $record->status = $validated['status'];
        $record->save();

        return back()->with('success', 'Status updated to ' . $validated['status']);
    }
}
