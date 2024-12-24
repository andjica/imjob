    // Email Update Form Keyup Validation
    $('input[name="email"]').keyup(function () {
        var email = $(this).val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
        if (email === '') {
            $('#emailEmpty').text("Email address is required").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else if (!emailRegex.test(email)) {
            $('#emailEmpty').text("Please enter a valid email address").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else {
            $('#emailEmpty').text('').hide();
            $(this).addClass('border-success').removeClass('border-danger');
        }
    });
    
    // Password Change Form Keyup Validation
    $('input[name="current_password"]').keyup(function () {
        var currentPassword = $(this).val().trim();
    
        if (currentPassword === '') {
            $('#currentPasswordEmpty').text("Current password is required").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else {
            $('#currentPasswordEmpty').text('').hide();
            $(this).addClass('border-success').removeClass('border-danger');
        }
    });
    
    $('input[name="password"]').keyup(function () {
        var newPassword = $(this).val().trim();
    
        if (newPassword === '') {
            $('#newPasswordEmpty').text("New password is required").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else if (newPassword.length < 8) {
            $('#newPasswordEmpty').text("Password must be at least 8 characters long").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else {
            $('#newPasswordEmpty').text('').hide();
            $(this).addClass('border-success').removeClass('border-danger');
        }
    });
    
    $('input[name="password_confirmation"]').keyup(function () {
        var confirmPassword = $(this).val().trim();
        var newPassword = $('input[name="password"]').val().trim();
    
        if (confirmPassword === '') {
            $('#confirmPasswordEmpty').text("Please confirm your new password").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else if (confirmPassword !== newPassword) {
            $('#confirmPasswordEmpty').text("Passwords do not match").show();
            $(this).addClass('border-danger').removeClass('border-success');
        } else {
            $('#confirmPasswordEmpty').text('').hide();
            $(this).addClass('border-success').removeClass('border-danger');
        }
    });
    
        $('#emailUpdateForm').submit(function(event) {
        // Prevent form submission for validation
        event.preventDefault();
    
        // Clear previous error messages and styles
        $('.invalid-feedback').hide();
        $('.form-control').removeClass('border-danger').removeClass('border-success');
    
        // Validate fields
        var isValid = true;
    
        // Email Address
        var email = $('input[name="email"]').val().trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            $('#emailEmpty').text("Email address is required").show();
            $('input[name="email"]').addClass('border-danger');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            $('#emailEmpty').text("Please enter a valid email address").show();
            $('input[name="email"]').addClass('border-danger');
            isValid = false;
        }
        if (isValid) {
            this.submit();
        }
        });
        $('#passwordChangeForm').submit(function(event) {
        // Prevent form submission for validation
        event.preventDefault();
    
        // Clear previous error messages and styles
        $('#currentPasswordEmpty, #newPasswordEmpty, #confirmPasswordEmpty').text('');
        $('input[name="current_password"], input[name="password"], input[name="password_confirmation"]').removeClass('border-danger');
    
        // Validate fields
        var isValid = true;
    
        // Current Password
        var currentPassword = $('input[name="current_password"]').val().trim();
        if (currentPassword === '') {
            $('#currentPasswordEmpty').text("Current password is required").show();
            $('input[name="current_password"]').addClass('border-danger');
            isValid = false;
        }
    
        // New Password
        var newPassword = $('input[name="password"]').val().trim();
        if (newPassword === '') {
            $('#newPasswordEmpty').text("New password is required").show();
            $('input[name="password"]').addClass('border-danger');
            isValid = false;
        } else if (newPassword.length < 8) {
            $('#newPasswordEmpty').text("Password must be at least 8 characters long").show();
            $('input[name="password"]').addClass('border-danger');
            isValid = false;
        }
    
        // Confirm New Password
        var confirmPassword = $('input[name="password_confirmation"]').val().trim();
        if (confirmPassword === '') {
            $('#confirmPasswordEmpty').text("Please confirm your new password").show();
            $('input[name="password_confirmation"]').addClass('border-danger');
            isValid = false;
        } else if (newPassword !== confirmPassword) {
            $('#confirmPasswordEmpty').text("Passwords do not match").show();
            $('input[name="password_confirmation"]').addClass('border-danger');
            isValid = false;
        }
    
        // If validation passes, submit the form
        if (isValid) {
            this.submit();
        }
    });