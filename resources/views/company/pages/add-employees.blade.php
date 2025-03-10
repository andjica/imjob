@extends('company.template-company')

@section('content')
@section('title-dash', 'Add emoloyee')
<div class="container m-0">
    <div class="row">
         @include('alerts.success')
        @include('alerts.errors')
        <!-- First Card: Add Employee :) -->
        <div class="col-8">
             @include('company.components.company.form-add-employee')
        </div>

        <!-- Second Card: Send Email -->
            <div class="col-4">
                @include('company.components.company.card-add-employees')
            </div>
        </div>
        <div class="row mt-5">
            @include('company.components.company.active-connections')
        </div>
        
        
   
</div>
@endsection
<!-- Select2 Script for Image Support -->
@section('js')
<script>
    $(document).ready(function() {
        function formatRecruiter(recruiter) {
        if (!recruiter.id) {
            return recruiter.text;
        }
        
        var image = $(recruiter.element).data('img') || "{{ asset('/images/user-profile.png') }}";
        var country = $(recruiter.element).data('country') || "Unknown Country";
        var city = $(recruiter.element).data('city') || "Unknown City";

        var template = $(
            `<div style="display: flex; align-items: center;">
                <img src="${image}" class="rounded-circle" style="width:30px; height:30px; margin-right:10px;"/>
                <div>
                    <strong>${recruiter.text}</strong><br>
                    <small><i>${country}, ${city}</i></small>
                </div>
            </div>`
        );
        return template;
    }

    $('#recruiter_id').select2({
        templateResult: formatRecruiter,
        templateSelection: formatRecruiter,
        escapeMarkup: function(m) { return m; } // Render HTML properly
    });
        let isValid = true;

        // Email validation
        function showError(inputId, errorId, message) {
            $(inputId).removeClass("border-success").addClass("border-danger");
            $(errorId).text(message).addClass("text-danger");
        }

        function showSuccess(inputId, errorId) {
            $(inputId).removeClass("border-danger").addClass("border-success");
            $(errorId).text("");
        }

        function validateEmail() {
            let email = $("#email").val().trim();
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === "") {
                showError("#email", "#emailEmpty", "Email is required.");
                isValid = false;
            } else if (!email.match(emailPattern)) {
                showError("#email", "#emailEmpty", "Enter a valid email address.");
                isValid = false;
            } else {
                
                showSuccess("#email", "#emailEmpty");
                isValid = true;
                return true;
            }
        }

        // Validate email on input change
        $("#email").on("input", function() {
            validateEmail();
        });

        // Validate on form submit
        $("#emailForm").submit(function(e) {
            if (!validateEmail()) {
                e.preventDefault(); // Prevent form submission if invalid
            }
        
        });
    });
</script>
@endsection
