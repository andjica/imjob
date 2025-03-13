<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RecruitmentRequest;
use App\Interfaces\RecruitmentProcessInterface;


class RecruitmentController extends Controller
{
    protected RecruitmentProcessInterface $recruitmentService;

    public function __construct(RecruitmentProcessInterface $recruitmentService)
    {
        $this->recruitmentService = $recruitmentService;
    }

    public function finishRecruitmentProcess(RecruitmentRequest $request): RedirectResponse
    {
        $success = $this->recruitmentService->handleRecruitment($request->candidateId, $request->decision);

        if ($success) {
            return redirect()->back()->with('success', 'Recruitment decision processed successfully.');
        }

        return redirect()->back()->with('error', 'Failed to process recruitment decision.');
    }
}
