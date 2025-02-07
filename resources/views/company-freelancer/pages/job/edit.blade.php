@extends('company-freelancer.template-company-freelancer')

@section('main-title', 'Edit Job')

@section('title-dash', 'Modify Job Details')

@section('css')
<style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 1000px;
            margin: 1.75rem auto;
        }
    }
    .d-none
    {
        display: none !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid m-0 pb-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <h3 class="card-title">Edit Job</h3>
                </div>

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

                    <form action="{{ route('company-freelancer-update-job', $job->id) }}" method="POST" id="jobForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6 pe-10 border-end me-2">
                             
                         <!-- Job World Type as Navigation -->
                            <div class="row mb-5">
                                <label class="fw-bold fs-5 mb-3">Job World Type:</label>
                                <div class="d-flex gap-3">
                                    <!-- National Option -->
                                    <button type="button"
                                            class="btn btn-outline btn-light-primary fw-semibold fs-6 py-3 px-4"
                                            name="jobWorldTypeButton"
                                            id="jobWorldTypeNational"
                                            value="national"
                                            onclick="setJobType('national')">
                                        <i class="fas fa-flag me-2"></i> National
                                    </button>

                                    <!-- International Option -->
                                    <button type="button"
                                            class="btn btn-outline btn-light-primary fw-semibold fs-6 py-3 px-4"
                                            name="jobWorldTypeButton"
                                            id="jobWorldTypeInternational"
                                            value="international"
                                            onclick="setJobType('international')">
                                        <i class="fas fa-globe me-2"></i> International
                                    </button>
                                </div>
                                <!-- Hidden input to store the selected job type -->
                                <input type="hidden" name="jobWorldType" id="jobWorldType" value="{{ old('jobWorldType', $job->job_world_type) }}">
                            </div>

                                <!-- Job Title -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Job Title:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('title') is-invalid @enderror" 
                                               name="title" value="{{ old('title', $job->title) }}" id="title" />
                                        <span class="text-danger">@error('title'){{ $message }}@enderror</span>
                                    </div>
                                </div>

                                <!-- Job Description -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Job Description:</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" 
                                                  name="description" rows="6" id="description"> {{ $job->description }}</textarea>
                                        <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Country -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Country:</label>
                                    <div class="col-lg-8">
                                    <select name="countryId" id="countryId" data-control="select2"
                                            class="form-control form-control-solid @error('countryId') is-invalid @enderror">
                                            <option value="{{$job->country->id}}">{{$job->country->name}}</option>
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
                                            <option value="{{$job->city->id}}">{{$job->city->name}}</option>
                                            <option value=""></option>
                                        </select>
                                        <span class="text-danger" id="cityIdEmpty">@error('cityId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Salary Min -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Salary (Min):</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('salaryMin') is-invalid @enderror" 
                                               name="salaryMin" value="{{ old('salaryMin', $job->salary_min) }}" id="salaryMin" />
                                        <span class="text-danger">@error('salaryMin'){{ $message }}@enderror</span>
                                    </div>
                                </div>

                                <!-- Salary Max -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Salary (Max):</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('salaryMax') is-invalid @enderror" 
                                               name="salaryMax" value="{{ old('salaryMax', $job->salary_max) }}" id="salaryMax"/>
                                        <span class="text-danger">@error('salaryMax'){{ $message }}@enderror</span>
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
                                        <select name="experienceLevel" id="experienceLevel" 
                                            class="form-control form-control-solid @error('experienceLevel') is-invalid @enderror">
                                            <option value="{{$job->experience_level}}">{{$job->experience_level}}</option>

                                            @php
                                                $experienceLevels = ['Entry-Level', 'Mid-Level', 'Senior-Level', 'Managerial'];
                                                $selectedExperience = old('experienceLevel', $job->experience_level ?? '');
                                            @endphp

                                            @foreach ($experienceLevels as $level)
                                                @if ($level !== $selectedExperience) <!-- Ensures no duplicate option -->
                                                    <option value="{{ $level }}" {{ $selectedExperience == $level ? 'selected' : '' }}>
                                                        {{ $level }}
                                                    </option>
                                                @endif
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
                                                <option value="{{ $job->category->id }}">{{ $job->category->name }}</option>
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
                                            
                                                <option value="{{ $job->subCategory->id }}">{{ $job->subCategory->name }}</option>
                                                <option value=""></option>   
                                        </select>
                                        <span class="text-danger" id="subCategoryIdEmpty">@error('subCategoryId'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Job Type -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Job Type:</label>
                                    <div class="col-lg-8">
                                        <select name="jobTypeId" id="jobTypeId" data-control="select2"
                                            class="form-control form-control-solid @error('jobTypeId') is-invalid @enderror">
                                            <option value="{{ $job->job_type_id}}"> {{ $job->jobType->name }}</option>
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
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Required Skills:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-solid @error('requiredSkills') is-invalid @enderror" 
                                            id="requiredSkills"   name="requiredSkills" value="{{ old('requiredSkills', $job->skills->first()->skill) }}" />
                                        <span class="text-danger">@error('requiredSkills'){{ $message }}@enderror</span>
                                    </div>
                                </div>

                                <!-- More Skills -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">More Skills:</label>
                                    <div class="col-lg-8">
                                        <div id="skillsContainer">
                                        @foreach ($job->skills as $index => $skill)
                                            @if ($index > 0) <!-- This skips the first skill -->
                                                <div class="input-group mb-2 skill-input-group">
                                                    <input type="text" class="form-control form-control-solid" 
                                                        name="moreSkill[]" value="{{ $skill->skill }}" />
                                                    <button class="btn btn-danger remove-skill-btn" type="button">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        @endforeach
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control form-control-solid" 
                                                       name="moreSkill[]" placeholder="Add new skill" />
                                                <button class="btn btn-success add-skill-btn" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
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
                                                value="1"
                                                {{ old('has_special_requirements', $job->special_requirements ? 'checked' : '') }}
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
                                <div class="row mb-5 {{ $job->special_requirements ? '' : 'd-none' }}" id="specialRequirementsFields">
                                    <label for="special_requirements" class="col-lg-4 col-form-label fw-bold fs-6">Details:</label>
                                    <div class="col-lg-8">
                                        <textarea
                                            class="form-control form-control-solid @error('special_requirements') is-invalid @enderror"
                                            name="special_requirements"
                                            id="special_requirements"
                                            rows="4"
                                            placeholder="Enter any special requirements here..."
                                        >{{ old('special_requirements', $job->special_requirements) }}</textarea>
                                        <span class="text-danger" id="specialDetailsEmpty">
                                            @error('special_requirements'){{ $message }}@enderror
                                        </span>
                                    </div>
                                </div>

                            <!-- Age Range -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Age Range:</label>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control form-control-solid @error('min_age') is-invalid @enderror" 
                                            name="min_age" id="min_age"
                                            placeholder="Min Age" 
                                            value="{{ old('min_age', $job->min_age) }}" 
                                            min="18" max="100" />
                                        <span class="text-danger" id="minAgeEmpty">@error('min_age'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="number" class="form-control form-control-solid @error('max_age') is-invalid @enderror" 
                                            name="max_age" id="max_age"
                                            placeholder="Max Age" 
                                            value="{{ old('max_age', $job->max_age) }}" 
                                            min="18" max="100" />
                                        <span class="text-danger" id="maxAgeEmpty">@error('max_age'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <!-- Valid Until -->
                                <div class="row mb-5">
                                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Valid Until:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control form-control-solid @error('validUntil') is-invalid @enderror" name="validUntil" id="validUntil"
                                            value="{{ $job->valid_until }}" />
                                        <span class="text-danger" id="validUntilEmpty">@error('validUntil'){{ $message }}@enderror</span>
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
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Job</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{$job->company_id}}" name="companyId">                   
                     </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="{{ asset('/js/custom/job/country-category-ajax.js') }}"></script>
<script>$(document).ready(function () {
      const jobWorldType = document.getElementById('jobWorldType').value;
    
    // Function to update selection
    function setJobType(type) {
        // Update the hidden input value
        document.getElementById('jobWorldType').value = type;

        // Remove active class from both buttons
        document.getElementById('jobWorldTypeNational').classList.remove('active', 'btn-primary');
        document.getElementById('jobWorldTypeInternational').classList.remove('active', 'btn-primary');

        // Add active class to selected button
        if (type === 'national') {
            document.getElementById('jobWorldTypeNational').classList.add('active', 'btn-primary');
        } else {
            document.getElementById('jobWorldTypeInternational').classList.add('active', 'btn-primary');
        }
    }

    // Initialize with the old or saved value
    if (jobWorldType === 'national') {
        setJobType('national');
    } else if (jobWorldType === 'international') {
        setJobType('international');
    }
    
    // Make function globally accessible
    window.setJobType = setJobType;
    // AutoNumeric Configuration
    const autoNumericOptions = {
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        decimalPlaces: 2,
        unformatOnSubmit: true,
    };

    // Initialize AutoNumeric for salary fields
    const anSalaryMin = new AutoNumeric('#salaryMin', autoNumericOptions);
    const anSalaryMax = new AutoNumeric('#salaryMax', autoNumericOptions);

    // Attach event listener for salary validation
    $('#salaryMin, #salaryMax').on('input change', validateSalaries);

   // Show/Hide Special Requirements Fields on Toggle
   $('#has_special_requirements').on('change', function () {
        if ($(this).is(':checked')) {
            $('#specialRequirementsFields').removeClass('d-none');
        } else {
            $('#specialRequirementsFields').addClass('d-none');
            $('#special_requirements').val(''); // Clear value when unchecked
        }
    }).trigger('change');

    // Initialize CKEditor
    if (document.querySelector('#description')) {
        ClassicEditor.create(document.querySelector('#description'))
            .then(editor => {
                console.log("✅ CKEditor is initialized!");
                window.jobDescriptionEditor = editor;
            })
            .catch(error => {
                console.error("❌ CKEditor failed to initialize:", error);
            });
    }

    // Form Validation on Submit
    $('#jobForm').submit(function (event) {
        event.preventDefault();
        console.log("🚀 Syncing CKEditor before validation...");
        
        if (window.jobDescriptionEditor) {
            const editorContent = window.jobDescriptionEditor.getData().trim();
            $('textarea[name="description"]').val(editorContent);
            console.log(`📝 CKEditor content length: ${editorContent.length} characters`);
        }

        if (validateForm()) {
            console.log("✅ Form is valid. Submitting...");
            this.submit();
        } else {
            console.log("❌ Form validation failed!");
        }
    });

    /*** Skill Management ***/
    function addSkillInput() {
        var newInputGroup = `
            <div class="input-group mb-2 skill-input-group">
                <input type="text" class="form-control form-control-solid" name="moreSkills[]" placeholder="Enter a skill" />
                <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
                    <i class="fa fa-plus"></i>
                </button>
                <button class="btn btn-danger remove-skill-btn" type="button" title="Remove Skill">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        `;
        $('#skillsContainer').append(newInputGroup);
        toggleRemoveButtons();
    }

    function toggleRemoveButtons() {
        var totalSkillInputs = $('.skill-input-group').length;
        $('.remove-skill-btn').toggle(totalSkillInputs > 1);
    }

    $('#skillsContainer').on('click', '.add-skill-btn', function() {
        addSkillInput();
    });

    $('#skillsContainer').on('click', '.remove-skill-btn', function() {
        $(this).closest('.skill-input-group').remove();
        toggleRemoveButtons();
    });

    toggleRemoveButtons();

    /*** Validation Functions ***/
    function validateForm() {
        let isValid = true;

        const fields = {
            '#title': '#titleEmpty',
            '#description': '#descriptionEmpty',
            '#categoryId': '#categoryIdEmpty',
            '#subCategoryId': '#subCategoryIdEmpty',
            '#countryId': '#countryIdEmpty',
            '#cityId': '#cityIdEmpty',
            '#experienceLevel': '#experienceLevelEmpty',
            '#requiredSkills': '#requiredSkillsEmpty',
            '#validUntil': '#validUntilEmpty',
            '#salaryMin': '#salaryMinEmpty',
            '#salaryMax': '#salaryMaxEmpty',
        };

        console.log("🔍 Checking required fields...");

        for (const [field, errorField] of Object.entries(fields)) {
            const value = $(field).val()?.trim() || '';
            if (value === '') {
                console.warn(`⚠ Validation failed: ${field} is empty`);
                showError(field, errorField, 'This field is required.');
                isValid = false;
            } else {
                hideError(field, errorField);
            }
        }

        if (!validateSalaries()) {
            console.warn("⚠ Salary validation failed!");
            isValid = false;
        }

        if (!validateAges()) {
            console.warn("⚠ Age validation failed!");
            isValid = false;
        }

        const specialDetails = $('#special_requirements').val()?.trim() || '';
        if ($('#has_special_requirements').is(':checked') && specialDetails === '') {
            console.warn("⚠ Special requirements are checked but empty.");
            showError('#special_requirements', '#specialDetailsEmpty', 'Please provide details.');
            isValid = false;
        } else {
            hideError('#special_requirements', '#specialDetailsEmpty');
        }


        console.log(isValid ? "✅ Form is valid!" : "❌ Form validation failed!");
        return isValid;
    }

    function validateSalaries() {
        const minVal = anSalaryMin.getNumber();
        const maxVal = anSalaryMax.getNumber();
        let isValid = true;

        if (!minVal || isNaN(minVal) || minVal < 0) {
            showError('#salaryMin', '#salaryMinEmpty', 'Enter a valid salary minimum.');
            isValid = false;
        } else {
            hideError('#salaryMin', '#salaryMinEmpty');
        }

        if (!maxVal || isNaN(maxVal) || maxVal < 0) {
            showError('#salaryMax', '#salaryMaxEmpty', 'Enter a valid salary maximum.');
            isValid = false;
        } else if (maxVal < minVal) {
            showError('#salaryMax', '#salaryMaxEmpty', 'Max salary must be greater than or equal to min salary.');
            isValid = false;
        } else {
            hideError('#salaryMax', '#salaryMaxEmpty');
        }

        return isValid;
    }

    function validateAges() {
        const minAge = parseInt($('#min_age').val()?.trim() || '0', 10);
        const maxAge = parseInt($('#max_age').val()?.trim() || '0', 10);
        let isValid = true;

        if (isNaN(minAge) || minAge < 18 || minAge > 100) {
            showError('#min_age', '#minAgeEmpty', 'Min age must be between 18 and 100.');
            isValid = false;
        } else {
            hideError('#min_age', '#minAgeEmpty');
        }

        if (isNaN(maxAge) || maxAge < 18 || maxAge > 100) {
            showError('#max_age', '#maxAgeEmpty', 'Max age must be between 18 and 100.');
            isValid = false;
        } else if (maxAge < minAge) {
            showError('#max_age', '#maxAgeEmpty', 'Max age must be greater than min age.');
            isValid = false;
        } else {
            hideError('#max_age', '#maxAgeEmpty');
        }

        return isValid;
    }

    function showError(field, errorField, message) {
        $(field).addClass('border-danger');
        $(errorField).text(message).show();
    }

    function hideError(field, errorField) {
        $(field).removeClass('border-danger');
        $(errorField).text('').hide();
    }
});



</script>


@endsection
