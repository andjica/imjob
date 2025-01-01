@extends('company-freelancer.template-company-freelancer')

@section('title-dash', 'Create new job')

@section('content')
<div class="container m-0 pb-5">
    <div class="row">
    <div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <h3 class="card-title">Create New Job</h3>
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-3">
        <form action="" method="POST" id="jobForm">
            @csrf
             <!-- Job Title -->
             <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Job Title:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control form-control-solid @error('title') is-invalid @enderror" name="title" id="title"
                        value="{{ old('title') }}"/>
                    <span class="text-danger" id="titleEmpty">@error('title'){{ $message }}@enderror</span>
                </div>
            </div>
             <!-- Description Field with CKEditor -->
                <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Job Description</label>
                <div class="col-lg-9">
                    <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" name="description" id="description"
                        rows="6">{{ old('description') }}</textarea>
                    <span class="text-danger" id="descriptionEmpty">@error('description'){{ $message }}@enderror</span>
                </div>
            </div>
            <!-- Category -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Category:</label>
                <div class="col-lg-9">
                    <select name="categoryId" id="categoryId" data-control="select2"
                        class="form-control form-control-solid @error('categoryId') is-invalid @enderror" >
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
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">SubCategory</label>
                <div class="col-lg-9">
                    <select name="subCategoryId" id="subCategoryId" data-control="select2"
                        class="form-control form-control-solid @error('subCategoryId') is-invalid @enderror" >
                        <option value="">Select a SubCategory</option>
                            <option value="">
                            </option>
                    </select>
                    <span class="text-danger" id="subCategoryIdEmpty">@error('subCategoryId'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Country -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Country:</label>
                <div class="col-lg-9">
                    <select name="countryId" id="countryId" data-control="select2"
                        class="form-control form-control-solid @error('countryId') is-invalid @enderror" >
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

            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">City</label>
                <div class="col-lg-9">
                    <select name="cityId" id="cityId" data-control="select2"
                        class="form-control form-control-solid @error('cityId') is-invalid @enderror" >
                        <option value="">Select a City</option>
                            <option value="">
                            </option>
                    </select>
                    <span class="text-danger" id="cityIdEmpty">@error('cityId'){{ $message }}@enderror</span>
                </div>
            </div>
            <!-- Job Type -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Job Type:</label>
                <div class="col-lg-9">
                    <select name="job_type_id" id="job_type_id" data-control="select2"
                        class="form-control form-control-solid @error('job_type_id') is-invalid @enderror" >
                        <option value="">Select a Job Type</option>
                        @foreach ($jobTypes as $jobType)
                            <option value="{{ $jobType->id }}" {{ old('job_type_id') == $jobType->id ? 'selected' : '' }}>
                                {{ $jobType->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="jobTypeIdEmpty">@error('job_type_id'){{ $message }}@enderror</span>
                </div>
            </div>

           


            <!-- Salary Minimum -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Salary (Min):</label>
                <div class="col-lg-9">
                    <input type="number" step="0.01" class="form-control form-control-solid @error('salary_min') is-invalid @enderror" name="salary_min" id="salary_min"
                        value="{{ old('salary_min') }}" />
                    <span class="text-danger" id="salaryMinEmpty">@error('salary_min'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Salary Maximum -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Salary (Max):</label>
                <div class="col-lg-9">
                    <input type="number" step="0.01" class="form-control form-control-solid @error('salary_max') is-invalid @enderror" name="salary_max" id="salary_max"
                        value="{{ old('salary_max') }}" />
                    <span class="text-danger" id="salaryMaxEmpty">@error('salary_max'){{ $message }}@enderror</span>
                </div>
            </div>
            <!-- Currency Information -->
            <div class="row mb-5 d-none" id="currencyInfoRow">
                <label class="col-lg-3 col-form-label fw-bold fs-6">Currency Information:</label>
                <div class="col-lg-9">
                    <div class="alert alert-info" role="alert">
                        <strong>Currency Name:</strong> <span id="currencyName">N/A</span><br>
                        <strong>Currency Symbol:</strong> <span id="currencySymbol">N/A</span>
                    </div>
                </div>
            </div>
            <!-- Experience Level -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Experience Level:</label>
                <div class="col-lg-9">
                    <select name="experience_level" id="experience_level" class="form-control form-control-solid @error('experience_level') is-invalid @enderror" >
                        <option value="">Select Experience Level</option>
                        @foreach (['Entry-Level', 'Mid-Level', 'Senior-Level', 'Managerial'] as $level)
                            <option value="{{ $level }}" {{ old('experience_level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="experienceLevelEmpty">@error('experience_level'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Required Skills -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Required Skill:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control form-control-solid @error('required_skills') is-invalid @enderror" name="required_skills" id="required_skills"
                        value="{{ old('required_skills') }}" />
                    <span class="text-danger" id="requiredSkillsEmpty">@error('required_skills'){{ $message }}@enderror</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-3 col-form-label fw-bold fs-6">More Skills:</label>
                <div class="col-lg-9">
                    <div id="skillsContainer">
                        <div class="input-group mb-2 skill-input-group">
                            <input type="text" class="form-control form-control-solid" name="required_skills[]" placeholder="Enter a skill" />
                            <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <span class="text-danger" id="requiredSkillsEmpty"></span>
                </div>
            </div>
            <!-- Age Range -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6">Age Range:</label>
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

           <!-- Special Requirements -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6">Special Requirements:</label>
                <div class="col-lg-9">
                    <div class="form-check form-switch">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="special_requirements" 
                            name="special_requirements" 
                            {{ old('special_requirements') ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="special_requirements">
                            Check if there are special requirements.
                        </label>
                    </div>
                    <span class="text-danger" id="specialRequirementsEmpty">
                        @error('special_requirements'){{ $message }}@enderror
                    </span>
                </div>
            </div>

            <!-- Additional Special Requirements Fields -->
            <div class="row mb-5 d-none" id="specialRequirementsFields">
                <label for="special_details" class="col-lg-3 col-form-label fw-bold fs-6">Details:</label>
                <div class="col-lg-9">
                    <textarea 
                        class="form-control form-control-solid @error('special_details') is-invalid @enderror" 
                        name="special_details" 
                        id="special_details" 
                        rows="4" 
                        placeholder="Enter any special requirements here..."
                    >{{ old('special_details') }}</textarea>
                    <span class="text-danger" id="specialDetailsEmpty">
                        @error('special_details'){{ $message }}@enderror
                    </span>
                </div>
            </div>

            <!-- Valid Until -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Valid Until:</label>
                <div class="col-lg-9">
                    <input type="date" class="form-control form-control-solid @error('valid_until') is-invalid @enderror" name="valid_until" id="valid_until"
                        value="{{ old('valid_until') }}"/>
                    <span class="text-danger" id="validUntilEmpty">@error('valid_until'){{ $message }}@enderror</span>
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
                <button type="submit" class="btn btn-primary">Create Job</button>
            </div>
        </form>
    </div>
    <!--end::Card body-->
</div>

<!-- Initialize Select2 -->


    </div>
</div>
   
@endsection
@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script>
let jobDescriptionEditor;
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
                jobDescriptionEditor = editor;
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
</script>
<script src="{{asset('/js/custom/job/country-category-ajax.js')}}"></script>
<script src="{{asset('/js/custom/job/toogle-special-requirements.js')}}"></script>
<script src="{{asset('/js/custom/job/optional-skills.js')}}"></script>
<script src="{{asset('/js/custom/job/form-submit-validation.js')}}"></script>
@endsection
