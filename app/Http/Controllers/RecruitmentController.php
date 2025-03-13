<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Candidate;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RecruitmentProcess;
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
        $recruitmentProcessId = $request->recruitment_process_id;
    
        if (!$recruitmentProcessId) {
            return redirect()->back()->with('error', 'Recruitment process ID is missing.');
        }
    
        // Call the service with the correct ID
        $success = $this->recruitmentService->handleRecruitment($recruitmentProcessId, $request);
    
        if ($success) {
            return redirect()->back()->with('success', 'Recruitment decision processed successfully.');
        }
    
        return redirect()->back()->with('error', 'Failed to process recruitment decision.');
    }

    public function downloadPDF($recruitmentProcessId)
    {
        $recruitmentProcess = RecruitmentProcess::with(['candidate.user', 'candidate.job', 'subphases.availableSubphase'])->findOrFail($recruitmentProcessId);

        $candidate = $recruitmentProcess->candidate;
        $user = $candidate->user;
        $job = $candidate->job;
    
        // Define recruitment phases based on job type
        if ($job->job_world_type === Job::TYPE_INTERNATIONAL) {
            $phases = [
                RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
                RecruitmentProcess::SELECTION => 'Selection',
                RecruitmentProcess::PREPARATION => 'Preparation',
                RecruitmentProcess::TRANSFER => 'Transfer',
                RecruitmentProcess::OFFER_STAGE => 'Offer Stage', 
            ];
        } else { // If job is National
            $phases = [
                RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
                RecruitmentProcess::SELECTION => 'Selection',
                RecruitmentProcess::OFFER_STAGE => 'Offer Stage', 
            ];
        }
    
        // Determine the current phase index
        $currentPhaseIndex = array_search($recruitmentProcess->current_phase, array_keys($phases));
    
        $pdf = Pdf::loadView('pdf.recruitment_overview', compact('recruitmentProcess', 'candidate', 'user', 'job', 'phases', 'currentPhaseIndex'));
    
        return $pdf->download('Recruitment_Process_Overview.pdf');
    }
    
}
