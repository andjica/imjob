<?php

namespace App\Services;

use App\Interfaces\RecruitmentProcessInterface;
use App\Models\Candidate;
use Illuminate\Support\Facades\Log;
use Exception;

class RecruitmentProcessService implements RecruitmentProcessInterface
{
    /**
     * Handle recruitment process by finding the candidate and updating the status.
     *
     * @param int $candidateId
     * @param string $decision
     * @return bool
     */
    public function handleRecruitment(int $candidateId, string $decision): bool
    {
        try {
            $candidate = Candidate::findOrFail($candidateId);

            if ($decision === 'hire') {
                $candidate->status = 'hired';
            } elseif ($decision === 'refuse') {
                $candidate->status = 'refused';
            } else {
                return false; // Invalid decision
            }

            return $candidate->save();
        } catch (Exception $e) {
            Log::error('Recruitment process failed: ' . $e->getMessage());
            return false;
        }
    }
}
