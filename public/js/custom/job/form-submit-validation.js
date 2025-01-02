$(document).ready(function() {
    $('#jobForm').submit(function(event) {
        // Prevent form submission for validation
        event.preventDefault();

        // Access AutoNumeric instances
        const anSalaryMin = AutoNumeric.getAutoNumericElement('#salaryMin');
        const anSalaryMax = AutoNumeric.getAutoNumericElement('#salaryMax');

        // Get unformatted numeric values
        const salaryMin = anSalaryMin ? anSalaryMin.getNumber() : parseFloat($('#salaryMin').val().replace(/[^0-9.-]+/g,""));
        const salaryMax = anSalaryMax ? anSalaryMax.getNumber() : parseFloat($('#salaryMax').val().replace(/[^0-9.-]+/g,""));

        // Get other form values
        const title = $('#title').val().trim();
        const description = jobDescriptionEditor ? jobDescriptionEditor.getData().trim() : $('#description').val().trim();
        const categoryId = $('#categoryId').val();
        const subCategoryId = $('#subCategoryId').val();
        const countryId = $('#countryId').val();
        const cityId = $('#cityId').val();
        const jobTypeId = $('#jobTypeId').val();
        const experienceLevel = $('#experienceLevel').val();
        const requiredSkills = [];
        $('input[name="requiredSkills[]"]').each(function() {
            const skill = $(this).val().trim();
            if (skill !== '') {
                requiredSkills.push(skill);
            }
        });
        const minAge = $('#min_age').val().trim();
        const maxAge = $('#max_age').val().trim();
        const specialRequirements = $('#special_requirements').is(':checked');
        const specialDetails = $('#special_details').val().trim();
        const validUntil = $('#validUntil').val().trim();

        // Clear previous error states
        $('.border-danger').removeClass('border-danger');
        $('.text-danger').text('').hide();

        // Initialize validation flag
        let isValid = true;

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
            $('#jobTypeId').addClass('border-danger');
            $('#jobTypeIdEmpty').text('Please select a job type.').show();
            isValid = false;
        }

    

        // Validate Salary Minimum
        if (isNaN(salaryMin) || salaryMin < 0 || salaryMin == "") {
            $('#salaryMin').addClass('border-danger');
            $('#salaryMinEmpty').text('Please enter a valid salary minimum.').show();
            isValid = false;
        }

        // Validate Salary Maximum
        if (isNaN(salaryMax) || salaryMax < 0 || salaryMax ==  "") {
            $('#salaryMax').addClass('border-danger');
            $('#salaryMaxEmpty').text('Please enter a valid salary maximum.').show();
            isValid = false;
        } else if (!isNaN(salaryMin) && salaryMax < salaryMin) {
            $('#salaryMax').addClass('border-danger');
            $('#salaryMaxEmpty').text('Salary maximum must be greater than or equal to salary minimum.').show();
            isValid = false;
        }

        // Validate Experience Level
        if (experienceLevel === '') {
            $('#experienceLevel').addClass('border-danger');
            $('#experienceLevelEmpty').text('Please select an experience level.').show();
            isValid = false;
        }

        // Validate Required Skills
        if (requiredSkills.length === 0) {
            $('input[name="requiredSkills[]"]').addClass('border-danger');
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
        if (!validateValidUntil()) {
            isValid = false;
        }

        // If validation passes, submit the form
        if (isValid) {
            // Optionally, disable the submit button to prevent multiple submissions
            // $('#jobForm button[type="submit"]').prop('disabled', true);

            // Submit the form
            //this.submit();
            var companyModal = new bootstrap.Modal(document.getElementById('companyModal'), {
                backdrop: 'static',
                keyboard: false
            });
            companyModal.show();
        } else {
            // Optionally, focus the first invalid input for better UX
            $('.border-danger').first().focus();
        }
    });
    $('#confirmCompany').on('click', function() {
        const companyName = $('#companyName').val().trim();

        // Clear previous error messages
        $('#companyNameEmpty').text('').hide();
        $('#companyName').removeClass('border-danger');

        let isValid = true;

        // Validate Company Name
        if (companyName === '') {
            $('#companyName').addClass('border-danger');
            $('#companyNameEmpty').text('Company name is required.').show();
            isValid = false;
        }

        if (isValid) {
            // Optionally, you can add the company name to the main form as a hidden input
            if ($('#companyNameHidden').length === 0) {
                $('#jobForm').append('<input type="hidden" id="companyNameHidden" name="companyName" value="' + companyName + '">');
            } else {
                $('#companyNameHidden').val(companyName);
            }

            // Hide the modal
            var companyModalEl = document.getElementById('companyModal');
            var companyModal = bootstrap.Modal.getInstance(companyModalEl);
            companyModal.hide();

            // Optionally, disable the submit button to prevent multiple submissions
            // $('#jobForm button[type="submit"]').prop('disabled', true);

            // Submit the form
            $('#jobForm')[0].submit();
        }
    });

    /**
     * Optional: Reset the modal form when it's hidden.
     */
    $('#companyModal').on('hidden.bs.modal', function () {
        $('#companyForm')[0].reset();
        $('#companyName').removeClass('border-danger');
        $('#companyNameEmpty').text('').hide();
    });
});


$('#categoryId').on('change', function () {
    var categorySelect = $(this); // Reference the select element
    var selectedValue = categorySelect.val(); // Get the selected value
    var select2Container =  categorySelect.next('.select2-container').find('.select2-selection');

    if (selectedValue === "") {
        $("#categoryIdEmpty").text("Please choose a valid category");
        categorySelect.addClass('border-danger').removeClass('border-success');
        select2Container.addClass('border-danger').removeClass('border-success');

    } else {
        $("#categoryIdEmpty").text("");
        categorySelect.removeClass('border-danger').addClass('border-success');
        select2Container.removeClass('border-danger').addClass('border-success');
    }
});

$('#subCategoryId').on('change', function () {
    var subCategorySelect = $(this); // Reference the select element
    var selectedValue = subCategorySelect.val(); // Get the selected value
    var select2Container = subCategorySelect.next('.select2-container').find('.select2-selection');

    if (selectedValue === "") {
        $("#subCategoryIdEmpty").text("Please choose a valid sub category");
        subCategorySelect.addClass('border-danger').removeClass('border-success');
        select2Container.addClass('border-danger').removeClass('border-success');
    } else {
        $("#subCategoryIdEmpty").text("");
        subCategorySelect.removeClass('border-danger').addClass('border-success');
        select2Container.removeClass('border-danger').addClass('border-success');

    }
});
$('#jobTypeId').on('change', function () {
    var jobTypeIdSelect = $(this); // Reference the select element
    var selectedValue = jobTypeIdSelect.val(); // Get the selected value
    var select2Container =  jobTypeIdSelect.next('.select2-container').find('.select2-selection');

    if (selectedValue === "") {
        $("#jobTypeIdEmpty").text("Please choose a job type");
        jobTypeIdSelect.addClass('border-danger').removeClass('border-success');
        select2Container.addClass('border-danger').removeClass('border-success');

    } else {
        $("#jobTypeIdEmpty").text("");
        jobTypeIdSelect.removeClass('border-danger').addClass('border-success');
        select2Container.removeClass('border-danger').addClass('border-success');

    }
});

$('#experienceLevel').on('change', function () {
    var experienceLevelSelect = $(this); // Reference the select element
    var selectedValue = experienceLevelSelect.val(); // Get the selected value

    if (selectedValue === "") {
        $("#experienceLevelEmpty").text("Please experience level");
        experienceLevelSelect.addClass('border-danger').removeClass('border-success');
    } else {
        $("#experienceLevelEmpty").text("");
        experienceLevelSelect.removeClass('border-danger').addClass('border-success');
    }
});
$("#title").on('keyup',function(){
    
    var title = $("#title").val();


    if(title == "")
    {
        
        $("#titleEmpty").text("Title is required field");
        $('#title').addClass('border-danger').removeClass('border-success');
        $('#title').next('.invalid-feedback').show();
    }
    
    else {
        $("#titleEmpty").text("");
        $('#title').removeClass('border-danger').addClass('border-success');
    }
});

$("#requiredSkills").on('keyup',function(){
    
    var requiredSkills = $("#requiredSkills").val();


    if(requiredSkills == "")
    {
        
        $("#requiredSkillsEmpty").text("Required skills is required field");
        $('#requiredSkills').addClass('border-danger').removeClass('border-success');
        $('#requiredSkills').next('.invalid-feedback').show();
    }
    
    else {
        $("#requiredSkillsEmpty").text("");
        $('#requiredSkills').removeClass('border-danger').addClass('border-success');
    }
});



    $('#countryId').on('change', function () {
        var countryIdSelect = $(this); // Reference the select element
        var selectedValue = countryIdSelect.val(); // Get the selected value
        var select2Container =   countryIdSelect.next('.select2-container').find('.select2-selection');

        if (selectedValue === "") {
            $("#countryIdEmpty").text("Please choose a valid country");
            countryIdSelect.addClass('border-danger').removeClass('border-success');
            select2Container.addClass('border-danger').removeClass('border-success');
        } else {
            $("#countryIdEmpty").text("");
            countryIdSelect.removeClass('border-danger').addClass('border-success');
            select2Container.removeClass('border-danger').addClass('border-success');
        }
    });
    
    $('#cityId').on('change', function () {
        var cityIdSelect = $(this); // Reference the select element
        var selectedValue = cityIdSelect.val(); // Get the selected value
        var select2Container =   cityIdSelect.next('.select2-container').find('.select2-selection');

        if (selectedValue === "") {
            $("#cityIdEmpty").text("Please choose a valid city");
            cityIdSelect.addClass('border-danger').removeClass('border-success');
            select2Container.addClass('border-danger').removeClass('border-success');
        } else {
            $("#cityIdEmpty").text("");
            cityIdSelect.removeClass('border-danger').addClass('border-success');
            select2Container.removeClass('border-danger').addClass('border-success');
        }
    });

    function validateValidUntil() {
        const validUntil = $('#validUntil').val().trim();
        const selectedDate = new Date(validUntil);
        const today = new Date();
        today.setHours(0,0,0,0); // Remove time portion
    
        // Define the maximum allowable date (December 31, 2050)
        const maxDate = new Date('2050-12-31');
        maxDate.setHours(23,59,59,999); // Include the entire day
    
        // Clear previous error messages and styles
        $('#validUntilEmpty').text('').hide();
        $('#validUntil').removeClass('border-danger border-success');
    
        // Validation Flags
        let isValid = true;
    
        if (validUntil === '') {
            $('#validUntil').addClass('border-danger');
            $('#validUntilEmpty').text('Please select a valid date.').show();
            isValid = false;
        } else if (isNaN(selectedDate.getTime())) {
            // Invalid date format
            $('#validUntil').addClass('border-danger');
            $('#validUntilEmpty').text('Please enter a valid date.').show();
            isValid = false;
        } else if (selectedDate < today) {
            $('#validUntil').addClass('border-danger');
            $('#validUntilEmpty').text('Valid Until date must be in the future.').show();
            isValid = false;
        } else if (selectedDate > maxDate) {
            $('#validUntil').addClass('border-danger');
            $('#validUntilEmpty').text('Valid Until date cannot be later than December 31, 2050.').show();
            isValid = false;
        }
    
        if (isValid) {
            $('#validUntil').addClass('border-success');
        }
    
        return isValid;
    }
    
    // Attach keyup and change event listeners for real-time validation
    $('#validUntil').on('keyup change', function() {
        validateValidUntil();
    });

    