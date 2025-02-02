@php
    use App\Models\Job;
    use App\Models\RecruitmentProcess;

    // Define recruitment phases
    $phases = [
        RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
        RecruitmentProcess::SELECTION => 'Selection',
        RecruitmentProcess::PREPARATION => 'Preparation',
        RecruitmentProcess::TRANSFER => 'Transfer',
        RecruitmentProcess::OFFER_STAGE => 'Offer Stage',
    ];

    // Remove unnecessary phases for National jobs
    if ($candidate->job->job_world_type === Job::TYPE_NATIONAL) {
        unset($phases[RecruitmentProcess::PREPARATION], $phases[RecruitmentProcess::TRANSFER]);
    }

    // Determine the current phase index
    $currentPhaseIndex = array_search($recruitmentProcess->current_phase, array_keys($phases));
@endphp

<!-- Candidate Recruitment Process Overview -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recruitment Process Overview</h3>
    </div>
    <div class="card-body">
        
        <!-- Candidate Information -->

        <!-- Recruitment Process Table -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <!-- Small Candidate Info Card Above Table -->
                <div class="card shadow-sm mb-3 text-center p-2">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/300-2.jpg') }}" 
                            alt="{{ $candidate->user->first_name }} {{ $candidate->user->last_name }}" 
                            class="rounded-circle me-2" width="45" height="45">

                        <div>
                            <h6 class="mb-0">{{ $candidate->user->first_name }} {{ $candidate->user->last_name }}</h6>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                <i class="fa fa-envelope me-1"></i> {{ $candidate->user->email }} |
                                <i class="fa fa-phone me-1"></i> {{ $candidate->phone }} |
                                <i class="fa fa-map-marker-alt me-1"></i> {{ $candidate->city }}, {{ $candidate->country }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Arrow pointing to 'Application Received' -->
                <div class="text-center mb-2">
                    <i class="fa-solid fa-arrow-down text-primary fs-4"></i>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                @foreach ($phases as $phaseName)
                                    <th class="text-center">{{ $phaseName }}</th>
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
                                        $subphases = $recruitmentProcess->subphases->where('phase', $phaseKey)->sortBy('completed');
                                    @endphp

                                    <td class="text-center">
                                        <!-- Completed Phase -->
                                        @if ($isCompleted)
                                            <span class="badge badge-success">Completed</span><hr>
                                            @foreach ($subphases as $subphase)
                                                <div class="mt-1">
                                                    <b>{{ $loop->iteration }}. {{ $subphase->availableSubphase->subphase }}</b>
                                                    @if ($subphase->completed)
                                                        <b class="text-success">✔</b><br>
                                                        <span class="text-muted">Feedback: "{{ $subphase->feedback }}"</span>
                                                    @endif
                                                </div>
                                            @endforeach

                                        <!-- Current Phase -->
                                        @elseif ($isCurrent)
                                            <span class="badge badge-warning">Current</span><hr>
                                            @foreach ($subphases as $subphase)
                                                <div class="mt-1">
                                                    <b>{{ $loop->iteration }}. {{ $subphase->availableSubphase->subphase }}</b>
                                                    @if ($subphase->completed)
                                                        <b class="text-success">✔</b><br>
                                                        <span class="text-muted">Feedback: "{{ $subphase->feedback }}"</span>
                                                    @else
                                                        <!-- Action Buttons -->
                                                        <button class="btn btn-light-success btn-sm" data-bs-toggle="modal" data-bs-target="#feedbackModal-{{ $subphase->id }}">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePhaseModal-{{ $subphase->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach

                                        <!-- Upcoming Phase -->
                                        @else
                                            <span class="badge badge-secondary">Upcoming</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Advance to Next Step Button -->
                <form method="POST" action="{{ asset('/company/freelancer/recruitment-process/'.$recruitmentProcess->id.'/advance') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm mt-3">
                        Advance to Next Step
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
