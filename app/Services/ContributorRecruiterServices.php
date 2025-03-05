<?php

namespace App\Services;

use App\Http\Requests\ChangeStatusRequest;
use Exception;
use App\Models\ContributorRecruiter;
use App\Interfaces\ContributorRecruiterInterface;

class ContributorRecruiterServices implements ContributorRecruiterInterface
{
    public function changeStatus(ChangeStatusRequest $request): bool
    {
        $contributorId = (int) $request->get('contributor_id');
        $recruiterId = (int) $request->get('recruiter_id');
        $status = $request->get('status');
        
        // Find the follow request
        $followRequest = ContributorRecruiter::where('contributor_id', $contributorId)
            ->where('recruiter_id', $recruiterId)
            ->first();
    
        if (!$followRequest) {
            // Create new connection
            $followRequest = new ContributorRecruiter();
            $followRequest->recruiter_id = $recruiterId;
            $followRequest->contributor_id = $contributorId;
            $followRequest->status = $status;
            $followRequest->from_date = now(); // Set current date
            $followRequest->save();

            return true;
        }
    
        // Prepare update data
        $updateData = ['status' => $status];

        // If status is "Active", update from_date with the current date
        if ($status === "Active") {
            $updateData['from_date'] = now(); // Laravel helper for current timestamp
        }

        // Update the existing record
        $followRequest->update($updateData);
    
        return true;
    }
}
