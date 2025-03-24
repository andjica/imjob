@extends('company.template-company')
@section('main-title', 'Job '.$job->title)

@section('title-dash', 'This job is active on mobile app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/custom/recruitment-process.css')}}"/>
<style>
  

    #read-more, #show-less {
        color: #007bff;
        text-decoration: underline;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container m-0 pb-5 mt-5" id="leader-line-container">
@include('alerts.errors')
@include('alerts.success')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-2">
                @if($job->job_world_type == "International")
                <div class="card-body bg-linear-pink">
                @else
                <div class="card-body bg-linear-pink rounded-top">
                @endif
                    <div class="tab-content" id="myTabContent">
                        <!-- Active Jobs Content -->
                        <div class="tab-pane fade show active" id="active-job" role="tabpanel" aria-labelledby="active-jobs-tab">
                            <h5 class="text-white font-weight-bold">{{ ucfirst($job->job_world_type) }}
                            </h5>
                        </div>
                       
                    </div>
                </div>
            
            </div>
        </div>
    </div>
   
    <!-- Job Information Card -->
    <div class="row mb-4">
            <!-- Navigation Menu (kt_todo_aside) -->
            @include('company.components.recruitment.sidebar')
          
            <!-- Job Information Card -->
            <div class="col-lg-9 col-md-8">

            @include('company.components.recruitment.job-info')
            
            @include('company.components.recruitment.candidates')
            </div>
          
    </div>

        <!-- Candidate List and Recruitment Process -->
    <div class="row mt-5">
            <div class="col-lg-12">
             
              
            </div>
    </div>

        <!-- SVG Connector (Alternative to LeaderLine) -->
        <svg id="connector" width="100%" height="100%" style="position:absolute; top:0; left:0; pointer-events:none;">
            <path id="path" stroke="#000" stroke-width="2" stroke-dasharray="5,5" fill="none" />
        </svg>
    </div>
@endsection

@section('js')
<script>
    function toggleDescription() {
        const shortDesc = document.getElementById('short-description');
        const fullDesc = document.getElementById('full-description');
        const readMore = document.getElementById('read-more');
        const showLess = document.getElementById('show-less');

        if (shortDesc.style.display === 'none') {
            shortDesc.style.display = 'inline';
            fullDesc.style.display = 'none';
            readMore.style.display = 'inline';
            showLess.style.display = 'none';
        } else {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'inline';
            readMore.style.display = 'none';
            showLess.style.display = 'inline';
        }
    }
</script>
<script src="{{asset('/js/custom/recruitment/accept-reject-modal.js')}}"></script>


@endsection
