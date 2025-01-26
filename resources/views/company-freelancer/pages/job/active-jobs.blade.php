@extends('company-freelancer.template-company-freelancer')

@section('main-title', 'Active Jobs')

@section('title-dash', 'This is active on mobile app')

@section('css')
  <link rel="stylesheet" href="{{asset('/css/custom/job-card.css')}}">
@endsection

@section('content')
<div class="container">
        <!-- Search Box -->
        <div class="row search-container">
            <div class="col-md-12">
                <input type="text" class="search-input" placeholder="Search active jobs...">
            </div>
        </div>
        <!-- Active Job Cards -->
        <div class="row">
            <!-- Card  -->
            @foreach($jobs as $job)
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="card card-job">
                    <div class="card-header">
                        <div>
                            @if($job->job_world_type == "International")
                            <span class="badge badge-primary mb-5">International</span>
                            @else
                            <span class="badge badge-warning mb-5">National</span>
                            @endif
                            <h5 class="card-title">{{$job->title}}</h5>
                            <p class="card-text">Location: {{$job->city->name}}, {{$job->country->name}}</p>
                        </div>
                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i class="fas fa-pencil-alt edit-icon" data-bs-toggle="modal" data-bs-target="#statusModal"
                            data-job="{{$job->title}}"></i>
                    </a>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Valid Until:</strong> {{ \Carbon\Carbon::parse($job->valid_until)->format('d F Y') }}</p>
                        <p class="card-text"><strong>Salary:</strong> {{$job->salary_min}} - {{$job->salary_max}} {{$job->country->currency_symbol}}</p>
                        <p class="card-text job-type">Job Type: {{$job->jobType->name}}</p>
                        <p class="card-text"><strong>Recruiter:</strong> John Doe</p>
                    </div>
                        <a href="{{asset('/company/freelancer/jobId='.$job->id.'/recruitment-process')}}" class="btn btn-sm btn-light-primary">Check recruitment process</a>
                
                </div>
            </div>
            @endforeach
            {{$jobs->links()}}
            <!-- End card -->
        </div>
</div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusModal = document.getElementById('statusModal');
            const jobNameSpan = document.getElementById('job-name');
            const jobStatusSelect = document.getElementById('job-status');
            let currentJob = null;

            // Handle pencil icon click
            document.querySelectorAll('.edit-icon').forEach(icon => {
                icon.addEventListener('click', () => {
                    currentJob = icon.dataset.job;
                    jobNameSpan.textContent = currentJob;
                });
            });

            // Save changes
            document.getElementById('save-status').addEventListener('click', () => {
                const selectedStatus = jobStatusSelect.value;
                console.log(`Job: ${currentJob}, Status: ${selectedStatus}`);
                // Add your logic to save the status (e.g., send an AJAX request to update the database)
                const modal = bootstrap.Modal.getInstance(statusModal);
                modal.hide();
            });
        });
    </script>
@endsection
