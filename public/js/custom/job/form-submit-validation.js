$('#jobForm').submit(function(event) {
    // Prevent form submission for validation
    event.preventDefault();

    // Get values from the form fields
    var title = $('#title').val().trim();
    var description = jobDescriptionEditor ? jobDescriptionEditor.getData().trim() : $('#description').val().trim();
    var categoryId = $('#categoryId').val();
    var subCategoryId = $('#subCategoryId').val();
    var countryId = $('#countryId').val();
    var cityId = $('#cityId').val();
    var jobTypeId = $('#job_type_id').val();
    var salaryMin = $('#salary_min').val().trim();
    var salaryMax = $('#salary_max').val().trim();
    var experienceLevel = $('#experience_level').val();
    var requiredSkills = [];
    $('input[name="required_skills[]"]').each(function() {
        var skill = $(this).val().trim();
        if (skill !== '') {
            requiredSkills.push(skill);
        }
    });
    var minAge = $('#min_age').val().trim();
    var maxAge = $('#max_age').val().trim();
    var specialRequirements = $('#special_requirements').is(':checked');
    var specialDetails = $('#special_details').val().trim();
    var validUntil = $('#valid_until').val().trim();

    // Clear previous error states
    $('.border-danger').removeClass('border-danger');
    $('.text-danger').text('').hide();

    // Initialize validation flag
    var isValid = true;

    // Validate Job Title
    if (title === '') {
        $('#title').addClass('border-danger');
        $('#titleEmpty').text('Job Title is required.').show();
        isValid = false;
    }

    // Validate Job Description
    if (description === '') {
        $('#description').addClass('border-danger');
        $('#descriptionEmpty').text('Job Description is required.').show();
        isValid = false;
    }

    // Validate Category
    if (categoryId === '') {
        $('#categoryId').addClass('border-danger');
        $('#categoryIdEmpty').text('Please select a category.').show();
        isValid = false;
    }

    // Validate SubCategory
    if (subCategoryId === '') {
        $('#subCategoryId').addClass('border-danger');
        $('#subCategoryIdEmpty').text('Please select a subcategory.').show();
        isValid = false;
    }

    // Validate Country
    if (countryId === '') {
        $('#countryId').addClass('border-danger');
        $('#countryIdEmpty').text('Please select a country.').show();
        isValid = false;
    }

    // Validate City
    if (cityId === '') {
        $('#cityId').addClass('border-danger');
        $('#cityIdEmpty').text('Please select a city.').show();
        isValid = false;
    }

    // Validate Job Type
    if (jobTypeId === '') {
        $('#job_type_id').addClass('border-danger');
        $('#jobTypeIdEmpty').text('Please select a job type.').show();
        isValid = false;
    }

    // Validate Salary Minimum
    if (salaryMin === '') {
        $('#salary_min').addClass('border-danger');
        $('#salaryMinEmpty').text('Salary minimum is required.').show();
        isValid = false;
    } else if (isNaN(salaryMin) || parseFloat(salaryMin) < 0) {
        $('#salary_min').addClass('border-danger');
        $('#salaryMinEmpty').text('Please enter a valid salary minimum.').show();
        isValid = false;
    }

    // Validate Salary Maximum
    if (salaryMax === '') {
        $('#salary_max').addClass('border-danger');
        $('#salaryMaxEmpty').text('Salary maximum is required.').show();
        isValid = false;
    } else if (isNaN(salaryMax) || parseFloat(salaryMax) < 0) {
        $('#salary_max').addClass('border-danger');
        $('#salaryMaxEmpty').text('Please enter a valid salary maximum.').show();
        isValid = false;
    } else if (salaryMin !== '' && parseFloat(salaryMax) < parseFloat(salaryMin)) {
        $('#salary_max').addClass('border-danger');
        $('#salaryMaxEmpty').text('Salary maximum must be greater than or equal to salary minimum.').show();
        isValid = false;
    }

    // Validate Experience Level
    if (experienceLevel === '') {
        $('#experience_level').addClass('border-danger');
        $('#experienceLevelEmpty').text('Please select an experience level.').show();
        isValid = false;
    }

    // Validate Required Skills
    if (requiredSkills.length === 0) {
        $('input[name="required_skills[]"]').addClass('border-danger');
        $('#requiredSkillsEmpty').text('Please enter at least one required skill.').show();
        isValid = false;
    }

    // Validate Age Range
    if (minAge !== '' && isNaN(minAge)) {
        $('#min_age').addClass('border-danger');
        $('#minAgeEmpty').text('Please enter a valid minimum age.').show();
        isValid = false;
    }
    if (maxAge !== '' && isNaN(maxAge)) {
        $('#max_age').addClass('border-danger');
        $('#maxAgeEmpty').text('Please enter a valid maximum age.').show();
        isValid = false;
    }
    if (minAge !== '' && maxAge !== '' && parseInt(maxAge) < parseInt(minAge)) {
        $('#max_age').addClass('border-danger');
        $('#maxAgeEmpty').text('Maximum age must be greater than or equal to minimum age.').show();
        isValid = false;
    }

    // Validate Special Requirements Details if checkbox is checked
    if (specialRequirements) {
        if (specialDetails === '') {
            $('#special_details').addClass('border-danger');
            $('#specialDetailsEmpty').text('Please provide details for special requirements.').show();
            isValid = false;
        }
    }

    // Validate Valid Until
    if (validUntil === '') {
        $('#valid_until').addClass('border-danger');
        $('#validUntilEmpty').text('Please select a valid date.').show();
        isValid = false;
    } else {
        var selectedDate = new Date(validUntil);
        var today = new Date();
        today.setHours(0,0,0,0); // Remove time portion
        if (selectedDate < today) {
            $('#valid_until').addClass('border-danger');
            $('#validUntilEmpty').text('Valid Until date must be in the future.').show();
            isValid = false;
        }
    }

    // If validation passes, submit the form
    if (isValid) {
        // Optionally, show a loading indicator or disable the submit button to prevent multiple submissions
        // For example:
        // $('#jobForm button[type="submit"]').prop('disabled', true);

        // Submit the form
        this.submit();
    } else {
        // Optionally, focus the first invalid input for better UX
        $('.border-danger').first().focus();
    }
});