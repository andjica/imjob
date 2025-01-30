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
        <form id="scheduleMeetingForm" method="POST" action="/company/freelancer/job/candidate/{{ $candidate->id }}/plan-meeting">
            @csrf
            <input type="hidden" id="candidateId" name="candidate_id" value="{{ $candidate->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Plan a Meeting with Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Meeting Title -->
                    <div class="mb-3">
                        <label for="meetingTitle" class="form-label">Meeting Title</label>
                        <input type="text" class="form-control" id="meetingTitle" name="meeting_title" value="{{ old('meeting_title') }}" required>
                        @error('meeting_title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phase Selection -->
                    <div class="mb-3">
                        <label for="selectPhase" class="form-label">Phase</label>
                        <select class="form-control" id="selectPhase" name="available_subphase_id" required>
                            <option value="">Select a Phase</option>
                            @foreach($availablePhases as $phase)
                                <option value="{{ $phase->id }}" {{ old('available_subphase_id') == $phase->id ? 'selected' : '' }}>
                                    {{ ucfirst($phase->subphase) }}
                                </option>
                            @endforeach
                        </select>
                        @error('available_subphase_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date & Time -->
                    <div class="mb-3">
                        <label for="meetingDate" class="form-label">Date & Time</label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="meetingDate"
                            name="scheduled_at"
                            value="{{ old('scheduled_at', now()->format('Y-m-d\TH:i')) }}"
                            required
                        >
                        @error('scheduled_at') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="meetingDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="meetingDescription" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Hardcoded Contributor Selection -->
                    <div class="mb-3">
                        <label for="meetingContributors" class="form-label">Add Contributors</label>
                        <select class="form-control" id="meetingContributors" name="contributors[]" multiple required>
                            <option value="1" {{ in_array(1, old('contributors', [])) ? 'selected' : '' }}>John Doe</option>
                            <option value="2" {{ in_array(2, old('contributors', [])) ? 'selected' : '' }}>Jane Smith</option>
                            <option value="3" {{ in_array(3, old('contributors', [])) ? 'selected' : '' }}>Mike Johnson</option>
                            <option value="4" {{ in_array(4, old('contributors', [])) ? 'selected' : '' }}>Emily Davis</option>
                        </select>
                        <small class="form-text text-muted">Select one or more contributors for this meeting.</small>
                        @error('contributors') <span class="text-danger">{{ $message }}</span> @enderror
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
