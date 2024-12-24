$(document).ready(function () {
    var totalFields = 4; // Total number of fields to validate
    var validFields = 2; // Start at 50% completion (2 out of 4 fields)

    function updateProfileProgress() {
        var progress = (validFields / totalFields) * 100; // Calculate percentage
        $('#profileProgressBar').css('width', progress + '%').attr('aria-valuenow', progress);
        $('#profileProgressText').text(Math.round(progress) + '% Completed');

        if (progress === 100) {
            $('#profileSuccessMessage').fadeIn();
        } else {
            $('#profileSuccessMessage').fadeOut();
        }
    }

    function validateField(input, errorSpan, message) {
        if (input.val().trim() === '') {
            input.addClass('border-danger').removeClass('border-success');
            errorSpan.text(message);
            return false;
        } else {
            input.removeClass('border-danger').addClass('border-success');
            errorSpan.text('');
            return true;
        }
    }

    // Field Validations
    $('#school').on('keyup', function () {
        var isValid = validateField($(this), $('#schoolEmpty'), 'School name is required.');
        validFields = isValid ? 3 : 2;
        updateProfileProgress();
    });

    $('#degree').on('keyup', function () {
        var isValid = validateField($(this), $('#degreeEmpty'), 'Degree is required.');
        validFields = isValid ? 3.5 : 2;
        updateProfileProgress();
    });

    $('#fieldOfStudy').on('keyup', function () {
        var isValid = validateField($(this), $('#fieldOfStudyEmpty'), 'Field of study is required.');
        validFields = isValid ? 4 : 2;
        updateProfileProgress();
    });

    $('#yearOfGraduation').on('keyup', function () {
        var year = $(this).val().trim();
        var currentYear = new Date().getFullYear();

        if (year === '' || isNaN(year) || year < 1900 || year > currentYear) {
            $(this).addClass('border-danger').removeClass('border-success');
            $('#yearOfGraduationEmpty').text('Enter a valid year.');
            validFields = 2;
        } else {
            $(this).removeClass('border-danger').addClass('border-success');
            $('#yearOfGraduationEmpty').text('');
            validFields = 4;
        }
        updateProfileProgress();
    });

    // Initialize the progress bar on page load
    updateProfileProgress();
});


        $('#recruiterEducationForm').submit(function(event) {

        // Prevent form submission for validation
        event.preventDefault();

        // Clear previous error messages and borders
        $('.text-danger').text('');
        $('.form-control').removeClass('border-danger').removeClass('border-success');

        // Get values from the form fields
        var school = $('#school').val().trim();
        var degree = $('#degree').val().trim();
        var fieldOfStudy = $('#fieldOfStudy').val().trim();
        var yearOfGraduation = $('#yearOfGraduation').val().trim();
        var description = $('#description').val().trim();

        // Validation flag
        var isValid = true;

        // School Validation
        if (school === '') {
            $('#school').addClass('border-danger');
            $('#schoolEmpty').text('School name is required.');
            isValid = false;
        } else {
            $('#school').addClass('border-success');
        }

        // Degree Validation
        if (degree === '') {
            $('#degree').addClass('border-danger');
            $('#degreeEmpty').text('Degree is required.');
            isValid = false;
        } else {
            $('#degree').addClass('border-success');
        }

        // Field of Study Validation (Optional, but check length)
        if (fieldOfStudy.length > 50) {
            $('#fieldOfStudy').addClass('border-danger');
            $('#fieldOfStudyEmpty').text('Field of study should not exceed 50 characters.');
            isValid = false;
        } else if (fieldOfStudy !== '') {
            $('#fieldOfStudy').addClass('border-success');
        }

        // Year of Graduation Validation
        if (yearOfGraduation === '') {
            $('#yearOfGraduation').addClass('border-danger');
            $('#yearOfGraduationEmpty').text('Year of graduation is required.');
            isValid = false;
        } else if (isNaN(yearOfGraduation) || yearOfGraduation < 1900 || yearOfGraduation > new Date().getFullYear()) {
            $('#yearOfGraduation').addClass('border-danger');
            $('#yearOfGraduationEmpty').text('Please enter a valid year (e.g., 2022).');
            isValid = false;
        } else {
            $('#yearOfGraduation').addClass('border-success');
        }

        // Description Validation (Optional)
        if (description.length > 200) {
            $('#description').addClass('border-danger');
            $('#descriptionEmpty').text('Description should not exceed 200 characters.');
            isValid = false;
        } else {
            $('#description').addClass('border-success');
        }

        // If validation passes, submit the form
        if (isValid) {
            this.submit(); // Submit the form normally
        }
        });