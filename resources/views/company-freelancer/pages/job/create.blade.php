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
            <!-- Category -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Category:</label>
                <div class="col-lg-9">
                    <select name="categoryId" id="categoryId" data-control="select2"
                        class="form-control form-control-solid @error('categoryId') is-invalid @enderror" required>
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
                        class="form-control form-control-solid @error('subCategoryId') is-invalid @enderror" required>
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
                        class="form-control form-control-solid @error('countryId') is-invalid @enderror" required>
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
                        class="form-control form-control-solid @error('cityId') is-invalid @enderror" required>
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
                        class="form-control form-control-solid @error('job_type_id') is-invalid @enderror" required>
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

            <!-- Job Title -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Job Title:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control form-control-solid @error('title') is-invalid @enderror" name="title" id="title"
                        value="{{ old('title') }}" required />
                    <span class="text-danger" id="titleEmpty">@error('title'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Description -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Description:</label>
                <div class="col-lg-9">
                    <textarea name="description" id="description" class="form-control form-control-solid @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
                    <span class="text-danger" id="descriptionEmpty">@error('description'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Salary Minimum -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6">Salary (Min):</label>
                <div class="col-lg-9">
                    <input type="number" step="0.01" class="form-control form-control-solid @error('salary_min') is-invalid @enderror" name="salary_min" id="salary_min"
                        value="{{ old('salary_min') }}" />
                    <span class="text-danger" id="salaryMinEmpty">@error('salary_min'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Salary Maximum -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6">Salary (Max):</label>
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
                    <select name="experience_level" id="experience_level" class="form-control form-control-solid @error('experience_level') is-invalid @enderror" required>
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
                <label class="col-lg-3 col-form-label fw-bold fs-6">Required Skills:</label>
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
                        <input class="form-check-input" type="checkbox" id="special_requirements" name="special_requirements" {{ old('special_requirements') ? 'checked' : '' }}>
                        <label class="form-check-label" for="special_requirements">Check if there are special requirements.</label>
                    </div>
                    <span class="text-danger" id="specialRequirementsEmpty">@error('special_requirements'){{ $message }}@enderror</span>
                </div>
            </div>

            <!-- Valid Until -->
            <div class="row mb-5">
                <label class="col-lg-3 col-form-label fw-bold fs-6 required">Valid Until:</label>
                <div class="col-lg-9">
                    <input type="date" class="form-control form-control-solid @error('valid_until') is-invalid @enderror" name="valid_until" id="valid_until"
                        value="{{ old('valid_until') }}" required />
                    <span class="text-danger" id="validUntilEmpty">@error('valid_until'){{ $message }}@enderror</span>
                </div>
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
<script>
    $(document).ready(function() {
        $("#countryId").on("change", function () {
            var countryId = $(this).val();
            var cityRow = $("#cityRow"); // Assuming you have a row with id 'cityRow' for cities
            var currencyInfoRow = $("#currencyInfoRow");

            // Reset city dropdown
            $("#cityId").html('<option value="">Select a city</option>');

            // Reset currency information
            $("#currencyName").text('N/A');
            $("#currencySymbol").text('N/A');
            currencyInfoRow.addClass("d-none");

            if (countryId) {
                // Fetch Cities
                $.ajax({
                    url: '/cities/' + countryId,
                    method: 'GET',
                    success: function (response) {
                        console.log('Cities Response:', response);
                        if (response.cities && response.cities.length > 0) {
                            response.cities.forEach(function (city) {
                                $("#cityId").append(
                                    '<option value="' + city.id + '">' + city.name + '</option>'
                                );
                            });
                            // Show the city row if cities are available
                            cityRow.removeClass("d-none");
                        } else {
                            $("#cityId").append('<option value="">No cities found</option>');
                            // Optionally hide the city row if no cities are found
                            cityRow.addClass("d-none");
                        }
                    },
                    error: function () {
                        alert("Failed to fetch cities. Please try again.");
                        // Optionally hide the city row on error
                        cityRow.addClass("d-none");
                    },
                });

                // Fetch Currency Information
                $.ajax({
                    url: '/country/' + countryId + '/currency',
                    method: 'GET',
                    success: function (response) {
                        console.log('Currency Response:', response);
                        if (response.currency_name && response.currency_symbol) {
                            $("#currencyName").text(response.currency_name);
                            $("#currencySymbol").text(response.currency_symbol);
                            currencyInfoRow.removeClass("d-none");
                        } else {
                            $("#currencyName").text('N/A');
                            $("#currencySymbol").text('N/A');
                            currencyInfoRow.addClass("d-none");
                        }
                    },
                    error: function () {
                        alert("Failed to fetch currency information. Please try again.");
                        currencyInfoRow.addClass("d-none");
                    },
                });
            } else {
                // Hide the city and currency rows if no country is selected
                cityRow.addClass("d-none");
                currencyInfoRow.addClass("d-none");
            }
        });

    $("#categoryId").on("change", function () {
        var categoryId = $(this).val();
        var subCategoryRow = $("#subCategoryRow");
        
        // Reset subCategory dropdown
        $("#subCategoryId").html('<option value="">Select a subCategory</option>');
        
        if (categoryId) {
          
           
            // Make AJAX call to fetch subcategories
            $.ajax({
                url: '/subcategories/' + categoryId, 
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    if (response.subcategories && response.subcategories.length > 0) {
                        response.subcategories.forEach(function (subCategory) {
                            $("#subCategoryId").append(
                                '<option value="' + subCategory.id + '">' + subCategory.name + '</option>'
                            );
                        });
                    } else {
                        $("#subCategoryId").append('<option value="">No subcategories found</option>');
                    }
                },
                error: function () {
                    alert("Failed to fetch subcategories. Please try again.");
                },
            });
        }
    });
    });

</script>

<script>
    $(document).ready(function() {
        // Function to add a new skill input group
        function addSkillInput() {
            // Create the new input group
            var newInputGroup = `
                <div class="input-group mb-2 skill-input-group">
                    <input type="text" class="form-control form-control-solid" name="required_skills[]" placeholder="Enter a skill" />
                    <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button class="btn btn-danger remove-skill-btn" type="button" title="Remove Skill">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            `;
            // Append the new input group to the container
            $('#skillsContainer').append(newInputGroup);
            // Toggle remove buttons visibility
            toggleRemoveButtons();
        }

        // Function to toggle the visibility of remove buttons
        function toggleRemoveButtons() {
            var totalSkillInputs = $('.skill-input-group').length;
            if (totalSkillInputs > 1) {
                $('.remove-skill-btn').show();
            } else {
                $('.remove-skill-btn').hide();
            }
        }

        // Event listener for adding a new skill input
        $('#skillsContainer').on('click', '.add-skill-btn', function() {
            addSkillInput();
        });

        // Event listener for removing a skill input
        $('#skillsContainer').on('click', '.remove-skill-btn', function() {
            $(this).closest('.skill-input-group').remove();
            toggleRemoveButtons();
        });

        // Initial toggle to set the correct visibility of remove buttons
        toggleRemoveButtons();

        // Optional: Handle form submission with validation
        $('#yourFormId').on('submit', function(e) {
            // Replace '#yourFormId' with the actual ID of your form
            var skills = [];
            $('input[name="required_skills[]"]').each(function() {
                var skill = $(this).val().trim();
                if (skill !== '') {
                    skills.push(skill);
                }
            });

            if (skills.length === 0) {
                e.preventDefault(); // Prevent form submission
                $('#requiredSkillsEmpty').text('Please enter at least one skill.');
            } else {
                $('#requiredSkillsEmpty').text('');
                // Proceed with form submission or additional validation
                // Example: You can send the data via AJAX here
                console.log('Submitted Skills:', skills);
            }
        });
    });
</script>

@endsection
