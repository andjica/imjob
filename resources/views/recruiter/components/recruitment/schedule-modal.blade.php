
<!-- Schedule Meeting Modal -->
<div class="modal fade" id="scheduleMeetingModal" tabindex="-1" aria-labelledby="scheduleMeetingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="scheduleMeetingForm" method="POST" action="{{asset('/recruiter/job/candidate/'.$candidate->id.'/plan-meeting')}}">
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
                        <input type="text" class="form-control" id="meeting_title" name="meeting_title" value="{{ old('meeting_title') }}">
                        <span class="text-danger" id="meeting_titleError">@error('meeting_title') {{ $message }} @enderror</span>
                    </div>
                        <!-- Meeting Link -->
                        <div class="mb-3">
                        <label for="meetingLink" class="form-label">Meeting Link</label>
                        <input type="text" class="form-control" id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}">
                        <span class="text-danger" id="meeting_linkError">@error('meeting_link') {{ $message }} @enderror</span>
                        <small>For live version we will put correct validation for GOOGLE MET LINK</small>
                    </div>
                    @php
                        $filteredPhases = collect($availablePhases)->reject(function ($phase) {
                            return strtolower($phase->subphase) === 'other';
                        });
                    @endphp

                    <!-- Phase Selection -->
                    <div class="mb-3">
                        <label for="selectPhase" class="form-label">Phase</label>
                        <select class="form-control" id="select_phase" name="available_subphase_id">
                            <option value="">Select a Phase</option>
                            @foreach($filteredPhases as $phase)
                                <option value="{{ $phase->id }}" data-name="{{ ucfirst($phase->subphase) }}"
                                    {{ old('available_subphase_id') == $phase->id ? 'selected' : '' }}>
                                    {{ ucfirst($phase->subphase) }}
                                </option>
                            @endforeach

                            <!-- Manually adding "Other" option (only one time) -->
                            <option value="other">Other</option>
                        </select>
                        <span class="text-danger" id="select_phaseError">@error('available_subphase_id') {{ $message }}@enderror</span>
                    </div>

                    <!-- Custom Phase Input (Hidden by Default) -->
                    <div class="mb-3" id="customPhaseContainer" style="display: none;">
                        <label for="customPhase" class="form-label">Custom Phase</label>
                        <input type="text" class="form-control" id="custom_phase" name="custom_phase" placeholder="Enter custom phase">
                        <span class="text-danger" id="custom_phaseError"></span>
                    </div>

                    <!-- Date & Time -->
                    <div class="mb-3">
                        <label for="meetingDate" class="form-label">Date & Time</label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="meeting_date"
                            name="scheduled_at"
                            value="{{ old('scheduled_at', now()->format('Y-m-d\TH:i')) }}"
                            required
                        >
                       <span class="text-danger" id="meeting_dateError"> @error('scheduled_at') {{ $message }} @enderror</span>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="meetingDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="meeting_description" name="description" rows="3">{{ old('description') }}</textarea>
                        <span class="text-danger" id="meeting_descriptionError">@error('description'){{ $message }} @enderror</span>
                    </div>

                    <!-- Hardcoded Contributor Selection -->
                    <div class="mb-3">
                        <label for="meeting_contributors" class="form-label">Add Contributors</label>
                        <select class="form-control" id="meeting_contributors" name="contributors[]" multiple data-placeholder="Select contributors...">
                            @foreach($contributors as $contributor)
                                <option value="{{ $contributor->id }}" {{ in_array($contributor->id, old('contributors', [])) ? 'selected' : '' }}>
                                    {{ $contributor->name }}
                                </option>
                            @endforeach
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
