<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\RecruitmentProcess;
use App\Models\RecruitmentSubphase;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RecruitmentProcessWorkflow
{
    public function create(Candidate $candidate): RecruitmentProcess
    {
        if ($candidate->status !== Candidate::STATUS_ACCEPT || $candidate->recruitmentProcess) {
            throw new \LogicException("Recruitment process can only be created for accepted candidates.", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return DB::transaction(function () use ($candidate) {
            if ($existingProcess = $candidate->recruitmentProcess) {
                return $existingProcess;
            }

            return RecruitmentProcess::create([
                'candidate_id' => $candidate->id,
                'current_phase' => 'application_received',
            ]);
        });
    }

    public function advance(RecruitmentProcess $process): bool
    {
        $phases = [
            'application_received',
            'selection',
            'preparation',
            'transfer',
            'offer_stage'
        ];

        $currentPhaseIndex = array_search($process->current_phase, $phases, true);

        if ($currentPhaseIndex === false || $currentPhaseIndex >= count($phases) - 1) {
            return false;
        }

        $hasCompletedSubphases = RecruitmentSubphase::where('recruitment_process_id', $process->id)
            ->where('phase', $process->current_phase)
            ->where('completed', true)
            ->exists()
        ;

        if (!$hasCompletedSubphases) {
            return false;
        }

        $process->current_phase = $phases[$currentPhaseIndex + 1];
        $process->save();

        return true;
    }
}
