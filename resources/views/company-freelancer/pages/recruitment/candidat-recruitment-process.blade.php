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
@php
    use App\Models\Job;
    use App\Models\RecruitmentProcess;

    // Define recruitment phases
    $phases = [
        RecruitmentProcess::APPLICATION_RECEIVED => 'Application Received',
        RecruitmentProcess::SELECTION => 'Selection',
        RecruitmentProcess::PREPARATION => 'Preparation',
        RecruitmentProcess::TRANSFER => 'Transfer',
        RecruitmentProcess::OFFER_STAGE => 'Offer Stage',
    ];

    // Remove unnecessary phases for National jobs
    if ($candidate->job->job_world_type === Job::TYPE_NATIONAL) {
        unset($phases[RecruitmentProcess::PREPARATION], $phases[RecruitmentProcess::TRANSFER]);
    }

    // Determine the current phase index
    $currentPhaseIndex = array_search($recruitmentProcess->current_phase, array_keys($phases));
@endphp

<div class="container m-0 pb-5">
    @include('alerts.errors')
    @include('alerts.success')
    <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2"> <i class="fa fa-chevron-left text-white"></i> Back</button>
     <!-- Recruitment Process Overview -->
     <div class="row process-overview mb-10">
        <div class="col-12">
           @include('company-freelancer.components.recruitment.overview')
           @include('company-freelancer.components.recruitment.feedback-and-delete-modal')
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
           @include('company-freelancer.components.recruitment.schedule-modal')
          
           @include('company-freelancer.components.recruitment.calendar-with-modal')
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

    <!-- Calendar overview with START  data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('meetingCalendar');

            if (!calendarEl) {
                console.error("Calendar element #meetingCalendar not found!");
                return;
            }

            var candidateSubphases = @json($meetings);

            console.log("Raw candidateSubphases:", candidateSubphases);

            if (!Array.isArray(candidateSubphases)) {
                console.warn("candidateSubphases is not an array, attempting conversion...", candidateSubphases);
                candidateSubphases = Object.values(candidateSubphases);
            }

            console.log("Final candidateSubphases:", candidateSubphases);

            var events = candidateSubphases.map(phase => ({
                id: phase.id,
                title: phase.meeting_title ?? 'No Title',
                start: new Date(phase.scheduled_at),
                description: phase.description ?? 'No description available',
                meetingLink: phase.meeting_link ?? null
            }));

            console.log("FullCalendar Events:", events);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events,
                eventClick: function(info) {
                    showMeetingPopup(info.event);
                }
            });

            calendar.render();

            // Function to show modal with meeting details
            function showMeetingPopup(event) {
                document.getElementById('meetingTitle').innerText = event.title;
                document.getElementById('meetingDate').innerText = new Date(event.start).toLocaleString();
                document.getElementById('meetingDescription').innerText = event.extendedProps.description;

                var linkElement = document.getElementById('meetingLink');
                if (event.extendedProps.meetingLink) {
                    linkElement.href = event.extendedProps.meetingLink;
                    linkElement.innerText = "Join Meeting";
                    linkElement.style.display = 'inline';
                } else {
                    linkElement.innerText = 'No link available';
                    linkElement.style.display = 'none';
                }

                var modal = new bootstrap.Modal(document.getElementById('meetingModal'));
                modal.show();
            }
        });
    </script>
     <!-- Calendar overview with END data -->
    <!-- Schedule meeting validation START Validation form -->
    <script>

        $(document).ready(function () {
            $('#meeting_contributors').select2({
                placeholder: "Select contributors...",
                allowClear: true,  // Enables "X" to remove selected values
                width: '100%'      // Ensures it takes full width
            });

            // Ensure old selected values are loaded correctly (Fix for Laravel)
            var selectedContributors = @json(old('contributors', []));
            $('#meeting_contributors').val(selectedContributors).trigger('change');
            $('#scheduleMeetingForm').submit(function (event) {
                // Prevent form submission for validation
                event.preventDefault();

                // Get form values
                const meetingTitle = $('#meeting_title').val().trim();
                const meetingLink = $('#meeting_link').val().trim();
                const selectPhase = $('#select_phase').val();
                const meetingDate = $('#meeting_date').val();
                const meetingContributors = $('#meeting_contributors').val();

                // Clear previous error states
                $('.border-danger').removeClass('border-danger');
                $('.text-danger').text('').hide();

                // Initialize validation flag
                let isValid = true;

                // Validate Meeting Title
                if (meetingTitle === '') {
                    $('#meeting_title').addClass('border-danger');
                    $('#meeting_titleError').text('Meeting Title is required.').show();
                    isValid = false;
                }

                // Validate Meeting Link (Basic URL Check)
                //Ovo je za live verziju
                // const urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w.-]*)*\/?$/;
                // if (!urlPattern.test(meetingLink)) {
                //     $('#meeting_link').addClass('border-danger');
                //     $('#meeting_linkError').text('Enter a valid meeting link (e.g., https://meet.google.com/xyz).').show();
                //     isValid = false;
                // }

                // Validate Phase Selection
                if (selectPhase === '') {
                    $('#select_phase').addClass('border-danger');
                    $('#select_phaseError').text('Please select a phase.').show();
                    isValid = false;
                }

                // Validate Date & Time (Must be in the future)
                const selectedDate = new Date(meetingDate);
                const currentDate = new Date();
                if (meetingDate === '' || selectedDate <= currentDate) {
                    $('#meeting_date').addClass('border-danger');
                    $('#meeting_dateError').text('Please select a future date and time.').show();
                    isValid = false;
                }
                // If form is valid, submit the form
                if (isValid) {
                    this.submit();
                } else {
                    $('#scheduleMeetingModal').modal('show'); // Keep modal open if validation fails
                }
            });
        });

        
    </script>
    <!-- Schedule meeting validation END Validation form -->




@endsection
