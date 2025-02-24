$(document).ready(function () {
    $("#submit_button").click(function (e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;

        // Name validation
        let name = $("#name").val().trim();
        if (name === "") {
            showError("#name", "#name-error", "It is required");
            isValid = false;
        } else if (!/^.{4,}$/.test(name)) {
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
        } else if (!/^.{5,}$/.test(subject)) {
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
        } else if (!/^.{5,}$/.test(message)) {
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

    // Remove error message & add green border on input
    $("input, textarea").on("input", function () {
        let field = $(this);
        let errorSpan = $("#" + field.attr("id") + "-error");
        field.removeClass("border-danger").addClass("border-success");
        errorSpan.text("");
    });

    // Function to show error
    function showError(inputId, errorId, message) {
        $(inputId).removeClass("border-success").addClass("border-danger");
        $(errorId).text(message).addClass("text-danger");
    }

    // Function to show success
    function showSuccess(inputId, errorId) {
        $(inputId).removeClass("border-danger").addClass("border-success");
        $(errorId).text("");
    }
});
