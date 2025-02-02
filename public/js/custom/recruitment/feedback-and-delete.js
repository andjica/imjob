document.addEventListener("DOMContentLoaded", function () {
    // Handle Feedback Form Submission
    document.querySelectorAll(".feedbackForm").forEach((form) => {
        form.addEventListener("submit", function (event) {
            const subphaseId = this.getAttribute("data-subphase-id");
            const commentField = document.getElementById(`feedbackComment-${subphaseId}`);
            const errorField = document.getElementById(`feedbackError-${subphaseId}`);
            const comment = commentField.value.trim();
            const modal = document.getElementById(`feedbackModal-${subphaseId}`);

            if (comment === '') {
                // Show error if feedback is empty
                commentField.classList.add("border-danger");
                errorField.textContent = "Please enter a comment.";
                errorField.style.display = "block";
            } else {
                // Hide error and allow submission
                errorField.style.display = "none";
                commentField.classList.remove("border-danger");

                // Submit the form
                this.submit();

                // Close the modal after submission
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
        });
    });

    // Handle Close Buttons for All Modals (Feedback & Delete)
    document.querySelectorAll(".modal-close").forEach((button) => {
        button.addEventListener("click", function () {
            const modalId = this.getAttribute("data-modal-id");
            const modal = document.getElementById(modalId);

            if (modal) {
                let modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                modalInstance.hide();

                // Ensure modal backdrop is removed after hiding
                setTimeout(() => {
                    document.querySelectorAll(".modal-backdrop").forEach(backdrop => backdrop.remove());
                    document.body.classList.remove("modal-open");
                }, 300);
            }
        });
    });

    // Handle Delete Form Submission
    document.addEventListener("DOMContentLoaded", function () {
        // Handle Close Buttons for Both Feedback and Delete Modals
        document.querySelectorAll(".modal-close").forEach((button) => {
            button.addEventListener("click", function () {
                const modalId = this.getAttribute("data-modal-id");
                const modal = document.getElementById(modalId);
    
                if (modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                    modalInstance.hide();
    
                    // Ensure modal backdrop is removed after hiding
                    setTimeout(() => {
                        document.querySelectorAll(".modal-backdrop").forEach(backdrop => backdrop.remove());
                        document.body.classList.remove("modal-open");
                    }, 300);
                }
            });
        });
    });
    
});
