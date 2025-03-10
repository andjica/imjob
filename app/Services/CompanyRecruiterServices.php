<?php

namespace App\Services;

use Exception;
use App\Models\Company;
use App\Models\Recruiter;
use App\Models\CompanyRecruiter;
use App\Http\Requests\ChangeStatusRequest;
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
            
            $followRequest = new CompanyRecruiter();
            $followRequest->recruiter_id = $recruiterId;
            $followRequest->company_id = $companyId;
            $followRequest->status = $status;
            $followRequest->from_date = now();
            $followRequest->save();

            return true;

        }
    
        // Prepare update data
        $updateData = ['status' => $status];
    
        // If status is "Active", update from_date with the current date
        if ($status === "Active") {
            $updateData['from_date'] = now(); // Laravel helper for current timestamp
        }
    
        // Update the record
        $followRequest->update($updateData);
    
        return true;
    }

    public function delete(int $companyId, int $recruiterId)
    {
        $company = Company::find($companyId) ?? abort(404);
        $recruiter = Recruiter::find($recruiterId) ?? abort(404);

        $delete = CompanyRecruiter::where('company_id', $company->id)
        ->where('recruiter_id', $recruiter->id)
        ->delete();

        if($delete)
        {
            return redirect()->back()->with('success', 'You delete recruiter from your connection list successfully!');
        }
        else
        {
            return redirect()->back()->with('error', 'Something went wrong, try later');
        }
        
    }
    
    
}