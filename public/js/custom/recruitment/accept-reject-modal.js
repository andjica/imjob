document.addEventListener("DOMContentLoaded", function () {
    // Open Accept Modal
    document.querySelectorAll(".accept-btn").forEach(button => {
        button.addEventListener("click", function () {
            const candidateName = this.getAttribute("data-candidate-name");
            document.getElementById("acceptCandidateName").innerText = candidateName;
        });
    });

    // Open Reject Modal
    document.querySelectorAll(".reject-btn").forEach(button => {
        button.addEventListener("click", function () {
            const candidateName = this.getAttribute("data-candidate-name");
            document.getElementById("rejectCandidateName").innerText = candidateName;
        });
    });
});