<?php

namespace App\Services;

use App\Models\RecruitmentProcess;
use App\Models\RecruitmentSubphase;
use Symfony\Component\HttpFoundation\Response;

class RecruitmentSubphaseService
{
    public function __construct(private TransactionService $transactionService)
    {

    }

    public function createSubphase(RecruitmentProcess $process, array $data): ?RecruitmentSubphase
    {
        $existingSubphase = RecruitmentSubphase::where('recruitment_process_id', $data['recruitment_process_id'])
            ->where('completed', false)
            ->first()
        ;

        if ($existingSubphase) {
            throw new \LogicException("Cannot create a new subphase while an uncompleted subphase exists for the recruitment process.", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->transactionService->run(function () use ($data) {
            return RecruitmentSubphase::create([
                'recruitment_process_id' => $data['recruitment_process_id'],
                'phase' => $data['phase'],
                'subphase' => $data['subphase'],
                'scheduled_at' => $data['scheduled_at'] ?? null,
                'meeting_link' => $data['meeting_link'] ?? null,
                'meeting_title' => $data['meeting_title'] ?? null,
                'description' => $data['description'] ?? null,
                'completed' => false,
                'feedback' => null,
            ]);
        });
    }
}
