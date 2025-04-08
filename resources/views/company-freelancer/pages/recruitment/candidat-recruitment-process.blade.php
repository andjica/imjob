@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Recruitment Process for ' . $candidate->user->first_name . ' ' . $candidate->user->last_name)

@section('title-dash', 'Recruitment process for candidat')

@section('css')
    <!-- Metronic CSS -->
    <link href="{{ asset('templates/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom/recruitment-process.css') }}" />

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
        } else {
            // If job is National
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
        <a href="{{ asset('company/freelancer/' . $jobId . '/recruitment-process') }}"
            class="btn btn-sm bg-linear-pink text-white  p-2"> <i class="fa fa-chevron-left text-white"></i> Back</a>
        @if ($candidate->recruitmentProcess->status != null)
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
                @include('company-freelancer.components.recruitment.overview')
                @include('company-freelancer.components.recruitment.feedback-and-delete-modal')
            </div>
        </div>
        <!-- End of Recruitment Process Overview -->
        <div class="row">
            <!-- Chat Box Section -->
            <div class="col-lg-7 mb-5">
                {{-- vue js --}}
                @include('company-freelancer.components.recruitment.chat')
            </div>

            <!-- Meeting Planner Section -->
            <div class="col-lg-5 mb-5">
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

    <!-- <script src="{{ asset('/js/custom/recruitment/schedule-meeting.js') }}"></script> -->
    <script src="{{ asset('/js/custom/recruitment/feedback-and-delete.js') }}"></script>

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

            var events = candidateSubphases.map(phase => {
                let formattedPhaseName = phase.phase; // Default phase name

                // If the phase is "offer_stage", display "Offer Stage"
                if (formattedPhaseName === "offer_stage") {
                    formattedPhaseName = "Offer Stage";
                } else {
                    // Otherwise, capitalize the first letter of other phases
                    formattedPhaseName = formattedPhaseName.charAt(0).toUpperCase() + formattedPhaseName
                        .slice(1);
                }

                return {
                    id: phase.id,
                    title: `${formattedPhaseName} - ${phase.meeting_title ?? 'No Title'}`, // Show formatted phaseName + meeting title
                    phaseName: formattedPhaseName, // Store formatted phase name
                    start: new Date(phase.scheduled_at),
                    description: phase.description ?? 'No description available',
                    meetingLink: phase.meeting_link ?? null
                };
            });
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
                document.getElementById('phaseName').innerText = event.extendedProps.phaseName;

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
        $(document).ready(function() {
            $('#meeting_contributors').select2({
                placeholder: "Select contributors...",
                allowClear: true, // Enables "X" to remove selected values
                width: '100%' // Ensures it takes full width
            });

            // Ensure old selected values are loaded correctly (Fix for Laravel)
            var selectedContributors = @json(old('contributors', []));
            $('#meeting_contributors').val(selectedContributors).trigger('change');

            $('#select_phase').on('change', function() {
                let selectedValue = $(this).val().toString().trim();
                //alert(selectedValue);// Ensure it's a string and trimmed
                console.log("Selected Phase Value:", selectedValue); // Debugging

                if (selectedValue === "other") {
                    console.log("Other phase selected. Showing input field.");
                    $('#customPhaseContainer').fadeIn(); // Use fadeIn for better UX
                    // $('#custom_phase').prop('required', true);
                } else {
                    console.log("Normal phase selected. Hiding custom input.");
                    $('#customPhaseContainer').fadeOut(); // Use fadeOut for better UX
                    // $('#custom_phase').prop('required', false);
                }
            });

            //validation form schedule meeting
            $('#scheduleMeetingForm').submit(function(event) {
                // Prevent form submission for validation
                event.preventDefault();

                // Get form values
                const meetingTitle = $('#meeting_title').val().trim();
                const meetingLink = $('#meeting_link').val().trim();
                const selectPhase = $('#select_phase').val();
                const meetingDate = $('#meeting_date').val();
                const meetingContributors = $('#meeting_contributors').val();
                const description = $('#meeting_description').val().trim();
                const customPhase = $('#custom_phase').val().trim();

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

                if (description === '') {
                    $('#meeting_description').addClass('border-danger');
                    $('#meeting_descriptionError').text('Description is required.').show();
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

            $("#meeting_title").on('keyup', function() {
                var title = $(this).val().trim();
                if (title === "") {
                    $("#meeting_titleError").text("Meeting Title is required").show();
                    $(this).addClass('border-danger').removeClass('border-success');
                } else {
                    $("#meeting_titleError").text("").hide();
                    $(this).removeClass('border-danger').addClass('border-success');
                }
            });

            // Validate Meeting Link on Keyup
            //ovo ce biti na live verziji
            // $("#meeting_link").on('keyup', function () {
            //     var link = $(this).val().trim();
            //     var urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w.-]*)*\/?$/;

            //     if (link === "") {
            //         $("#meeting_linkError").text("Meeting Link is required").show();
            //         $(this).addClass('border-danger').removeClass('border-success');
            //     } else if (!urlPattern.test(link)) {
            //         $("#meeting_linkError").text("Enter a valid meeting link (e.g., https://meet.google.com/xyz)").show();
            //         $(this).addClass('border-danger').removeClass('border-success');
            //     } else {
            //         $("#meeting_linkError").text("").hide();
            //         $(this).removeClass('border-danger').addClass('border-success');
            //     }
            // });

            // Validate Phase Selection on Change
            $('#select_phase').on('change', function() {
                let selectedValue = $(this).val();

                if (selectedValue === "") {
                    $("#select_phaseError").text("Please select a phase").show();
                    $(this).addClass('border-danger').removeClass('border-success');
                } else {
                    $("#select_phaseError").text("").hide();
                    $(this).removeClass('border-danger').addClass('border-success');
                }

                // Show/Hide Custom Phase Input
                if (selectedValue === 'other') {
                    $('#customPhaseContainer').fadeIn();
                    // $('#custom_phase').prop('required', true);
                } else {
                    $('#customPhaseContainer').fadeOut();
                    // $('#custom_phase').prop('required', false);
                }
            });

            // Validate Custom Phase Input on Keyup
            $("#custom_phase").on('keyup', function() {
                var customPhase = $(this).val().trim();
                if (customPhase === "") {
                    $("#custom_phaseError").text("Custom Phase is required").show();
                    $(this).addClass('border-danger').removeClass('border-success');
                } else {
                    $("#custom_phaseError").text("").hide();
                    $(this).removeClass('border-danger').addClass('border-success');
                }
            });

            // Validate Date & Time Selection
            $("#meeting_date").on('change', function() {
                var selectedDate = new Date($(this).val());
                var currentDate = new Date();
                if (!$(this).val() || selectedDate <= currentDate) {
                    $("#meeting_dateError").text("Please select a future date and time").show();
                    $(this).addClass('border-danger').removeClass('border-success');
                } else {
                    $("#meeting_dateError").text("").hide();
                    $(this).removeClass('border-danger').addClass('border-success');
                }
            });

            // Validate Description on Keyup
            $("#meeting_description").on('keyup', function() {
                var description = $(this).val().trim();
                if (description === "") {
                    $("#meeting_descriptionError").text("Description is required").show();
                    $(this).addClass('border-danger').removeClass('border-success');
                } else {
                    $("#meeting_descriptionError").text("").hide();
                    $(this).removeClass('border-danger').addClass('border-success');
                }
            });

            // Validate Contributors on Change
            $('#meeting_contributors').on('change', function() {
                if ($(this).val().length === 0) {
                    $("#meeting_contributorsError").text("Please select at least one contributor").show();
                    $(this).addClass('border-danger').removeClass('border-success');
                } else {
                    $("#meeting_contributorsError").text("").hide();
                    $(this).removeClass('border-danger').addClass('border-success');
                }
            });

            // Final Form Submission Validation
            $('#scheduleMeetingForm').on('submit', function(event) {
                let isValid = true;

                // Check if any errors exist before submitting
                $(".form-control").each(function() {
                    if ($(this).hasClass("border-danger")) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    //alert("Please correct the errors before submitting.");
                }
            });
        });
    </script>
    <!-- Schedule meeting validation END Validation form -->




@endsection
