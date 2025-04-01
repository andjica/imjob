// $("#categoryId").on("change", function () {
//     var categoryId = $(this).val();
//     var subCategoryRow = $("#subCategoryRow");
    
//     // Reset subCategory dropdown
//     $("#subCategoryId").html('<option value="">Select a subCategory</option>');
//     subCategoryRow.addClass("d-none");
    
//     if (categoryId) {
//         // Show the subCategory row
//         subCategoryRow.removeClass("d-none");
       
//         // Make AJAX call to fetch subcategories
//         $.ajax({
//             url: '/subcategories/' + categoryId, 
//             method: 'GET',
//             success: function (response) {
//                 console.log(response);
//                 if (response.subcategories && response.subcategories.length > 0) {
//                     response.subcategories.forEach(function (subCategory) {
//                         $("#subCategoryId").append(
//                             '<option value="' + subCategory.id + '">' + subCategory.name + '</option>'
//                         );
//                     });
//                 } else {
//                     $("#subCategoryId").append('<option value="">No subcategories found</option>');
//                 }
//             },
//             error: function () {
//                 alert("Failed to fetch subcategories. Please try again.");
//             },
//         });
//     } else {
//         // Hide the subCategory row if no category is selected
//         subCategoryRow.addClass("d-none");
//     }
// });
// Form submission and validation for Recruiter Information
$('#recruiterForm').submit(function (event) {
// Prevent form submission for validation
event.preventDefault();

// Get values from the form fields
var recruiterInfo = $('#recruiterInformation').val().trim();
var birthday = $('#birthday').val();
var titleFunction = $('#titleFunction').val();
//var category = $('#categoryId').val();
//var subCategory = $('#subCategoryId').val();
var profileImage = $('#profileImage').val(); // Assuming this is a file input

// Clear previous error messages
$('.invalid-feedback').hide();
$('.form-control').removeClass('border-danger');

// Validate fields
var isValid = true;

// Recruiter Information
if (recruiterInfo === '') {
    $('#recruiterInformation').addClass('border-danger');
    $('#recruiterInformation').next('.invalid-feedback').text("Recruiter information is required").show();
    isValid = false;
}

// Birthday (must be a valid date)
if (birthday === '') {
    $('#birthday').addClass('border-danger');
    $('#birthday').next('.invalid-feedback').text("Please enter a valid birthday").show();
    isValid = false;
} else {
    var dateRegex = /^\d{4}-\d{2}-\d{2}$/; // YYYY-MM-DD format
    if (!dateRegex.test(birthday)) {
        $('#birthday').addClass('border-danger');
        $('#birthday').next('.invalid-feedback').text("Birthday must be in YYYY-MM-DD format").show();
        isValid = false;
    }
}

// Title Function
// if (titleFunction === '') {
//     $('#titleFunction').addClass('border-danger');
//     $('#titleFunction').next('.invalid-feedback').text("Please select a title function").show();
//     isValid = false;
// }

// Category
// if (category === '') {
//     $('#categoryId').addClass('border-danger');
//     $('#categoryId').next('.invalid-feedback').text("Please choose a valid category").show();
//     isValid = false;
// }

// // Sub-Category
// if (subCategory === '') {
//     $('#subCategoryId').addClass('border-danger');
//     $('#subCategoryId').next('.invalid-feedback').text("Please choose a valid sub-category").show();
//     isValid = false;
// }


// Additional ideas for fields:
// 1. Experience Level
var experienceLevel = $('#experienceLevel').val();
if (experienceLevel === '') {
    $('#experienceLevel').addClass('border-danger');
    $('#experienceLevel').next('.invalid-feedback').text("Please select an experience level").show();
    isValid = false;
}

// 2. Availability
var availability = $('#availability').val();
if (availability === '') {
    $('#availability').addClass('border-danger');
    $('#availability').next('.invalid-feedback').text("Please specify availability").show();
    isValid = false;
}

// If all validations pass, submit the form
if (isValid) {
    this.submit(); // Allows submission if all fields are valid
}
});

$("#profileImage").on("change", function () {
    var fileInput = $(this)[0];
    var filePath = fileInput.value;
    var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.svg|\.webp)$/i;

    if (!allowedExtensions.exec(filePath)) {
        $("#profileImageEmpty").text("Invalid file type. Allowed types: PNG, JPG, JPEG, SVG, WEBP.");
        $(this).val(''); // Clear the input value
    } else {
        $("#profileImageEmpty").text("");
    }
});

$("#recruiterInformation").on('keyup',function(){

var recruiterInformation = $("#recruiterInformation").val();


if(recruiterInformation == "")
{
    $("#recruiterInformationEmpty").text("Recruiter Information is required field");
    $('#recruiterInformation').addClass('border-danger').removeClass('border-success');
    $('#recruiterInformation').next('.invalid-feedback').show();
}

else {
    $("#recruiterInformationEmpty").text("");
    $('#recruiterInformation').removeClass('border-danger').addClass('border-success');
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

// $('#titleFunction').on('change', function () {
//     var titleFunctionSelect = $(this); // Reference the select element
//     var selectedValue = titleFunctionSelect.val(); // Get the selected value

//     if (selectedValue === "") {
//         $("#titleFunctionEmpty").text("Please choose a valid title function");
//         titleFunctionSelect.addClass('border-danger').removeClass('border-success');
//     } else {
//         $("#titleFunctionEmpty").text("");
//         titleFunctionSelect.removeClass('border-danger').addClass('border-success');
//     }
// });

$("#birthday").on("keyup change", function () {
var birthday = $(this).val().trim();
var dateRegex = /^\d{4}-\d{2}-\d{2}$/; // YYYY-MM-DD format

if (birthday === "") {
    $(this).addClass("border-danger").removeClass("border-success");
    $('#birthdayEmpty').text("Please enter a valid birthday").show();
} else if (!dateRegex.test(birthday)) {
    $(this).addClass("border-danger").removeClass("border-success");
    $('#birthdayEmpty').text("Birthday must be in YYYY-MM-DD format").show();
} else {
    $(this).removeClass("border-danger").addClass("border-success");
    $('#birthdayEmpty').text("");
}
});

$('#experienceLevel').on('change', function () {
    var experienceLevelSelect = $(this); // Reference the select element
    var selectedValue = experienceLevelSelect.val(); // Get the selected value

    if (selectedValue === "") {
        $("#experienceLevelEmpty").text("Experience is required field");
        experienceLevelSelect.addClass('border-danger').removeClass('border-success');
    } else {
        $("#experienceLevelEmpty").text("");
        experienceLevelSelect.removeClass('border-danger').addClass('border-success');
    }
});


$('#availability').on('change', function () {
    var availabilitySelect = $(this); // Reference the select element
    var selectedValue = availabilitySelect.val(); // Get the selected value

    if (selectedValue === "") {
        $("#availabilityEmpty").text("Please choose availability");
        availabilitySelect.addClass('border-danger').removeClass('border-success');
    } else {
        $("#availabilityEmpty").text("");
        availabilitySelect.removeClass('border-danger').addClass('border-success');
    }
});

// $("#phoneNumber").on("keypress", function (e) {
//     if (e.which < 48 || e.which > 57) {
//         e.preventDefault(); // Stops letters and special characters from appearing
//     }
// });

// $("#phoneNumber").keyup(function () {
//     this.value = this.value.replace(/[^0-9]/g, "");

//     let phone = this.value;

//     if (phone.length < 4) {
//         $("#phoneEmpty").text("Enter at least 4 numbers");
//         $("#phoneNumber")
//             .addClass("border-danger")
//             .removeClass("border-success");
//     } else if (phone.length > 10) {
//         $("#phoneEmpty").text("Phone number can have max 10 characters").show();
//         $("#phoneNumber")
//             .addClass("border-danger")
//             .removeClass("border-success");
//     } else {
//         $("#phoneEmpty").text("").hide();
//         $("#phoneNumber")
//             .removeClass("border-danger")
//             .addClass("border-success");
//     }
// });