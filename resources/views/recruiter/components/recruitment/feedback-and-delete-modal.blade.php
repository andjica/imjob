
@foreach ($phases as $phaseKey => $phaseName)
    @foreach ($recruitmentProcess->subphases->where('phase', $phaseKey)->sortBy('completed') as $subphase)
        <!-- Feedback Modal -->
        <div class="modal fade" id="feedbackModal-{{ $subphase->id }}" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="feedbackForm" method="POST" data-subphase-id="{{ $subphase->id }}" action="{{asset('recruiter/recruitment-subphase/'.$subphase->id.'/complete')}}">
                @csrf    
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Submit Feedback for "{{ $subphase->availableSubphase->subphase }}"</h5>
                            <button type="button" class="btn-close modal-close" data-modal-id="feedbackModal-{{ $subphase->id }}" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Subphase:</strong> {{ $subphase->availableSubphase->subphase }}</p>
                            <label for="feedbackComment-{{ $subphase->id }}" class="form-label">Your Comment</label>
                            <textarea class="form-control feedbackComment" id="feedbackComment-{{ $subphase->id }}" name="feedback" rows="4" placeholder="Enter your feedback here..."></textarea>
                            <span id="feedbackError-{{ $subphase->id }}" class="text-danger small" style="display:none;">Please enter a comment.</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary modal-close" data-modal-id="feedbackModal-{{ $subphase->id }}">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

      
        <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePhaseModal-{{ $subphase->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete for "{{ $subphase->availableSubphase->subphase }}"</h5>
                    <button type="button" class="btn-close modal-close" data-modal-id="deletePhaseModal-{{ $subphase->id }}" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the subphase "<strong>{{ $subphase->availableSubphase->subphase }}</strong>"?</p>
                </div>
                <div class="modal-footer">
                    <form class="deleteForm" action="{{asset('/recruiter/recruitment-subphase/'.$subphase->id.'/delete')}}" method="POST" data-modal-id="deletePhaseModal-{{ $subphase->id }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary modal-close" data-modal-id="deletePhaseModal-{{ $subphase->id }}">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @endforeach
@endforeach