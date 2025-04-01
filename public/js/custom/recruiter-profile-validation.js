// Real-time validation for Profile Image
$("#profile_image").change(function () {
    var profileImage = $(this).val();
    if (profileImage && !/\.(jpe?g|png)$/i.test(profileImage)) {
        $("#profile_imageEmpty")
            .text("Allowed file types are png, jpg, jpeg")
            .show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#profile_imageEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// Real-time validation for First Name
$('input[name="first_name"]').keyup(function () {
    var firstName = $(this).val();
    if (typeof firstName !== "string") {
        firstName = ""; // Default to an empty string
    } else {
        firstName = firstName.trim();
    }
    if (firstName === "") {
        $("#firstNameEmpty").text("First name is required").show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#firstNameEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// Real-time validation for Last Name
$('input[name="last_name"]').keyup(function () {
    var lastName = $(this).val().trim();
    if (lastName === "") {
        $("#lastNameEmpty").text("Last name is required").show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#lastNameEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// Real-time validation for Birthday
$('input[name="birthday"]').change(function () {
    var birthday = $(this).val();
    if (birthday === "") {
        $("#birthdayEmpty").text("Birthday is required").show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#birthdayEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// Real-time validation for Title Function
$('input[name="title_function"]').keyup(function () {
    var titleFunction = $(this).val().trim();
    if (titleFunction === "") {
        $("#titleFunctionEmpty").text("Title function is required").show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#titleFunctionEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// Real-time validation for Experience Level
$("#experience_level").change(function () {
    var experienceLevel = $(this).val();
    if (experienceLevel === "") {
        $("#experienceLevelEmpty").text("Experience level is required").show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#experienceLevelEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// Real-time validation for Availability
$("#availability").change(function () {
    var availability = $(this).val();
    if (availability === "") {
        $("#availabilityEmpty").text("Availability is required").show();
        $(this).addClass("border-danger").removeClass("border-success");
    } else {
        $("#availabilityEmpty").text("").hide();
        $(this).addClass("border-success").removeClass("border-danger");
    }
});

// $('input[name="phone_number"]').on("keypress", function (e) {
//     if (e.which < 48 || e.which > 57) {
//         e.preventDefault(); // Stops letters and special characters from appearing
//     }
// });

// Real-time validation for Phone Number
// $('input[name="phone_number"]').keyup(function () {
//     this.value = this.value.replace(/[^0-9]/g, "");

//     let phone = this.value;

//     if(phone.length === "") {
//         $("#phoneNumberEmpty").text("Phone number is required");
//         $("#phoneNumber")
//             .addClass("border-danger")
//             .removeClass("border-success");
//     }

//     if (phone.length < 4) {
//         $("#phoneNumberEmpty").text("Enter at least 4 numbers");
//         $("#phoneNumber")
//             .addClass("border-danger")
//             .removeClass("border-success");
//     } else if (phone.length > 10) {
//         $("#phoneNumberEmpty")
//             .text("Phone number can have max 10 characters")
//             .show();
//         $("#phoneNumber")
//             .addClass("border-danger")
//             .removeClass("border-success");
//     } else {
//         $("#phoneNumberEmpty").text("").hide();
//         $("#phoneNumber")
//             .removeClass("border-danger")
//             .addClass("border-success");
//     }
// });

$("#freelancerForm").submit(function (event) {
    // Prevent form submission for validation
    event.preventDefault();

    // Clear previous error messages and styles
    $(".invalid-feedback").hide();
    $(".form-control")
        .removeClass("border-danger")
        .removeClass("border-success");

    // Validate fields
    var isValid = true;

    // Profile Image Validation (optional)
    var profileImage = $('input[name="profile_image"]').val();
    if (profileImage && !/\.(jpe?g|png)$/i.test(profileImage)) {
        $("#profileImageEmpty")
            .text("Allowed file types are png, jpg, jpeg")
            .show();
        isValid = false;
    }

    // First Name
    var firstName = $('input[name="first_name"]').val().trim();
    if (firstName === "") {
        $("#firstNameEmpty").text("First name is required").show();
        $('input[name="first_name"]').addClass("border-danger");
        isValid = false;
    }

    // Last Name
    var lastName = $('input[name="last_name"]').val().trim();
    if (lastName === "") {
        $("#lastNameEmpty").text("Last name is required").show();
        $('input[name="last_name"]').addClass("border-danger");
        isValid = false;
    }

    // Birthday
    var birthday = $('input[name="birthday"]').val();
    if (birthday === "") {
        $("#birthdayEmpty").text("Birthday is required").show();
        $('input[name="birthday"]').addClass("border-danger");
        isValid = false;
    }

    // Title Function
    var titleFunction = $('input[name="title_function"]').val().trim();
    if (titleFunction === "") {
        $("#titleFunctionEmpty").text("Title function is required").show();
        $('input[name="title_function"]').addClass("border-danger");
        isValid = false;
    }

    // Experience Level
    var experienceLevel = $("#experience_level").val();
    if (experienceLevel === "") {
        $("#experienceLevelEmpty").text("Experience level is required").show();
        $("#experience_level").addClass("border-danger");
        isValid = false;
    }

    // Availability
    var availability = $("#availability").val();
    if (availability === "") {
        $("#availabilityEmpty").text("Availability is required").show();
        $("#availability").addClass("border-danger");
        isValid = false;
    }

    // Phone Number
    // var phoneNumber = $('input[name="phone_number"]').val().trim();
    // var phoneRegex =
    //     /^\+?[0-9]{1,4}?[-.\s]?[(]?[0-9]{1,5}[)]?[-.\s]?[0-9]+([-.\s]?[0-9]+)*$/;
    // if (phoneNumber === "") {
    //     $("#phoneNumberEmpty").text("Phone number is required").show();
    //     $('input[name="phone_number"]').addClass("border-danger");
    //     isValid = false;
    // } else if (!phoneRegex.test(phoneNumber)) {
    //     $("#phoneNumberEmpty").text("Phone number must be valid").show();
    //     $('input[name="phone_number"]').addClass("border-danger");
    //     isValid = false;
    // }

    // If validation passes, submit the form
    if (isValid) {
        this.submit();
    }
});
