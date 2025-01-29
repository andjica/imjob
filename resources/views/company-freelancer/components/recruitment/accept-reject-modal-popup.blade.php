<!-- Accept Candidate Modal -->
<div class="modal fade" id="acceptCandidateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-check me-2"></i> Accept Candidate
                </h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center">
                <i class="fas fa-user-check text-success fa-4x mb-3"></i>
                <h4 class="fw-bold text-dark" id="acceptCandidateName"></h4>
                <p class="text-muted fs-5">
                    Are you sure you want to <strong class="text-success">accept</strong> this candidate?
                </p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <form action="{{ asset('company/freelancer/job/candidate/'.$candidate->id.'/change-status') }}" method="POST" class="d-inline">
                @csrf
                @method('PUT') 

                <button type="submit" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-check me-1"></i> Accept
                </button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Candidate Modal -->
<div class="modal fade" id="rejectCandidateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-times me-2"></i> Reject Candidate
                </h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center">
                <i class="fas fa-user-times text-danger fa-4x mb-3"></i>
                <h4 class="fw-bold text-dark" id="rejectCandidateName"></h4>
                <p class="text-muted fs-5">
                    Are you sure you want to <strong class="text-danger">reject</strong> this candidate?
                </p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger btn-lg px-4">
                    <i class="fas fa-trash me-1"></i> Reject
                </button>
            </div>
        </div>
    </div>
</div>
