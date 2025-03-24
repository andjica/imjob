@extends('company.template-company')
@section('main-title', 'Recruitment Process for '.$candidate->user->first_name.' '.$candidate->user->last_name)

@section('title-dash', 'Recruitment process for candidat')

@section('css')
    <!-- Metronic CSS -->
    <link href="{{ asset('templates/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/custom/recruitment-process.css')}}"/>
    
@endsection


@section('content')
@php
    use App\Models\Job;
    use App\Models\RecruitmentProcess;

    // Define recruitment phases based on job type
    if ($candidate->job->job_world_type === Job::TYPE_INTERNATIONAL) {
        $phases = [
            RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
            RecruitmentProcess::SELECTION => 'Selection',
            RecruitmentProcess::PREPARATION => 'Preparation',
            RecruitmentProcess::TRANSFER => 'Transfer',
            RecruitmentProcess::OFFER_STAGE => 'Offer Stage', 
        ];
    } else { // If job is National
        $phases = [
            RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
            RecruitmentProcess::SELECTION => 'Selection',
            RecruitmentProcess::OFFER_STAGE => 'Offer Stage', 
        ];
    }
    //return dd($recruitmentProcess);
    // Determine the current phase index
   $currentPhaseIndex = array_search($recruitmentProcess->current_phase, array_keys($phases));
    //$currentPhaseIndex = array_search((int) $recruitmentProcess->current_phase, array_map('intval', array_keys($phases)));

@endphp

<div class="container m-0 pb-5">
    @include('alerts.errors')
    @include('alerts.success')
    <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2"> <i class="fa fa-chevron-left text-white"></i> Back</button>
    @if($candidate->recruitmentProcess->status != null)
    <div class="text-end mt-3 mb-0">
        <a href="{{ route('company-freelancer-recruitment-download.pdf', ['recruitment_process_id' => $candidate->recruitmentProcess->id]) }}" 
        class="btn btn-primary  align-items-center justify-content-center" 
        style="gap: 8px; padding: 10px 20px;">
        <i class="fa-solid fa-file-pdf"></i> Download PDF
        </a>
    </div>
    @endif
     <!-- Recruitment Process Overview -->
     <div class="row process-overview mb-10 mt-3">
        <div class="col-12">
           @include('company.components.recruitment.overview')
        </div>
    </div>
    <!-- End of Recruitment Process Overview -->
     <div class="row">
        <div class="col-3">
            @include('company.components.job.sidebar-recruiter')
            

        </div>
        <div class="col-lg-9">
        @include('company.components.recruitment.candidates')

        </div>
     </div>
</div>




@endsection

@section('js')
    <script src="{{ asset('templates/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <!-- SweetAlert2 for Pop-ups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <script src="{{asset('/js/custom/recruitment/schedule-meeting.js')}}"></script> -->
    <script src="{{asset('/js/custom/recruitment/feedback-and-delete.js')}}"></script>

  
  



@endsection
