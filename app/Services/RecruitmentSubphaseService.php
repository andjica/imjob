<?php

namespace App\Services;

use App\Models\RecruitmentSubphase;
use Symfony\Component\HttpFoundation\Response;

class RecruitmentSubphaseService
{
    public function __construct(private TransactionService $transactionService)
    {

    }

    private const ALLOWED_SUBPHASES = [
        'selection' => [
            'interview 1',
            'interview 2',
            'interview 3',
            'professional interview',
            'language proficiency check',
            'other',
        ],
        'preparation' => [
            'language course',
            'visa request',
            'visa issuance',
            'cultural mediation',
            'other',
        ],
        'transfer' => [
            'travel organization',
            'candidate reception',
            'other',
        ],
        'offer_stage' => [
            'administrative preparation',
            'employment date',
            'other',
        ],
    ];

    public function createSubphase(array $data): ?RecruitmentSubphase
    {
        if (!isset(self::ALLOWED_SUBPHASES[$data['phase']]) || !in_array($data['subphase'], self::ALLOWED_SUBPHASES[$data['phase']])) {
            throw new \InvalidArgumentException("Invalid subphase '{$data['subphase']}' for phase '{$data['phase']}'", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
