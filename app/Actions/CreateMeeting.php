<?php

namespace App\Actions;

use App\Models\AvailableRecruitmentSubphases;
use App\Models\Candidate;
use App\Models\RecruitmentSubphase;
use App\Services\TransactionService;
use Exception;

class CreateMeeting
{
    public function __construct(private TransactionService $transactionService)
    {

    }

    /**
     * @throws Exception
     */
    public function execute(Candidate $candidate, array $data): RecruitmentSubphase
    {
        $this->validateSubphase($candidate, $data);

        $recruitmentProcess = $candidate->recruitmentProcess;

        return $this->transactionService->run(function () use ($candidate, $recruitmentProcess, $data) {
            /** @var RecruitmentSubphase $subphase */
            $subphase = RecruitmentSubphase::create([
                'phase' => $recruitmentProcess->current_phase,
                'recruitment_process_id' => $recruitmentProcess->id,
                'available_subphase_id' => $data['available_subphase_id'],
                'scheduled_at' => $data['scheduled_at'],
                'description' => $data['description'],
                'meeting_title' => $data['meeting_title'],
            ]);

            if ($subphase && !empty($data['contributors'])) {
                $subphase->contributors()->attach($data['contributors']);
            }

            return $subphase;
        });
    }

    /**
     * @throws Exception
     */
    private function validateSubphase(Candidate $candidate, array $data): void
    {
        $recruitmentProcess = $candidate->recruitmentProcess;

        if (!$recruitmentProcess) {
            throw new Exception("Cannot schedule meeting.");
        }

        $availableSubphase = AvailableRecruitmentSubphases::find($data['available_subphase_id']);

        if (!$availableSubphase) {
            throw new Exception("Subphase not found.");
        }

        if ($availableSubphase->phase !== $recruitmentProcess->current_phase) {
            throw new Exception("Invalid subphase.");
        }
    }
}
