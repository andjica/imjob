$(document).ready(function () {
    let descriptionTouched = false;
    let imageTouched = false;

    function validateDescription() {
        let description = $("#description").val().trim();
        let errorMessage = "";

        if (!descriptionTouched) return; // Don't show error initially

        if (description == "") {

            errorMessage = "Description is required filed";
            $("#description").addClass("border-danger").removeClass("border-success");

        } else if (!/^.{4,}$/.test(description)) {

            errorMessage = "Must be at least 4 characters";
            $("#description").addClass("border-danger") .removeClass("border-success");

        } else {
            $("#description").removeClass("border-danger").addClass("border-success");
            $("#description-error").hide(); // Hide error if valid
            return;
        }

        $("#description-error")
            .text(errorMessage)
            .addClass("text-danger");
    }

    function validateImage() {
        let fileInput = $("#image")[0].files[0];
        let errorMessage = "";
        let allowedImageTypes = [
            "image/jpeg",
            "image/jpg",
            "image/png",
            "image/webp",
        ];
        let maxSize = 4 * 1024 * 1024; // 4MB

        if (!imageTouched) return;

        if (fileInput) {
            if (!allowedImageTypes.includes(fileInput.type)) {
                errorMessage =
                    "Only JPG, JPEG, PNG, and WEBP formats are allowed";
            } else if (fileInput.size > maxSize) {
                errorMessage = "Image size must not exceed 4MB";
            }
        }

        if (errorMessage) {
            $("#image-error")
                .text(errorMessage)
                .addClass("text-danger");
        } else {
            $("#image-error").hide();
        }
    }

    // Mark as touched when user interacts
    $("#description").on("input", function () {
        descriptionTouched = true;
        validateDescription();
    });

    $("#image").on("change", function () {
        imageTouched = true;
        validateImage();
    });

    // Validate on form submit
    $("form").submit(function (event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        descriptionTouched = true;
        imageTouched = true;
        validateDescription();
        validateImage();

        // Check if there are any validation errors
        if (
            $("#description").hasClass("border-danger") ||
            $("#image-error").is(":visible")
        ) {
            return; // Stop submission if errors exist
        }

        // Get form data
        let formData = new FormData(this);

        // Log submitted data to the console
        console.log("Submitted Data:");
        console.log("Description:", formData.get("description"));

        let file = formData.get("image");
        if (file) {
            console.log(
                "Image:",
                file.name,
                `(${file.size} bytes, ${file.type})`
            );
        } else {
            console.log("No image selected.");
        }
        // Clear textarea and image before submiting
        //$("#description").val("");
        //$("#image").val("");

        // Submit the form after previewing data
        this.submit();
    });
});