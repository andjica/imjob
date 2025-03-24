$(document).ready(function () {
    let descriptionTouched = false;
    let imageTouched = false;

    let editableElement; // Declare the editableElement variable globally

    // Initialize CKEditor 5 on the #description textarea
    ClassicEditor.create(document.querySelector('#description'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ]
        }
    })
    .then(editor => {
        window.jobDescriptionEditor = editor;

        // Store editableElement globally
        editableElement = editor.ui.view.editable.element;

        // Add keyup event listener on the editable element
        $(editableElement).on('keyup', function () {
            descriptionTouched = true; // Mark as touched
            validateDescription();
        });
    })
    .catch(error => {
        console.error('Error initializing CKEditor:', error);
    });

    function validateDescription() {
        let description = window.jobDescriptionEditor.getData().trim(); // Get CKEditor content
        let errorMessage = "";

        if (!descriptionTouched) return; // Don't show error initially

        if (description === "") {
            errorMessage = "Description is a required field";
            $(editableElement).addClass("border-danger").removeClass("border-success");
            $("#descriptionEmpty").text(errorMessage).addClass("text-danger").show();
        } else if (!/^.{4,}$/.test(description)) {
            errorMessage = "Must be at least 4 characters";
            $(editableElement).addClass("border-danger").removeClass("border-success");
            $("#descriptionEmpty").text(errorMessage).addClass("text-danger").show();
        } else {
            $(editableElement).removeClass("border-danger").addClass("border-success");
            $("#descriptionEmpty").text("").hide(); // Hide error when valid
        }
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
                .addClass('text-danger');
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
            $(editableElement).hasClass("border-danger") ||
            $("#image-error").is(":visible")
        ) {
            console.log("Validation errors present. Form not submitted.");
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

        // Submit the form after previewing data
        console.log("Form submitted successfully.");
        this.submit(); // Only submit if no validation errors
    });
});
