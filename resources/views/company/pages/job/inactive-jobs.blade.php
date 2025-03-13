@extends('company.template-company')

@section('main-title', 'Inactive Jobs')

@section('title-dash', 'This jobs are expired and they are not available on mobile app')

@section('css')
  <link rel="stylesheet" href="{{asset('/css/custom/job-card.css')}}">
@endsection

@section('content')
<div class="container m-0">
        <!-- Search Box -->
        <div class="row search-container">
            <div class="col-md-12">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i class="fa fa-chevron-left text-white"></i> Back</button>
                <input type="text" class="search-input" placeholder="Search inactive jobs...">
            </div>
        </div>
        @include('alerts.success')
        @include('alerts.errors')
        @if($jobs->count() == 0)
        <div class="row">
            <div class="col-lg-7">
            <div class="card card-flush shadow-sm mb-5">
                <div class="card-body text-center">
                    <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                        <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                            <!-- Metronic SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                                <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1">No jobs Found</h4>
                            <p>There are currently no inactive jobs in the system. To manage active jobs that have not yet expired, visit the <a href="{{asset('/company/dashboard/active/jobs')}}">
                                Active Jobs</a> page.</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @else
        <!-- Inactive Job Cards -->
        <div class="row">
            <div class="col-lg-3">
                @include('company.components.job.sidebar-job')
            </div>
            <div class="col-lg-8">
            <div class="row">
            <!-- Card  -->
            @foreach($jobs as $job)
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="card card-job">
                    <div class="card-header">
                        <div>
                            @if($job->job_world_type == "International")
                            <span class="badge badge-primary mb-5">International</span>
                            <span class="badge badge-dark">Expired on mobile</span>
                            @else
                            <span class="badge badge-warning mb-5">National</span>
                            <span class="badge badge-dark">Expired on mobile</span>
                            @endif
                            <h5 class="card-title">{{$job->title}}</h5>
                            <p class="card-text">Location: {{$job->city->name}}, {{$job->country->name}}</p>
                            <p>For company: {{$job->company->name}}</p>
                        </div>

                    </div>
                    <div class="card-body">
                        <p class="card-text"><strong>Expired at:</strong> {{ \Carbon\Carbon::parse($job->valid_until)->format('d F Y') }}</p>
                        <p class="card-text"><strong>Salary:</strong> {{$job->salary_min}} - {{$job->salary_max}} {{$job->country->currency_symbol}}</p>
                        <p class="card-text job-type">Job Type: {{$job->jobType->name}}</p>
                        <p class="card-text"><strong>Recruiter:</strong> John Doe</p>
                    </div>
                        <a href="{{asset('/company/freelancer/'.$job->id.'/recruitment-process')}}" class="btn btn-sm btn-light-primary">Go to recruitment process</a>

                </div>
            </div>
            @endforeach
            {{$jobs->links()}}
            <!-- End card -->
            </div>
        </div>
        </div>
        @endif
</div>
@endsection

@section('js')

@endsection
