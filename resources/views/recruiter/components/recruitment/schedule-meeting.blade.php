@if($candidate->recruitmentProcess->current_phase == "offer_stage" && $candidate->recruitmentProcess->status != null)

@else
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Schedule a Meeting</h3>
        <div class="card-toolbar">
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#scheduleMeetingModal">
                Plan Meeting
            </button>
        </div>
    </div>
</div>

@endif