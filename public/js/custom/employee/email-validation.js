$(document).ready(function() {
     
    let isValid = true;

    // Email validation
    function showError(inputId, errorId, message) {
        $(inputId).removeClass("border-success").addClass("border-danger");
        $(errorId).text(message).addClass("text-danger");
    }

    function showSuccess(inputId, errorId) {
        $(inputId).removeClass("border-danger").addClass("border-success");
        $(errorId).text("");
    }

    function validateEmail() {
        let email = $("#email").val().trim();
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            showError("#email", "#emailEmpty", "Email is required.");
            isValid = false;
        } else if (!email.match(emailPattern)) {
            showError("#email", "#emailEmpty", "Enter a valid email address.");
            isValid = false;
        } else {
            
            showSuccess("#email", "#emailEmpty");
            isValid = true;
            return true;
        }
    }

    // Validate email on input change
    $("#email").on("input", function() {
        validateEmail();
    });

    // Validate on form submit
    $("#emailForm").submit(function(e) {
        if (!validateEmail()) {
            e.preventDefault(); // Prevent form submission if invalid
        }
    
    });
});