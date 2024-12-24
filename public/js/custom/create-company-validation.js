$(document).ready(function() {
    $("#countryId").on("change", function () {
        var countryId = $(this).val();
       
        // Reset city dropdown
        $("#cityId").html('<option value="">Select a city</option>');
       
        if (countryId) {
          
            $.ajax({
                url: '/cities/' + countryId, 
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    if (response.cities && response.cities.length > 0) {
                        response.cities.forEach(function (city) {
                            $("#cityId").append(
                                '<option value="' + city.id + '">' + city.name + '</option>'
                            );
                        });
                    } else {
                        $("#cityId").append('<option value="">No cities found</option>');
                    }
                },
                error: function () {
                    alert("Failed to fetch cities. Please try again.");
                },
            });
        } else {
            // Hide the city row if no country is selected
            cityRow.addClass("d-none");
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

    $('#categoryId').on('change', function () {
        var categorySelect = $(this); // Reference the select element
        var selectedValue = categorySelect.val(); // Get the selected value
    
        if (selectedValue === "") {
            $("#categoryEmpty").text("Please choose a valid category");
            categorySelect.addClass('border-danger').removeClass('border-success');
        } else {
            $("#categoryEmpty").text("");
            categorySelect.removeClass('border-danger').addClass('border-success');
        }
    });

    $('#subCategoryId').on('change', function () {
        var subCategorySelect = $(this); // Reference the select element
        var selectedValue = subCategorySelect.val(); // Get the selected value
    
        if (selectedValue === "") {
            $("#subCategoryEmpty").text("Please choose a valid sub category");
            subCategorySelect.addClass('border-danger').removeClass('border-success');
        } else {
            $("#subCategoryEmpty").text("");
            subCategorySelect.removeClass('border-danger').addClass('border-success');
        }
    });
    $("#companyName").on('keyup',function(){
    
    var companyname = $("#companyName").val();


    if(companyname == "")
    {
        
        $("#companyNameEmpty").text("Company name is required field");
        $('#companyName').addClass('border-danger').removeClass('border-success');
        $('#companyName').next('.invalid-feedback').show();
    }
    
    else {
        $("#companyNameEmpty").text("");
        $('#companyName').removeClass('border-danger').addClass('border-success');
    }
    });

    // $('#numberofEmployees').on('keyup', function(){

    //     var numberofEmployees = $("#numberofEmployees").val();


    //     if(numberofEmployees == "")
    //     {
            
    //         $("#numberofEmployeesEmpty").text("Number of Employees is required field");
    //         $('#numberofEmployees').addClass('border-danger');
    //         $('#numberofEmployees').next('.invalid-feedback').show();
    //     }

    //     else {
    //         $("#numberofEmployeesEmpty").text("");
    //         $('#numberofEmployees').removeClass('border-danger');
    //     }
    //     });

    });
    
    $("#registrationNumber").on('keyup',function(){
    
    var registrationNumber = $("#registrationNumber").val();


    if(registrationNumber == "")
    {
        
        $("#registrationNumberEmpty").text("Registration number is required field");
        $('#registrationNumber').addClass('border-danger').removeClass('border-success');
        $('#registrationNumber').next('.invalid-feedback').show();
    }
    
    else {
        $("#registrationNumberEmpty").text("");
        $('#registrationNumber').removeClass('border-danger').addClass('border-success');
    }
    });
    $("#taxNumber").on('keyup',function(){
    
        var taxNumber = $("#taxNumber").val();

        if(taxNumber == "")
        {
            
            $("#taxNumberEmpty").text("Tax number is required field");
            $('#taxNumber').addClass('border-danger').removeClass('border-success');
            $('#taxNumber').next('.invalid-feedback').show();
        }
        
        else {
            $("#taxNumberEmpty").text("");
            $('#taxNumber').removeClass('border-danger').addClass('border-success');
        }
    });
    $("#phoneNumber").on('keyup',function(){
        
    var phone = $("#phoneNumber").val();
    
    var filter = /^\+?[0-9]{1,4}?[-.\s]?[(]?[0-9]{1,5}[)]?[-.\s]?[0-9]+([-.\s]?[0-9]+)*$/;


    if (!filter.test(phone)) {
    
        $("#phoneempty").text("Must start with +31");
        $('#phoneNumber').addClass('border-danger').removeClass('border-success');
        
    
    } else {
        $("#phoneempty").text("");
        $('#phoneNumber').removeClass('border-danger').addClass('border-success');
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

    $("#address").on('keyup', function() {
        var address = $("#address").val();
        if(address == "")
        {
            
            $("#addressEmpty").text("Address is required field");
            $('#address').addClass('border-danger').removeClass('border-success');
            $('#address').next('.invalid-feedback').show();
        }
        
        else {
            $("#addressEmpty").text("");
            $('#address').removeClass('border-danger').addClass('border-success');
        }
    });

    $("#logo").on("change", function () {
        var fileInput = $(this)[0];
        var filePath = fileInput.value;
        var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.svg|\.webp)$/i;

        if (!allowedExtensions.exec(filePath)) {
            $("#logoEmpty").text("Invalid file type. Allowed types: PNG, JPG, JPEG, SVG, WEBP.");
            $(this).val(''); // Clear the input value
        } else {
            $("#logoEmpty").text("");
        }
    });

    $('#companyTypeId').on('change', function () {
        var companyTypeSelect = $(this); // Reference the select element
        var selectedValue = companyTypeSelect.val(); // Get the selected value
    
        if (selectedValue === "") {
            $("#companyTypeEmpty").text("Please choose a valid company");
            companyTypeSelect.addClass('border-danger').removeClass('border-success');
        } else {
            $("#companyTypeEmpty").text("");
            companyTypeSelect.removeClass('border-danger').addClass('border-success');
        }
    });

    $('#ownerTitle').on('change', function () {
        
        var ownerTitleSelect = $(this); // Reference the select element
        var selectedValue = ownerTitleSelect.val(); // Get the selected value
    
        if (selectedValue === "") {
            $("#ownerTitleEmpty").text("Please choose a valid owner title");
            ownerTitleSelect.addClass('border-danger').removeClass('border-success');
        } else {
            $("#ownerTitleEmpty").text("");
            ownerTitleSelect.removeClass('border-danger').addClass('border-success');
        }
    });

    $('#countryId').on('change', function () {
        var countryIdSelect = $(this); // Reference the select element
        var selectedValue = countryIdSelect.val(); // Get the selected value
    
        if (selectedValue === "") {
            $("#countryIdEmpty").text("Please choose a valid country");
            countryIdSelect.addClass('border-danger').removeClass('border-success');
        } else {
            $("#countryIdEmpty").text("");
            countryIdSelect.removeClass('border-danger').addClass('border-success');
        }
    });
    
    $('#cityId').on('change', function () {
        var cityIdSelect = $(this); // Reference the select element
        var selectedValue = cityIdSelect.val(); // Get the selected value
    
        if (selectedValue === "") {
            $("#cityEmpty").text("Please choose a valid city");
            cityIdSelect.addClass('border-danger').removeClass('border-success');
        } else {
            $("#cityEmpty").text("");
            cityIdSelect.removeClass('border-danger').addClass('border-success');
        }
    });
    $('#companyForm').submit(function(event) {
        
        // Prevent form submission for validation
        event.preventDefault();

        // Get values from the form fields
        var companyType = $('#companyTypeId').val();
        var companyName = $('#companyName').val().trim();
        var registrationNumber = $('#registrationNumber').val().trim();
        var ownerTitle = $('#ownerTitle').val();
        var taxNumber = $('#taxNumber').val();
        var phoneNumber = $('#phoneNumber').val();
        var email = $('#email').val();
        var address = $('#address').val();
        var country = $('#countryId').val();
        var city = $('#cityId').val();
        var category = $('#categoryId').val();
        var subCategory = $('#subCategoryId').val();
        // var numberofEmployees = $('#numberofEmployees').val();
        // Clear previous error messages
        $('.invalid-feedback').hide();
        $('.form-control').removeClass('border-danger');

        // Validate fields
        var isValid = true;

        if (companyType === '') 
        {
            $('#companyTypeId').addClass('border-danger').removeClass('border-success');
            $('#companyTypeId').next('.invalid-feedback').show(); // Show the feedback
            isValid = false;
        }
        if (companyName === '') 
        {
            $('#companyName').addClass('border-danger');
            $('#companyName').next('.invalid-feedback').show();
            isValid = false;
        }

        if (registrationNumber === '') 
        {
            $('#registrationNumber').addClass('border-danger');
            $('#registrationNumber').next('.invalid-feedback').show();
            isValid = false;
        }

        if (ownerTitle === '')
        {
            $('#ownerTitle').addClass('border-danger');
            $('#ownerTitle').next('.invalid-feedback').show();
            isValid = false;
        }

        if (taxNumber === '') 
        {
            $('#taxNumber').addClass('border-danger');
            $('#taxNumber').next('.invalid-feedback').show();
            isValid = false;
        }

        var filter = /^\+?[0-9]{1,4}?[-.\s]?[(]?[0-9]{1,5}[)]?[-.\s]?[0-9]+([-.\s]?[0-9]+)*$/;

        if (phoneNumber === '') {
            $('#phoneNumber').addClass('border-danger');
            isValid = false;
        } else if (!filter.test(phoneNumber)) {
            $('#phoneNumber').addClass('border-danger');
            $('#phoneempty').text('Phone number must start with +31 and contain at least 9 digits.').show();
            isValid = false;
        } else {
            $('#phoneNumber').addClass('border-success').removeClass('border-danger');
        }
        
         // Category
        if (category === '') {
            $('#categoryId').addClass('border-danger');
            $('#categoryId').next('.invalid-feedback').text("Please choose a valid category").show();
            isValid = false;
        }

        // Sub-Category
        if (subCategory === '') {
            $('#subCategoryId').addClass('border-danger');
            $('#subCategoryId').next('.invalid-feedback').text("Please choose a valid sub-category").show();
            isValid = false;
        }
           
        if (email === '')
        {
            $('#email').addClass('border-danger');
            $('#email').next('.invalid-feedback').show();
            isValid = false;
        }

        if (address === '') 
        {
            $('#address').addClass('border-danger');
            $('#address').next('.invalid-feedback').show();
            isValid = false;
        }
        if (country === '') 
        {
            $('#countryId').addClass('border-danger');
            $('#countryId').next('.invalid-feedback').show();
            isValid = false;
        }
        if(city === '')
        {
            $('#cityId').addClass('border-danger');
            $('#cityId').next('.invalid-feedback').show();
            isValid = false;
        }

        // if(numberofEmployees == "")
        // {
            
        //     $('#numberofEmployees').addClass('border-danger');
        //     $('#numberofEmployees').next('.invalid-feedback').show();
        //     isValid = false;
        // }

        // If validation passes, submit the form
        if (isValid) {
            // Show the values captured for debugging or processing (optional)
            console.log('Company Name: ' + companyName);
            console.log('Registration Number: ' + registrationNumber);
            console.log('Owner Title: ' + ownerTitle);

            // You can now submit the form or make an Ajax call here
            this.submit();  // Submit the form normally
        }
    });
  