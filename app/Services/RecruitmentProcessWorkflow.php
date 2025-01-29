<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\RecruitmentProcess;
use App\Models\RecruitmentSubphase;

class RecruitmentProcessWorkflow
{
    public function create(Candidate $candidate): RecruitmentProcess
    {
        $recruitmentProcess = new RecruitmentProcess();
        $recruitmentProcess->fill([
            'candidate_id' => $candidate->id,
        ]);
        $recruitmentProcess->save();

        return $recruitmentProcess;
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
