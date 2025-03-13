@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Create a new job')

@section('title-dash', 'This will be active on mobile app')

@section('css')
<style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 1000px;
            margin: 1.75rem auto;
        }
    }

    @media (min-width: 576px) {
        #alertModal .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto;
        }
    }

    /* Optional: Adjust form labels for better alignment in two-column layout */
    .form-label {
        text-align: right;
    }
</style>
@endsection

@section('content')
<div class="container m-0 pb-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header">
                    <h3 class="card-title">Create New Job</h3>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-3">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                    <form action="{{route('company-freelancer-store-job')}}" method="POST" id="jobForm">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6 pe-10 border-end me-2">
                         <!-- Job World Type as Navigation -->
                         <div class="row mb-5">
                                <label class="fw-bold fs-5 mb-3">Job World Type:</label>
                                <div class="d-flex gap-3">
                                    <!-- National Option -->
                                    <button type="button"
                                            class="btn btn-outline btn-light-primary fw-semibold fs-6 py-3 px-4 {{ old('jobWorldType') == 'national' ? 'active' : '' }}"
                                            name="jobWorldTypeButton"
                                            id="jobWorldTypeNational"
                                            value="national"
                                            onclick="setJobType('national')">
                                        <i class="fas fa-flag me-2"></i> National
                                    </button>
                                    <!-- International Option -->
                                    <button type="button"
                                            class="btn btn-outline btn-light-primary fw-semibold fs-6 py-3 px-4 {{ old('jobWorldType') == 'international' ? 'active' : '' }}"
                                            name="jobWorldTypeButton"
                                            id="jobWorldTypeInternational"
                                            value="international"
                                            onclick="setJobType('international')">
                                        <i class="fas fa-globe me-2"></i> International
                                    </button>
                                </div>
                                    <!-- Hidden input to store the selected job type -->
                                    <input type="hidden" name="jobWorldType" id="jobWorldType" value="{{ old('jobWorldType', 'national') }}">
                            </div>


                                <!-- Job Title -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Job Title:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('title') is-invalid @enderror" name="title" id="title"
                                            value="{{ old('title') }}" />
                                        <span class="text-danger" id="titleEmpty">@error('title'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                 <!-- Job Description -->
                                 <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Job Description:</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" name="description" id="description"
                                            rows="6">{{ old('description') }}</textarea>
                                        <span class="text-danger" id="descriptionEmpty">@error('description'){{ $message }}@enderror</span>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Country:</label>
                                    <div class="col-lg-8">
                                        <select name="countryId" id="countryId" data-control="select2"
                                            class="form-control form-control-solid @error('countryId') is-invalid @enderror">
                                            <option value="">Select a Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('countryId') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="countryIdEmpty">@error('countryId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                 <!-- City -->
                                 <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">City:</label>
                                    <div class="col-lg-8">
                                        <select name="cityId" id="cityId" data-control="select2"
                                            class="form-control form-control-solid @error('cityId') is-invalid @enderror">
                                            <option value="">Select a City</option>
                                            <option value=""></option>
                                        </select>
                                        <span class="text-danger" id="cityIdEmpty">@error('cityId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Salary Minimum -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Salary (Min):</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('salaryMin') is-invalid @enderror" name="salaryMin" id="salaryMin"
                                            value="{{ old('salaryMin') }}" />
                                        <span class="text-danger" id="salaryMinEmpty">@error('salaryMin'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                 <!-- Salary Maximum -->
                                 <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Salary (Max):</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('salaryMax') is-invalid @enderror" name="salaryMax" id="salaryMax"
                                            value="{{ old('salaryMax') }}" />
                                        <span class="text-danger" id="salaryMaxEmpty">@error('salaryMax'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                 <!-- Currency Information -->
                                 <div class="row mb-5 d-none" id="currencyInfoRow">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Currency Information:</label>
                                    <div class="col-lg-8">
                                        <div class="alert alert-info" role="alert">
                                            <strong>Currency Name:</strong> <span id="currencyName">N/A</span><br>
                                            <strong>Currency Symbol:</strong> <span id="currencySymbol">N/A</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Experience Level -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Experience Level:</label>
                                    <div class="col-lg-8">
                                        <select name="experienceLevel" id="experienceLevel" class="form-control form-control-solid @error('experienceLevel') is-invalid @enderror">
                                            <option value="">Select Experience Level</option>
                                            @foreach (['Entry-Level', 'Mid-Level', 'Senior-Level', 'Managerial'] as $level)
                                                <option value="{{ $level }}" {{ old('experienceLevel') == $level ? 'selected' : '' }}>
                                                    {{ $level }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="experienceLevelEmpty">@error('experienceLevel'){{ $message }}@enderror</span>
                                    </div>
                                </div>

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-5">
                               <!-- Category -->
                               <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Category:</label>
                                    <div class="col-lg-8">
                                        <select name="categoryId" id="categoryId" data-control="select2"
                                            class="form-control form-control-solid @error('categoryId') is-invalid @enderror">
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="categoryIdEmpty">@error('categoryId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- SubCategory -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">SubCategory:</label>
                                    <div class="col-lg-8">
                                        <select name="subCategoryId" id="subCategoryId" data-control="select2"
                                            class="form-control form-control-solid @error('subCategoryId') is-invalid @enderror">
                                            <option value="">Select a SubCategory</option>
                                            <option value=""></option>
                                        </select>
                                        <span class="text-danger" id="subCategoryIdEmpty">@error('subCategoryId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Other categoty type -->
                                <div class="row mb-5 d-none" id="otherSubRow">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Other:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid" name="custom_subcategory" id="otherSub" />
                                        <span class="text-danger" id="otherCategoryEmpty">@error('otherCategoryId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                               <!-- Job Type -->
                            <div class="row mb-5">
                                <label class="col-lg-4 col-form-label fw-bold fs-6 required">Job Type:</label>
                                <div class="col-lg-8">
                                    <select name="jobTypeId" id="jobTypeId" data-control="select2"
                                        class="form-control form-control-solid @error('jobTypeId') is-invalid @enderror">
                                        <option value="">Select a Job Type</option>
                                        @foreach ($jobTypes as $jobType)
                                            <option value="{{ $jobType->id }}" {{ old('jobTypeId') == $jobType->id ? 'selected' : '' }}>
                                                {{ $jobType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="jobTypeIdEmpty">@error('jobTypeId'){{ $message }}@enderror</span>
                                </div>
                            </div>

                                  <!-- Required Skills -->
                                  <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Required Skill:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('requiredSkills') is-invalid @enderror" name="requiredSkills" id="requiredSkills"
                                            value="{{ old('requiredSkills') }}" />
                                        <span class="text-danger" id="requiredSkillsEmpty">@error('requiredSkills'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                 <!-- More Skills -->
                                 <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">More Skills:</label>
                                    <div class="col-lg-8">
                                        <div id="skillsContainer">
                                            <div class="input-group mb-2 skill-input-group">
                                                <input type="text" class="form-control form-control-solid" name="moreSkill[]" placeholder="Enter a skill" />
                                                <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="moreSkillsEmpty"></span>
                                    </div>
                                </div>
                                <!-- Special Requirements -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Special Requirements:</label>
                                    <div class="col-lg-8">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="has_special_requirements"
                                                name="has_special_requirements"
                                                value="true"
                                                {{ old('has_special_requirements') ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="has_special_requirements">
                                                Check if there are special requirements.
                                            </label>
                                        </div>
                                        <span class="text-danger" id="specialRequirementsEmpty">
                                            @error('has_special_requirements'){{ $message }}@enderror
                                        </span>
                                    </div>
                                </div>
                                <!-- Additional Special Requirements Fields -->
                                <div class="row mb-5 d-none" id="specialRequirementsFields">
                                    <label for="special_requirements" class="col-lg-4 col-form-label fw-bold fs-6">Details:</label>
                                    <div class="col-lg-8">
                                        <textarea
                                            class="form-control form-control-solid @error('special_requirements') is-invalid @enderror"
                                            name="special_requirements"
                                            id="special_requirements"
                                            rows="4"
                                            placeholder="Enter any special requirements here..."
                                        >{{ old('special_requirements') }}</textarea>
                                        <span class="text-danger" id="specialDetailsEmpty">
                                            @error('special_requirements'){{ $message }}@enderror
                                        </span>
                                    </div>
                                </div>


                                <!-- Age Range -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Age Range:</label>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control form-control-solid @error('min_age') is-invalid @enderror" name="min_age" id="min_age"
                                            placeholder="Min Age" value="{{ old('min_age') }}" min="18" max="100" />
                                        <span class="text-danger" id="minAgeEmpty">@error('min_age'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control form-control-solid @error('max_age') is-invalid @enderror" name="max_age" id="max_age"
                                            placeholder="Max Age" value="{{ old('max_age') }}" min="18" max="100" />
                                        <span class="text-danger" id="maxAgeEmpty">@error('max_age'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Valid Until -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Valid Until:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control form-control-solid @error('validUntil') is-invalid @enderror" name="validUntil" id="validUntil"
                                            value="{{ old('validUntil') }}" />
                                        <span class="text-danger" id="validUntilEmpty">@error('validUntil'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Loading Indicators (Optional) -->
                        <div class="spinner-border text-primary d-none" role="status" id="loading" style="position: absolute; top: 50%; left: 50%; z-index: 1000;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-border text-primary d-none" role="status" id="currencyLoading" style="position: absolute; top: 50%; left: 50%; z-index: 1000;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <!-- Submit Button -->
                        <input type="hidden" name="recruiter_id" value="{{auth()->user()->recruiter->id}}">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Create Job</button>
                        </div>
                    </form>
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!-- Initialize Select2 -->

        @include('company-freelancer.components.job.create-modal-popup')
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<!-- Custom Validation Script -->
<script>
    $(document).ready(function() {
        // Initialize CKEditor 5 on the #description textarea
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                    ]
                }
            })
            .then(editor => {
                window.jobDescriptionEditor = editor; // Make editor globally accessible

                // Access the editable DOM element created by CKEditor
                const editableElement = editor.ui.view.editable.element;

                // Bind the keyup event to the editable element
                $(editableElement).on('keyup', function() {
                    // Retrieve the data from CKEditor
                    var description = window.jobDescriptionEditor.getData().trim();

                    if(description === "") {
                        // If description is empty, display error message and add border-danger
                        $("#descriptionEmpty").text("Description is a required field.");
                        $(editableElement).addClass('border-danger').removeClass('border-success');
                    }
                    else {
                        // If description is not empty, clear error message and add border-success
                        $("#descriptionEmpty").text("");
                        $(editableElement).removeClass('border-danger').addClass('border-success');
                    }
                });


            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="{{ asset('/js/custom/job/autonumeric-salary-validation.js') }}"></script>
<script src="{{ asset('/js/custom/job/country-category-ajax.js') }}"></script>
<script src="{{ asset('/js/custom/job/toogle-special-requirements.js') }}"></script>
<script src="{{ asset('/js/custom/job/optional-skills.js') }}"></script>
<script src="{{ asset('/js/custom/job/form-submit-validation.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap modals
        const alertModal = new bootstrap.Modal(document.getElementById('alertModal'), {
            backdrop: 'static',
            keyboard: false
        });

        // Reference to the "Add Company" button
        const addCompanyButton = document.getElementById('addCompanyButton');

        // Add click event listener to the "Add Company" button
        addCompanyButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default behavior
            // Show the Alert Modal
            alertModal.show();
        });
    });
</script>
<script>
        function setJobType(type) {
        // Update the hidden input value
        document.getElementById('jobWorldType').value = type;

        // Toggle active class for buttons
        document.getElementById('jobWorldTypeNational').classList.toggle('active', type === 'national');
        document.getElementById('jobWorldTypeInternational').classList.toggle('active', type === 'international');
    }


    // Initialize with old value
    document.addEventListener('DOMContentLoaded', function () {
        const jobWorldType = document.getElementById('jobWorldType').value;
        if (jobWorldType === 'national') {
            setJobType('national');
        } else if (jobWorldType === 'international') {
            setJobType('international');
        }
    });
</script>
@endsection
