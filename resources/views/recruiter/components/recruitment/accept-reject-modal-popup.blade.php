@foreach($candidates as $candidate)
    <!-- Accept Candidate Modal -->
    <div class="modal fade" id="acceptCandidateModal-{{ $candidate->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-user-check me-2"></i> Accept Candidate
                    </h5>
                    <button type="button" class="btn-close modal-close" data-modal-id="acceptCandidateModal-{{ $candidate->id }}" aria-label="Close"></button>
                    </div>

                <div class="modal-body text-center">
                    <i class="fas fa-user-check text-success fa-4x mb-3"></i>
                    <h4 class="fw-bold text-dark">Candidate: {{ $candidate->user->first_name }} {{ $candidate->user->last_name }}</h4>
                    <p class="text-muted fs-5">
                        Are you sure you want to <strong class="text-success">accept</strong> this candidate?
                    </p>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-light btn-lg px-4 modal-close" data-modal-id="acceptCandidateModal-{{ $candidate->id }}">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <form action="{{ url('/recruiter/job/candidate/'.$candidate->id.'/change-status') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Candidate Status -->
                        <input type="hidden" name="status" value="{{ \App\Models\Candidate::STATUS_ACCEPT }}">

                        <!-- Submitted By (User ID, optional) -->
                        <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}">

                        <button type="submit" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-check me-1"></i> Accept
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Reject Candidate Modal -->
    <div class="modal fade" id="rejectCandidateModal-{{ $candidate->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-user-times me-2"></i> Reject Candidate
                    </h5>
                    <button type="button" class="btn-close modal-close" data-modal-id="rejectCandidateModal-{{ $candidate->id }}" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <i class="fas fa-user-times text-danger fa-4x mb-3"></i>
                    <h4 class="fw-bold text-dark">Candidate: {{ $candidate->user->first_name }} {{ $candidate->user->last_name }}</h4>
                    <p class="text-muted fs-5">
                        Are you sure you want to <strong class="text-danger">reject</strong> this candidate?
                    </p>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-light btn-lg px-4 modal-close" data-modal-id="rejectCandidateModal-{{ $candidate->id }}">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <form action="{{ url('/recruiter/job/candidate/'.$candidate->id.'/change-status') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Candidate Status -->
                        <input type="hidden" name="status" value="{{ \App\Models\Candidate::STATUS_REJECTED }}">
                        <!-- Submitted By (User ID, optional) -->
                        <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}">

                        <button type="submit" class="btn btn-danger btn-lg px-4">
                            <i class="fas fa-times-circle me-1"></i> Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach