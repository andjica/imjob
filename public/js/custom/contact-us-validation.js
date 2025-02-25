$(document).ready(function () {
    $("#submit_button").click(function (e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;

        // Name validation
        let name = $("#name").val().trim();
        if (name === "") {
            showError("#name", "#name-error", "It is required");
            isValid = false;
        } else if (name.length < 3) {
            showError("#name", "#name-error", "Name must be at least 3 characters.");
            isValid = false;
        } else {
            showSuccess("#name", "#name-error");
        }

        // Email validation
        let email = $("#email").val().trim();
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            showError("#email", "#email-error", "It is required");
            isValid = false;
        } else if (!email.match(emailPattern)) {
            showError("#email", "#email-error", "Enter a valid email address.");
            isValid = false;
        } else {
            showSuccess("#email", "#email-error");
        }

        // Subject validation
        let subject = $("#subject").val().trim();
        if (subject === "") {
            showError("#subject", "#subject-error", "It is required");
            isValid = false;
        } else if (subject.length < 5) {
            showError("#subject", "#subject-error", "Subject must be at least 5 characters.");
            isValid = false;
        } else {
            showSuccess("#subject", "#subject-error");
        }

        // Message validation
        let message = $("#message").val().trim();
        if (message === "") {
            showError("#message", "#message-error", "It is required");
            isValid = false;
        } else if (message.length < 10) {
            showError("#message", "#message-error", "Message must be at least 10 characters.");
            isValid = false;
        } else {
            showSuccess("#message", "#message-error");
        }

        // If all validations pass, submit the form
        if (isValid) {
            $("form").submit();
        }
    });

    // Real-time validation: Show message when empty, update message on input
    $("input, textarea").on("input", function () {
        let field = $(this);
        let fieldId = field.attr("id");
        let errorSpan = $("#" + fieldId + "-error");
        let value = field.val().trim();

        // Determine error message based on field type
        let errorMessage = "";
        if (value === "") {
            errorMessage = "It is required";
        } else if (fieldId === "name" && value.length < 3) {
            errorMessage = "Name must be at least 3 characters.";
        } else if (fieldId === "subject" && value.length < 5) {
            errorMessage = "Subject must be at least 5 characters.";
        } else if (fieldId === "message" && value.length < 10) {
            errorMessage = "Message must be at least 10 characters.";
        } else if (fieldId === "email") {
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!value.match(emailPattern)) {
                errorMessage = "Enter a valid email address.";
            }
        }

        // Apply error or success styling
        if (errorMessage) {
            field.removeClass("border-success").addClass("border-danger");
            errorSpan.text(errorMessage).addClass("text-danger");
        } else {
            field.removeClass("border-danger").addClass("border-success");
            errorSpan.text("");
        }
    });

    // Show error
    function showError(inputId, errorId, message) {
        $(inputId).removeClass("border-success").addClass("border-danger");
        $(errorId).text(message).addClass("text-danger");
    }

    // Show success
    function showSuccess(inputId, errorId) {
        $(inputId).removeClass("border-danger").addClass("border-success");
        $(errorId).text("");
    }
});