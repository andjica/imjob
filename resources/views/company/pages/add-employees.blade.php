@extends('company.template-company')

@section('content')
@section('title-dash', 'Add emoloyee')
<div class="container">
    <div class="row">
        <!-- First Card: Add Employee -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Employee</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recruiter" class="form-label">Select Recruiter:</label>
                            <!-- Recruiter -->
                            <div class="row mb-5">
                                <label class="col-lg-4 col-form-label fw-bold fs-6 required">Recruiter:</label>
                                <div class="col-lg-8">
                                    <select name="recruiterId" id="recruiterId" data-control="select2"
                                        class="form-control form-control-solid @error('recruiterId') is-invalid @enderror">
                                        <option value="">Select a Recruiter</option>
                                        @foreach ($recruiters as $recruiter)
                                            @php
                                                $image = $recruiter->profile_image ?? asset('assets/media/avatars/default.png');
                                            @endphp
                                            <option value="{{ $recruiter->id }}" data-img="{{ $image }}">
                                                {{ $recruiter->first_name }} {{ $recruiter->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" class="form-control" name="email" id="email" required>
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
@push('js')
<script>
    $(document).ready(function() {
        function formatRecruiter(recruiter) {
            if (!recruiter.id) {
                return recruiter.text;
            }
            var image = $(recruiter.element).data('img') || "{{ asset('assets/media/avatars/default.png') }}";
            var template = $('<span><img src="' + image + '" class="rounded-circle" style="width:30px; height:30px; margin-right:10px;"/> ' + recruiter.text + '</span>');
            return template;
        }

        $('#recruiterId').select2({
            templateResult: formatRecruiter,
            templateSelection: formatRecruiter,
            escapeMarkup: function(m) { return m; }
        });
    });
</script>
@endpush