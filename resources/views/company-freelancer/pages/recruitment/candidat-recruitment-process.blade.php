@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Recruitment Process')

@section('title-dash', 'Recruitment process for candidat')

@section('css')
    <!-- Metronic CSS -->
    <link href="{{ asset('templates/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('/css/custom/recruitment-process.css')}}"/>

@endsection


@section('content')

<div class="container m-0 pb-5">
    <a class="btn btn-sm btn-primary mb-2 p-2" href="{{ asset('/company/freelancer/job/recruitment-process') }}">
        <i class="fa fa-chevron-left"></i> Back
    </a>
     <!-- Recruitment Process Overview -->
     <div class="row process-overview mb-10">
        <div class="col-12">
           @include('company-freelancer.components.recruitment.overview')
           
        </div>
    </div>
    <!-- End of Recruitment Process Overview -->
    <div class="row">
        <!-- Chat Box Section -->
        <div class="col-lg-6 mb-5">
           @include('company-freelancer.components.recruitment.chat')  
        </div>

        <!-- Meeting Planner Section -->
        <div class="col-lg-6 mb-5">
           @include('company-freelancer.components.recruitment.schedule-meeting')
        </div>
    </div>
   
   
</div>




@endsection

@section('js')
    <script src="{{ asset('templates/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    
    <!-- SweetAlert2 for Pop-ups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('/js/custom/recruitment/schedule-meeting.js')}}"></script>
    <!-- JavaScript -->
    <script>
      $(document).ready(function () {
                const restInputContainer = document.getElementById('restInputContainer');

                // Add event listener to the dropdown
                $('#selectPhase').on('change', function () {
                    
                    var dropdownValue = $(this).val(); // Get the selected value
                    if (dropdownValue === 'rest') {
                        // Show the input container when "The rest" is selected
                        restInputContainer.style.display = 'block';
                    } else {
                        // Hide the input container for other options
                        restInputContainer.style.display = 'none';
                    }
                });
            });

    </script>
@endsection
