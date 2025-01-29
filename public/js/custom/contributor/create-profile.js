$(document).ready(function () {
    const contributorTypeSelect = $('#contributorTypeId');
    const customTypeWrapper = $('#customContributorTypeWrapper');
    const customTypeInput = $('#customContributorType');

    // Function to toggle visibility of the custom input field
    const toggleCustomTypeField = () => {
        const selectedOption = contributorTypeSelect.find('option:selected');
        const isOther = selectedOption.data('is-other') === true;

        if (isOther) {
            customTypeWrapper.removeClass('d-none');
            customTypeInput.prop('required', true); // Make the custom input required
        } else {
            customTypeWrapper.addClass('d-none');
            customTypeInput.prop('required', false).val(''); // Remove required and clear value
        }
    };

    // Event listener for dropdown change
    contributorTypeSelect.on('change', toggleCustomTypeField);

    // Initialize visibility on page load
    toggleCustomTypeField();

    $('#contributorForm').submit(function (event) {
        event.preventDefault();
        
        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const contributorTypeId = $('#contributorTypeId').val();
        const customContributorType = $('#customContributorType').val().trim();
        const countryId = $('#countryId').val();
        const cityId = $('#cityId').val();

        // Clear previous validation errors
        $('.border-danger').removeClass('border-danger');

        let isValid = true;

        // Validate Name
        if (name === '') {
            $('#name').addClass('border-danger');
            $('#nameEmpty').text('Contributor name is required.').show();
            isValid = false;
        }

        // Validate Email
        if (email === '') {
            $('#email').addClass('border-danger');
            $('#emailEmpty').text('Contributor email is required.').show();
            isValid = false;
        }

        // Validate Contributor Type
        if (!contributorTypeId) {
            $('#contributorTypeId').next('.select2-container').find('.select2-selection').addClass('border-danger');
            $('#contributorTypeIdEmpty').text('Please select a contributor type.').show();
            isValid = false;
        }

        // Validate Custom Contributor Type if 'Other' is selected
        if ($('#contributorTypeId option:selected').attr('data-is-other') === "true" && customContributorType === '') {
            $('#customContributorType').addClass('border-danger');
            $('#customContributorTypeEmpty').text('Please specify your contributor type.').show();
            isValid = false;
        }

        // Validate Country
        if (!countryId) {
            $('#countryId').next('.select2-container').find('.select2-selection').addClass('border-danger');
            $('#countryIdEmpty').text('Please select a country.').show();
            isValid = false;
        }

        // Validate City
        if (!cityId) {
            $('#cityId').next('.select2-container').find('.select2-selection').addClass('border-danger');
            $('#cityIdEmpty').text('Please select a city.').show();
            isValid = false;
        }

        // Submit form if all fields are valid
        if (isValid) {
            $('#contributorForm')[0].submit();
        }
    });

    $("#name").on('keyup',function(){
    
        var name = $("#name").val();
        if(name == "")
        {
            $("#nameEmpty").text("Title is required field");
            $('#name').addClass('border-danger').removeClass('border-success');
        }
        
        else {
            $("#nameEmpty").text("");
            $('#name').removeClass('border-danger').addClass('border-success');
        }
    });
   

    $("#email").on('keyup', function() {
        var email = $("#email").val();
        var emailFilter = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Regex for email validation
        
        if (!emailFilter.test(email)) {
            $("#emailEmpty").text("Please enter a valid email address.");
            $('#email').addClass('border-danger').removeClass('border-success');
            $('#email').next('.invalid-feedback').show();
        } else {
            $("#emailEmpty").text("");
            $('#email').removeClass('border-danger').addClass('border-success');
        }
    });

    // Validate Country Selection
    $('#countryId').on('change', function () {
        var countryIdSelect = $(this);
        var selectedValue = countryIdSelect.val();
        var select2Container = countryIdSelect.next('.select2-container').find('.select2-selection');

        if (selectedValue === "") {
            $("#countryIdEmpty").text("Please choose a valid country").show();
            countryIdSelect.addClass('border-danger').removeClass('border-success');
            select2Container.addClass('border-danger').removeClass('border-success');
        } else {
            $("#countryIdEmpty").text("").hide();
            countryIdSelect.removeClass('border-danger').addClass('border-success');
            select2Container.removeClass('border-danger').addClass('border-success');
        }
    });

    // Validate City Selection
    $('#cityId').on('change', function () {
        var cityIdSelect = $(this);
        var selectedValue = cityIdSelect.val();
        var select2Container = cityIdSelect.next('.select2-container').find('.select2-selection');

        if (selectedValue === "") {
            $("#cityIdEmpty").text("Please choose a valid city").show();
            cityIdSelect.addClass('border-danger').removeClass('border-success');
            select2Container.addClass('border-danger').removeClass('border-success');
        } else {
            $("#cityIdEmpty").text("").hide();
            cityIdSelect.removeClass('border-danger').addClass('border-success');
            select2Container.removeClass('border-danger').addClass('border-success');
        }
    });

    // Validate Contributor Type Selection
    $('#contributorTypeId').on('change', function () {
        var contributorTypeIdSelect = $(this);
        var selectedValue = contributorTypeIdSelect.val();
        var select2Container = contributorTypeIdSelect.next('.select2-container').find('.select2-selection');

        if (selectedValue === "") {
            $("#contributorTypeIdEmpty").text("Please choose a valid contributor type").show();
            contributorTypeIdSelect.addClass('border-danger').removeClass('border-success');
            select2Container.addClass('border-danger').removeClass('border-success');
        } else {
            $("#contributorTypeIdEmpty").text("").hide();
            contributorTypeIdSelect.removeClass('border-danger').addClass('border-success');
            select2Container.removeClass('border-danger').addClass('border-success');
        }
    });

});