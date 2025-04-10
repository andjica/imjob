<div class="row">
        <div class="col-lg-12">
            <div class="card mb-2">
                <div class="card-body bg-linear-pink rounded-top">
                <div class="tab-content" id="myTabContent">
                <!-- Active Jobs Content -->
                <div class="tab-pane fade show active" id="active-job" role="tabpanel" aria-labelledby="active-jobs-tab">
                    <h5 class="text-white font-weight-bold">{{$candidate->job->job_world_type}} - {{$candidate->job->title}}
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Candidate Recruitment Process Overview -->
<div class="card">
<div class="card-header d-flex flex-column justify-content-center align-items-center text-center">
    <h3 class="card-title mb-2">Recruitment Process Overview for</h3>

    @if($candidate->recruitmentProcess->current_phase == "offer_stage" && $candidate->recruitmentProcess->status != null)
        @if($candidate->recruitmentProcess->status == "hired")
        <span class="badge badge-primary p-2">
            Completed - Candidate is &nbsp;<strong>{{ ucfirst($candidate->recruitmentProcess->status) }}</strong>
        </span>
        @else
        <span class="badge badge-danger p-2">
            Completed - Candidate is &nbsp;<strong>{{ ucfirst($candidate->recruitmentProcess->status) }}</strong>
        </span>
        @endif
     
    @endif
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
                                <i class="fa fa-phone me-1"></i> {{$candidate->candidate->phone}}|
                                <i class="fa fa-map-marker-alt me-1"></i> {{ $candidate->candidate->city->name }}, {{ $candidate->candidate->country->name }}

                                <a href="" class="btn btn-outline-light text-dark btn-sm">
                                        <i class="fas fa-file-download"></i> Download CV
                                    </a>
                            </p>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                    Years of experience: {{ $candidate->candidate->years_of_experience }} |
                                    Currently employed at: {{ $candidate->candidate->current_company }} |
                                    Birthday: {{ \Carbon\Carbon::parse($candidate->candidate->birthday)->format('d.m.Y') }} |
                                    School: {{ $candidate->candidate->school_name }} - {{ $candidate->candidate->school_degree }} 
                                    ({{ $candidate->candidate->school_year_start }} - {{ $candidate->candidate->school_year_end }}) |

                                   
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
                                          @if($candidate->recruitmentProcess->current_phase == "offer_stage" && $candidate->recruitmentProcess->status != null)
                                          <span class="badge badge-primary">FINISHED</span>
                                          @else
                                            <span class="badge badge-warning">Current</span>
                                            @endif
                                            <hr>
                                            @foreach ($subphases as $subphase)
                                                <div class="my-5">
                                                    <b> {{ $subphase->availableSubphase->subphase }}</b>
                                                    @if ($subphase->completed)
                                                        <b class="text-success">✔</b><br>
                                                        <span class="text-muted">Feedback: "{{ $subphase->feedback }}"</span>
                                                    @else<br>
                                                    {{ \Carbon\Carbon::parse($subphase->scheduled_at)->format('d M Y, H:i') }}<br>
                                                    <small>{{$subphase->meeting_title}}</small><br>
                                                        <!-- Action Buttons -->
                                                        <button class="btn btn-light-success btn-sm p-3 me-2 my-3" data-bs-toggle="modal" data-bs-target="#feedbackModal-{{ $subphase->id }}">
                                                            <i class="fa-solid fa-check fa-xs"></i>
                                                        </button>
                                                        <button class="btn btn-light-danger btn-sm p-3 text-small" data-bs-toggle="modal" data-bs-target="#deletePhaseModal-{{ $subphase->id }}">
                                                            <i class="fa-solid fa-trash fa-xs"></i>
                                                        </button>
                                                        <hr>
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
                @if($candidate->recruitmentProcess->current_phase == "offer_stage" 
                    && $candidate->recruitmentProcess->status == null 
                    && $candidate->recruitmentProcess->subphases->where('phase', 'offer_stage')->where('completed', true)->count() > 0)

                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-sm bg-linear-pink text-white fw-light" data-bs-toggle="modal" data-bs-target="#confirmHireRefuseModal">
                        <i class="fa-solid fa-flag-checkered me-1 text-white"></i> Finish
                    </button>

                @elseif($candidate->recruitmentProcess->current_phase == "offer_stage" && $candidate->recruitmentProcess->status != null)

                    <!-- Button to show "Finished" -->
                    <button type="button" class="btn btn-sm bg-linear-pink text-white fw-light" disabled>
                        <i class="fa-solid fa-flag-checkered me-1 text-white"></i> Finished
                    </button>

                @elseif($candidate->recruitmentProcess->current_phase == "offer_stage" && $candidate->recruitmentProcess->status == null)
                    
                    <!-- Disabled Finish Button -->
                    <button type="button" class="btn btn-sm bg-linear-pink text-white fw-light" disabled>
                        <i class="fa-solid fa-flag-checkered me-1 text-white"></i> Finish (Incomplete)
                    </button>

                @else

                    <!-- Advance to Next Step Button -->
                    <form method="POST" action="{{ asset('/recruiter/recruitment-process/'.$recruitmentProcess->id.'/advance') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm mt-3">
                            Advance to Next Step
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Modal for Hiring or Refusing the Candidate -->
<div class="modal fade" id="confirmHireRefuseModal" tabindex="-1" aria-labelledby="confirmHireRefuseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmHireRefuseModalLabel">
                    <i class="fa-solid fa-user-check text-primary me-2"></i> Confirm Decision
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="mb-4">Are you hiring or refusing this candidate for the job?</h4><br><br>
                <form action="{{asset('/company/freelancer/finish/recruitment-process')}}" method="POST">
                    @csrf
                    <!-- <input type="hidden" name="candidateId" value="{{$candidate->candidate_id}}"> -->
                    <input type="hidden" name="recruitment_process_id" value="{{$recruitmentProcess->id}}">
                    <div class="d-flex justify-content-center">
                        <!-- Hire Button -->
                        <button type="submit" name="decision" value="hire" class="btn btn-success me-2">
                            <i class="fa-solid fa-user-check me-1"></i> Hire Candidate
                        </button>

                        <!-- Refuse Button -->
                        <button type="submit" name="decision" value="refuse" class="btn btn-danger me-2">
                            <i class="fa-solid fa-user-times me-1"></i> Refuse Candidate
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa-solid fa-times me-1"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
