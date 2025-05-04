@extends('contributor.template-contributor')
@section('main-title', 'Your Assigned Meetings')
@section('title-dash', 'Recruitment Subphases')

@section('content')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
        </div>
    </div>
    <div class="row">
        <div class="btn-back">
            <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white p-2 mb-5">
                <i class="fa fa-chevron-left text-white"></i> Back
            </button>
        </div>
    </div>

    @if ($subphases->count() == 0)
        <div class="row">
            <div class="col-lg-7">
                <div class="card card-flush shadow-sm mb-5">
                    <div class="card-body text-center">
                        <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path opacity="0.3"
                                        d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"
                                        fill="currentColor" />
                                    <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1">No assigned meetings</h4>
                                <p class="mb-0">You currently have no assigned recruitment tasks.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title">Your Assigned Recruitment Subphases</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($subphases as $sub)
                        <div class="col-md-6">
                            <div class="card border shadow-sm p-3">
                                <h5 class="mb-2 text-dark">Candidate: <strong>{{ $sub['candidate_name'] }}</strong></h5>
                                <p class="mb-1"><strong>Phase:</strong> {{ ucfirst($sub['phase']) }}</p>
                                <p class="mb-1"><strong>Subphase:</strong> {{ $sub['subphase'] }}</p>
                                <p class="mb-1"><strong>Meeting:</strong> {{ $sub['meeting_title'] ?? 'No Title' }}</p>
                                <p class="mb-1"><strong>Scheduled At:</strong> {{ \Carbon\Carbon::parse($sub['scheduled_at'])->format('d M Y, H:i') }}</p>
                                <p class="mb-1"><strong>Description:</strong> {{ $sub['description'] }}</p>
                                @if (!empty($sub['feedback']))
                                    <div class="alert alert-info mt-2 p-2">
                                        <strong>Recruiter Feedback:</strong><br>
                                        {{ $sub['feedback'] }}
                                    </div>
                                @elseif ($sub['meeting_link'])
                                    <a href="{{ $sub['meeting_link'] }}" class="btn btn-sm btn-primary mt-2" target="_blank">Join Meeting</a>
                                @else
                                    <span class="badge bg-secondary mt-2">No meeting link</span>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
