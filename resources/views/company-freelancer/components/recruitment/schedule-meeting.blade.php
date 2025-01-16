
<div class="card">
        <div class="card-header">
            <h3 class="card-title">Schedule a Meeting</h3>
            <div class="card-toolbar">
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#scheduleMeetingModal">
                    Plan Meeting
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Metronic Classic Calendar Integration -->
            <div id="meetingCalendar"></div>
        </div>
    </div>



<!-- Schedule Meeting Modal -->
<div class="modal fade" id="scheduleMeetingModal" tabindex="-1" aria-labelledby="scheduleMeetingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scheduleMeetingForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Plan a Meeting with Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="meetingTitle" class="form-label">Meeting Title</label>
                        <input type="text" class="form-control" id="meetingTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="meetingDate" class="form-label">Date & Time</label>
                        <input type="text" class="form-control" id="meetingDate" placeholder="Select Date & Time" required>
                    </div>
                    <div class="mb-3">
                        <label for="meetingDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="meetingDescription" rows="3" required></textarea>
                    </div>
                    <!-- Contributor Field -->
                    <div class="mb-3">
                        <label for="meetingContributors" class="form-label">Add Contributors</label>
                        <select class="form-control" id="meetingContributors" multiple="multiple" required>
                            <!-- Example Contributors -->
                            <option value="1">John Doe</option>
                            <option value="2">Jane Smith</option>
                            <option value="3">Mike Johnson</option>
                            <!-- Dynamically populate this list from your database -->
                        </select>
                        <small class="form-text text-muted">Select one or more contributors to include in this meeting.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Schedule Meeting</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>