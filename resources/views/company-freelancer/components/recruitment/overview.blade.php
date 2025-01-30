@php
    use App\Models\RecruitmentProcess;

    $phases = [
        RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
        RecruitmentProcess::SELECTION => 'Selection',
        RecruitmentProcess::PREPARATION => 'Preparation',
        RecruitmentProcess::TRANSFER => 'Transfer',
        RecruitmentProcess::OFFER_STAGE => 'Offer Stage',
    ];

    $currentPhaseIndex = array_search($recruitmentProcess->current_phase, array_keys($phases));
@endphp

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recruitment Process Overview</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Recruitment Process Table -->
            <div class="col-lg-8 mb-4">
                <div class="table-responsive">
                    <table class="recruitment-process-table">
                        <thead>
                        <tr>
                            @foreach ($phases as $phaseName)
                                <th>{{ $phaseName }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach ($phases as $phaseKey => $phaseName)
                                @php
                                    $index = array_search($phaseKey, array_keys($phases));
                                    $isCurrent = $index === $currentPhaseIndex;
                                    $isCompleted = $index < $currentPhaseIndex;
                                    $isUpcoming = $index > $currentPhaseIndex;
                                    $subphases = $recruitmentProcess->subphases->where('phase', $phaseKey)->sortBy('completed');
                                @endphp

                                <td>
                                    @if ($isCompleted)
                                        <span class="badge badge-success">Completed</span>
                                    @elseif ($isCurrent)
                                        <span class="badge badge-warning">Current</span><br>

                                        @if ($subphases->isNotEmpty())
                                            @foreach ($subphases as $subphase)
                                                <div class="mt-1">
                                                        <span class="text-primary">- {{ $subphase->availableSubphase->subphase }}
                                                            @if ($subphase->completed)
                                                                <span class="badge badge-success">✔ Done</span>
                                                            @endif
                                                        </span>

                                                    @if (!$subphase->completed)
                                                        <!-- Complete Button -->
                                                        <button class="btn btn-light-success btn-xs p-1" data-bs-toggle="modal"
                                                                data-bs-target="#feedbackModal-{{ $subphase->id }}">
                                                            <i class="fa-solid fa-check" style="font-size: 0.75rem;"></i>
                                                        </button>

                                                        <!-- Drop Phase Button -->
                                                        <button class="btn btn-light-danger btn-xs p-1" data-bs-toggle="modal"
                                                                data-bs-target="#deletePhaseModal-{{ $subphase->id }}">
                                                            <i class="fa-solid fa-trash" style="font-size: 0.75rem;"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                                <!-- Complete Modal -->
                                                <div class="modal fade" id="feedbackModal-{{ $subphase->id }}" tabindex="-1"
                                                     aria-labelledby="feedbackModalLabel-{{ $subphase->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="feedbackModalLabel-{{ $subphase->id }}">Phase Feedback</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Is this subphase complete?</p>
                                                                <textarea class="form-control" rows="3" placeholder="Provide your feedback here..."></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Submit Feedback</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Phase Modal -->
                                                <div class="modal fade" id="deletePhaseModal-{{ $subphase->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <i class="fa-solid fa-exclamation-triangle text-danger fs-3x mb-4"></i>
                                                                    <p class="fs-5">Are you sure you want to delete this subphase? This action cannot be undone.</p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    @else
                                        <span class="badge badge-secondary">Upcoming</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Status Update Button -->
                <button class="btn btn-sm btn-success status-update-btn" id="statusUpdateBtn">
                    Advance to Next Step
                </button>
            </div>
            <!-- End of Recruitment Process Table -->

            <!-- Small User Card -->
            <div class="col-lg-4">
                <div class="candidate-card">
                    <!-- Candidate Profile Picture -->
                    <img src="{{ asset('images/300-2.jpg') }}" alt="Andjela Stojanovic">

                    <!-- Candidate Details -->
                    <div class="candidate-details">
                        <h5>Andjela Stojanovic</h5>
                        <p><i class="fa fa-envelope"></i> andjela.stojanovic@example.com</p>
                        <p><i class="fa fa-phone"></i> +1234567890</p>
                        <p><i class="fa fa-map-marker-alt"></i> 1234 Elm Street, Springfield, USA</p>

                        <!-- Current Status Badge -->
                        <span class="badge badge-warning p-2">
                            First Interview
                        </span>

                        <!-- CV Download Button -->
                        <a href="{{ asset('cv/andjela_stojanovic_cv.pdf') }}" class="badge badge-danger p-2 cv-download-btn" target="_blank">
                            <i class="fa fa-file-pdf text-white"></i> Download CV
                        </a>
                    </div>
                </div>
            </div>
            <!-- End of Small User Card -->
        </div>
    </div>
</div>
