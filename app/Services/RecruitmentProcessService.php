<?php

namespace App\Services;

use Exception;
use App\Models\RecruitmentProcess;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RecruitmentRequest;
use App\Interfaces\RecruitmentProcessInterface;

class RecruitmentProcessService implements RecruitmentProcessInterface
{
    /**
     * Handle recruitment process by updating the status.
     *
     * @param int $recruitmentProcessId
     * @param RecruitmentRequest $request
     * @return bool
     */
    public function handleRecruitment(int $recruitmentProcessId, RecruitmentRequest $request): bool
    {
        try {
            // Find the recruitment process record by ID
            $recruitmentProcess = RecruitmentProcess::findById($recruitmentProcessId);

            if (!$recruitmentProcess) {
                Log::error('Recruitment process not found with ID: ' . $recruitmentProcessId);
                return false;
            }

            // Update status based on the decision
            if ($request->decision === 'hire') {
                $recruitmentProcess->status = 'hired';
            } elseif ($request->decision === 'refuse') {
                $recruitmentProcess->status = 'refused';
            } else {
                return false; // Invalid decision
            }

            return $recruitmentProcess->save();
        } catch (Exception $e) {
            Log::error('Recruitment process update failed: ' . $e->getMessage());
            return false;
        }
    }
}
