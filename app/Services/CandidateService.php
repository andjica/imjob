<?php

namespace App\Services;

use App\Models\Candidate;
use Exception;

class CandidateService
{
    public function __construct(
        private RecruitmentProcessWorkflow $recruitmentProcessWorkflow,
        private TransactionService $transactionService,
    )
    {

    }

    /**
     * @throws Exception
     */
    public function handleCandidate(Candidate $candidate, string $status): Candidate
    {

        if (!in_array($status, [Candidate::STATUS_REJECTED, Candidate::STATUS_ACTIVE])) {
            throw new Exception("Invalid candidate status");
        }

        return $this->transactionService->run(function () use ($candidate, $status) {
            $candidate->status = $status;
            $candidate->save();

            if ($status === Candidate::STATUS_ACTIVE) {
                $this->recruitmentProcessWorkflow->create($candidate);
            }

            return $candidate;
        });
    }
}
