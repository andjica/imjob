$(document).ready(function () {

    // Function to toggle the visibility of special requirements fields
    function toggleSpecialRequirements() {
        if ($('#has_special_requirements').is(':checked')) {
            $('#specialRequirementsFields').removeClass('d-none');
        } else {
            $('#specialRequirementsFields').addClass('d-none');
            // Optionally, clear the input fields when hiding
            $('#special_requirements').val('');
        }
    }

    // Initial check on page load
    toggleSpecialRequirements();

    // Event listener for checkbox change
    $('#has_special_requirements').on('change', function () {
        toggleSpecialRequirements();
    });
});
