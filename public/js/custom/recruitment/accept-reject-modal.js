document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function (event) {
        const button = event.target.closest(".accept-btn, .reject-btn, .modal-close");

        if (button) {
            // Handle opening the modal
            if (button.classList.contains("accept-btn") || button.classList.contains("reject-btn")) {
                const candidateId = button.getAttribute("data-candidate-id"); // Get Candidate ID
                const modalId = button.getAttribute("data-bs-target").replace("#", ""); // Get Modal ID
                const modal = document.getElementById(modalId); // Find modal element

                if (modal) {
                    const modalInstance = new bootstrap.Modal(modal);
                    modalInstance.show();
                } else {
                    console.error("Modal not found for Candidate ID:", candidateId);
                }
            }

            // Handle closing the modal (Close Button or Cancel Button)
            if (button.classList.contains("modal-close")) {
                const modalId = button.getAttribute("data-modal-id");
                const modal = document.getElementById(modalId); // Get the specific modal

                if (modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                    modalInstance.hide();

                    // Ensure modal backdrop is removed after hiding
                    setTimeout(() => {
                        document.querySelectorAll(".modal-backdrop").forEach(backdrop => backdrop.remove());
                        document.body.classList.remove("modal-open"); // Prevents scrolling lock
                    }, 300); // Allow fade-out animation
                }
            }
        }
    });
});
