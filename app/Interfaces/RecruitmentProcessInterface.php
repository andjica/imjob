<?php

namespace App\Interfaces;

use App\Http\Requests\RecruitmentRequest;

interface RecruitmentProcessInterface
{
    /**
     * Handle recruitment process for a given recruitment process ID.
     *
     * @param int $recruitmentProcessId
     * @param RecruitmentRequest $request
     * @return bool
     */
    public function handleRecruitment(int $recruitmentProcessId, RecruitmentRequest $request): bool;
    public function getCandidateRecruitmentStatus(int $candidateJobId): array;

}
