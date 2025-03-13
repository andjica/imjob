<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Process Overview</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; font-size: 22px; font-weight: bold; margin-bottom: 20px; }
        .content { border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .status { font-weight: bold; color: #6234D5; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .table th { background-color: #f2f2f2; }
        .badge { padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-secondary { background-color: #6c757d; color: white; }
        .badge-primary { background-color: #007bff; color: white; }
        .text-muted { color: gray; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">Recruitment Process Overview</div>

    <!-- Candidate & Job Information -->
    <div class="content">
        <p><strong>Candidate:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Candidate ID:</strong> {{ $recruitmentProcess->candidate_id }}</p>
        <p><strong>Job Type:</strong> {{ $job->job_world_type === \App\Models\Job::TYPE_INTERNATIONAL ? 'International' : 'National' }}</p>
        <p><strong>Current Phase:</strong> {{ ucfirst($recruitmentProcess->current_phase) }}</p>
        <p><strong>Status:</strong> <span class="status">{{ ucfirst($recruitmentProcess->status) }} at {{$recruitmentProcess->updated_at}}</span></p>
    </div>

    <!-- Phases Table -->
    <table class="table">
        <thead>
            <tr>
                @foreach ($phases as $phaseName)
                    <th>{{ $phaseName }}</th>
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

                    <td>
                        @if ($isCompleted)
                            <span class="badge badge-success">Completed</span>
                            <hr>
                            @foreach ($subphases as $subphase)
                                <div>
                                    <b>{{ $loop->iteration }}. {{ $subphase->availableSubphase->subphase }}</b>
                                    @if ($subphase->completed)
                                        <b class="text-success">✔</b><br>
                                        <span class="text-muted">Feedback: "{{ $subphase->feedback }}"</span>
                                    @endif
                                </div>
                            @endforeach
                        @elseif ($isCurrent)
                            @if($recruitmentProcess->current_phase == "offer_stage" && $recruitmentProcess->status != null)
                                <span class="badge badge-primary">FINISHED</span>
                            @else
                                <span class="badge badge-warning">Current</span>
                            @endif
                            <hr>
                            @foreach ($subphases as $subphase)
                                <div>
                                    <b>{{ $subphase->availableSubphase->subphase }}</b>
                                    @if ($subphase->completed)
                                        <b class="text-success">✔</b><br>
                                        <span class="text-muted">Feedback: "{{ $subphase->feedback }}"</span>
                                    @else
                                        <br>Scheduled: {{ \Carbon\Carbon::parse($subphase->scheduled_at)->format('d M Y, H:i') }}
                                        <br><small>{{ $subphase->meeting_title }}</small>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <span class="badge badge-secondary">Upcoming</span>
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>
</html>
