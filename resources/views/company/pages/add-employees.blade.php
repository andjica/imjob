@extends('company.template-company')

@section('content')
@section('title-dash', 'Add emoloyee')
<div class="container m-0">
    <div class="row">
        <!-- First Card: Add Employee :) -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Employee</h3>
                </div>
                <div class="card-body">
                <form action=" {{ route('company-dashboard-follow-change-status') }}" method="POST">
                @csrf
                        <div class="mb-3">
                            <label for="recruiter" class="form-label">Select Recruiter:</label>
                            <!-- Recruiter -->
                            <div class="row mb-5">
                                <label class="col-lg-4 col-form-label fw-bold fs-6 required">Recruiter:</label>
                                <div class="col-lg-8">
                                <select name="recruiter_id" id="recruiter_id" data-control="select2"
                                    class="form-control form-control-solid @error('recruiterId') is-invalid @enderror">
                                    <option value="">Select a Recruiter</option>
                                    @foreach ($recruiters as $recruiter)
                                    @php
                                        $image = $recruiter->profile_image 
                                            ? asset('storage/uploads/recruiters/' . basename($recruiter->profile_image)) 
                                            : asset('images/user-profile.png');
                                    @endphp
                                        <option value="{{ $recruiter->id }}" data-img="{{ $image }}">
                                            {{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="company_id" value="{{auth()->user()->company->id}}">
                                <input type="hidden" name="status" value="Active">
                                    <span class="text-danger" id="recruiterIdEmpty">@error('recruiterId'){{ $message }}@enderror</span>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Second Card: Send Email -->
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Send Email</h3>
                </div>
                <div class="card-body">
                    <form action="/" method="POST" id="emailForm">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" id="email">
                            <span class="text-danger" id="emailEmpty"> @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <button type="submit" class="btn btn-success">Send Email</button>
                    </form>
                </div>
            </div>
        </div>
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
            var image = $(recruiter.element).data('img') || "{{ asset('/images/icon-profile.png') }}";
            var template = $('<span><img src="' + image +
                '" class="rounded-circle" style="width:30px; height:30px; margin-right:10px;"/> ' +
                recruiter.text + '</span>');
            return template;
        }

        $('#recruiterId').select2({
            templateResult: formatRecruiter,
            templateSelection: formatRecruiter,
            escapeMarkup: function(m) {
                return m;
            }
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
