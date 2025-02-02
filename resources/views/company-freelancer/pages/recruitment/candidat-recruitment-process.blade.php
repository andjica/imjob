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
    @include('alerts.errors')
    @include('alerts.success')
    <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2"> <i class="fa fa-chevron-left text-white"></i> Back</button>
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
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
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
            document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("confirmNextStep").addEventListener("click", function () {
                // Simulate the recruitment phase update (replace with actual API call)
                alert("Candidate has been advanced to the next recruitment phase!");

                // Close the modal after confirming
                var nextStepModal = bootstrap.Modal.getInstance(document.getElementById("nextStepModal"));
                nextStepModal.hide();
            });
        });
        
    </script>
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



@endsection
