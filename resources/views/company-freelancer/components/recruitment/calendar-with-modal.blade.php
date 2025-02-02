<div class="card">
        <div class="card-body">
            <div id="meetingCalendar"></div>
        </div>
</div>

        <!-- Metronic Classic Calendar Integration -->        
        <!-- Metronic 8 Bootstrap Modal with Icons & Animations -->
        <div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                        <i class="fas fa-calendar-alt"></i> <span id="meetingTitle"></span>

                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-clock text-primary me-2 fs-4"></i>
                        <p class="m-0"><strong>Date & Time:</strong> <span id="meetingDate"></span></p>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-comment-alt text-success me-2 fs-4"></i>
                        <p class="m-0"><strong>Description:</strong> <span id="meetingDescription"></span></p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-link text-danger me-2 fs-4"></i>
                        <p class="m-0"><strong>Meeting Link:</strong> 
                            <a id="meetingLink" href="#" target="_blank" class="text-decoration-none text-danger fw-bold"></a>
                        </p>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>



