$(document).ready(function() {
    // Function to add a new skill input group
    function addSkillInput() {
        // Create the new input group
        var newInputGroup = `
            <div class="input-group mb-2 skill-input-group">
                <input type="text" class="form-control form-control-solid" name="required_skills[]" placeholder="Enter a skill" />
                <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
                    <i class="fa fa-plus"></i>
                </button>
                <button class="btn btn-danger remove-skill-btn" type="button" title="Remove Skill">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        `;
        // Append the new input group to the container
        $('#skillsContainer').append(newInputGroup);
        // Toggle remove buttons visibility
        toggleRemoveButtons();
    }

    // Function to toggle the visibility of remove buttons
    function toggleRemoveButtons() {
        var totalSkillInputs = $('.skill-input-group').length;
        if (totalSkillInputs > 1) {
            $('.remove-skill-btn').show();
        } else {
            $('.remove-skill-btn').hide();
        }
    }

    // Event listener for adding a new skill input
    $('#skillsContainer').on('click', '.add-skill-btn', function() {
        addSkillInput();
    });

    // Event listener for removing a skill input
    $('#skillsContainer').on('click', '.remove-skill-btn', function() {
        $(this).closest('.skill-input-group').remove();
        toggleRemoveButtons();
    });

    // Initial toggle to set the correct visibility of remove buttons
    toggleRemoveButtons();
});