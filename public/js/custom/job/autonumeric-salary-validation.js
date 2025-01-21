$(document).ready(function() {
    // Initialize AutoNumeric with desired options
    const autoNumericOptions = {
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        decimalPlaces: 2,
        unformatOnSubmit: true, // Ensures the form submits the unformatted number
    };

    // Initialize AutoNumeric instances for salaryMin and salaryMax
    const anSalaryMin = new AutoNumeric('#salaryMin', autoNumericOptions);
    const anSalaryMax = new AutoNumeric('#salaryMax', autoNumericOptions);

    /**
     * Validates that salaryMin <= salaryMax.
     * Displays error messages accordingly.
     */
    function validateSalaries() {
        // Get the numeric values from AutoNumeric instances
        const minVal = anSalaryMin.getNumber(); // Gets the numeric value
        const maxVal = anSalaryMax.getNumber();

        // Clear previous error messages and styles
        $('#salaryMinEmpty').text('').hide();
        $('#salaryMaxEmpty').text('').hide();
        $('#salaryMin').removeClass('border-danger');
        $('#salaryMax').removeClass('border-danger');

        let isValid = true;

        // Perform validation only if both values are valid numbers
        if (!isNaN(minVal) && !isNaN(maxVal)) {
            if (minVal > maxVal) {
                $('#salaryMax').addClass('border-danger');
                $('#salaryMaxEmpty').text('Maximum salary must be greater than or equal to minimum salary.').show();
                isValid = false;
            }
           
        }

        return isValid;
    }

    // Attach event listeners to the input fields for real-time validation
    $('#salaryMin, #salaryMax').on('input change', function() {
        validateSalaries();
    });

    // Initial validation on page load
    validateSalaries();
});