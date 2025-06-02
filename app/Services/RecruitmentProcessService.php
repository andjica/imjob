<?php

namespace App\Services;

use Exception;
use App\Models\Candidate;
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
   
    public function getCandidateRecruitmentStatus(int $candidateJobId): array
    {
        $candidate = Candidate::with([
            'candidate.user',
            'job',
            'recruitmentProcess.subphases.availableSubphase',
            'recruitmentProcess.currentSubphase',
        ])->findOrFail($candidateJobId);

        $process = $candidate->recruitmentProcess;

        return [
            'candidate_job_id' => $candidate->id,
            'candidate_first_name' => $candidate->candidate?->user?->first_name,
            'candidate_last_name' => $candidate->candidate?->user?->last_name,
            'job_title' => $candidate->job?->title,
            'current_phase' => $process?->current_phase,
            'current_subphase' => $process?->currentSubphase?->subphase ?? null,
            'subphases' => $process?->subphases->map(function ($sub) {
                return [
                    'subphase_name' => $sub->availableSubphase->subphase ?? $sub->subphase,
                    'phase' => $sub->availableSubphase->phase ?? null,
                    'scheduled_at' => $sub->scheduled_at?->format('Y-m-d H:i'),
                    'meeting_title' => $sub->meeting_title,
                    'meeting_link' => $sub->meeting_link,
                    'completed' => $sub->completed,
                    'feedback' => $sub->feedback,
                ];
            })->toArray(),
        ];
    }
}
