@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Job')

@section('title-dash', 'Recruitment Process')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/custom/recruitment-process.css')}}"/>

@endsection

@section('content')
<div class="container m-0 pb-5 mt-5" id="leader-line-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-2">
                <div class="card-body card-background-st rounded-top">
                    <div class="tab-content" id="myTabContent">
                        <!-- Active Jobs Content -->
                        <div class="tab-pane fade show active" id="active-job" role="tabpanel" aria-labelledby="active-jobs-tab">
                            <h5 class="text-white font-weight-bold">Internacional job type</h5>
                        </div>
                        <!-- Inactive Jobs Content -->
                        <div class="tab-pane fade" id="inactive-jobs" role="tabpanel" aria-labelledby="inactive-jobs-tab">
                            <h5 class="text-danger font-weight-bold">Inactive Jobs</h5>
                            <p>View and reactivate inactive job postings.</p>
                        </div>
                        <!-- Other Jobs Content -->
                        <div class="tab-pane fade" id="other-jobs" role="tabpanel" aria-labelledby="other-jobs-tab">
                            <h5 class="text-info font-weight-bold">Other Jobs</h5>
                            <p>Browse and explore other available job opportunities.</p>
                        </div>
                        <!-- Create Job Content -->
                        <div class="tab-pane fade" id="create-job" role="tabpanel" aria-labelledby="create-job-tab">
                            <h5 class="text-success font-weight-bold">Create Job</h5>
                            <p>Use this section to create a new job posting.</p>
                            <a href="#" class="btn btn-success mt-3">
                                <i class="fa-solid fa-plus-circle mr-2"></i> Create New Job
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Information Card -->
    <div class="row mb-4">
            <!-- Navigation Menu (kt_todo_aside) -->
            @include('company-freelancer.components.recruitment.sidebar')

            <!-- Job Information Card -->
            @include('company-freelancer.components.recruitment.job-info')
    </div>

        <!-- Candidate List and Recruitment Process -->
    <div class="row mt-5">
            <div class="col-lg-12">
                @include('company-freelancer.components.recruitment.candidates')
            </div>
    </div>

        <!-- SVG Connector (Alternative to LeaderLine) -->
        <svg id="connector" width="100%" height="100%" style="position:absolute; top:0; left:0; pointer-events:none;">
            <path id="path" stroke="#000" stroke-width="2" stroke-dasharray="5,5" fill="none" />
        </svg>
    </div>
@endsection

@section('js')

@endsection
