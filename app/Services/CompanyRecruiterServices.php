<?php

namespace App\Services;

use App\Http\Requests\ChangeStatusRequest;
use Exception;
use App\Models\CompanyRecruiter;
use App\Interfaces\CompanyRecruiterInterface;

class CompanyRecruiterServices implements CompanyRecruiterInterface
{
    public function changeStatus(ChangeStatusRequest $request): bool
    {
        $companyId = (int) $request->get('company_id');
        $recruiterId = (int) $request->get('recruiter_id');
        $status = $request->get('status');
       
        // Find the follow request
        $followRequest = CompanyRecruiter::where('company_id', $companyId)
            ->where('recruiter_id', $recruiterId)
            ->first();

        if (!$followRequest) {
            throw new Exception('Follow request not found.');
        }

        // Update the status
        $followRequest->update([
            'status' => $status,
        ]);

        return true;
    }
}