<?php

namespace App\Interfaces;

use App\Models\Candidate;

interface RecruitmentProcessInterface
{
    /**
     * Handle recruitment process for a given candidate ID and decision.
     *
     * @param int $candidateId
     * @param string $decision
     * @return bool
     */
    public function handleRecruitment(int $candidateId, string $decision): bool;
}
