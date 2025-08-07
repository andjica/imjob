<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidate CV AI</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 30px;
        }
        h1, h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }
        .section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>AI-Generated Candidate CV
     <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ $base64Image }}" width="120" height="120" style="border-radius: 50%;">
    </div>

    </h1>

    <div class="section">
        <h2>Personal Info</h2>
        <p><span class="label">Name:</span> {{ $candidate->user->first_name }} {{ $candidate->user->last_name }}</p>
        <p><span class="label">Email:</span> {{ $candidate->user->email }}</p>
        <p><span class="label">Phone:</span> {{ $candidate->phone ?? '-' }}</p>
        <p><span class="label">Birthday:</span> {{ $candidate->birthday ? \Carbon\Carbon::parse($candidate->birthday)->format('d M Y') : '-' }}</p>
        <p><span class="label">Location:</span> {{ $candidate->country->name ?? '-' }}, {{ $candidate->city->name ?? '-' }}</p>
    </div>

    <div class="section">
        <h2>Professional Info</h2>
        <p><span class="label">Current Company:</span> {{ $candidate->current_company ?? '-' }}</p>
        <p><span class="label">Job Title:</span> {{ $candidate->current_title_job ?? '-' }}</p>
        <p><span class="label">Years of Experience:</span> {{ $candidate->years_of_experience ?? '0' }}</p>
    </div>

    <div class="section">
        <h2>Education</h2>
        <p><span class="label">School:</span> {{ $candidate->school_name ?? '-' }}</p>
        <p><span class="label">Degree:</span> {{ $candidate->school_degree ?? '-' }}</p>
        <p><span class="label">Start Year:</span> {{ $candidate->school_year_start ?? '-' }}</p>
        <p><span class="label">End Year:</span> {{ $candidate->school_year_end ?? '-' }}</p>
    </div>

    <div class="section">
        <h2>Other</h2>
        <p><span class="label">Finished Profile:</span> {{ $candidate->is_finished_profile ? 'Yes' : 'No' }}</p>
    </div>
</body>
</html>
