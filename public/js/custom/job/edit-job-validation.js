$(document).ready(function () {
    const jobWorldType = document.getElementById('jobWorldType').value;
  
  // Function to update selection
  function setJobType(type) {
      // Update the hidden input value
      document.getElementById('jobWorldType').value = type;

      // Remove active class from both buttons
      document.getElementById('jobWorldTypeNational').classList.remove('active', 'btn-primary');
      document.getElementById('jobWorldTypeInternational').classList.remove('active', 'btn-primary');

      // Add active class to selected button
      if (type === 'national') {
          document.getElementById('jobWorldTypeNational').classList.add('active', 'btn-primary');
      } else {
          document.getElementById('jobWorldTypeInternational').classList.add('active', 'btn-primary');
      }
  }

  // Initialize with the old or saved value
  if (jobWorldType === 'national') {
      setJobType('national');
  } else if (jobWorldType === 'international') {
      setJobType('international');
  }
  
  // Make function globally accessible
  window.setJobType = setJobType;
  // AutoNumeric Configuration
  const autoNumericOptions = {
      decimalCharacter: ',',
      digitGroupSeparator: '.',
      decimalPlaces: 2,
      unformatOnSubmit: true,
  };

  // Initialize AutoNumeric for salary fields
  const anSalaryMin = new AutoNumeric('#salaryMin', autoNumericOptions);
  const anSalaryMax = new AutoNumeric('#salaryMax', autoNumericOptions);

  // Attach event listener for salary validation
  $('#salaryMin, #salaryMax').on('input change', validateSalaries);

 // Show/Hide Special Requirements Fields on Toggle
 $('#has_special_requirements').on('change', function () {
      if ($(this).is(':checked')) {
          $('#specialRequirementsFields').removeClass('d-none');
      } else {
          $('#specialRequirementsFields').addClass('d-none');
          $('#special_requirements').val(''); // Clear value when unchecked
      }
  }).trigger('change');

  // Initialize CKEditor
  if (document.querySelector('#description')) {
      ClassicEditor.create(document.querySelector('#description'))
          .then(editor => {
              console.log("✅ CKEditor is initialized!");
              window.jobDescriptionEditor = editor;
          })
          .catch(error => {
              console.error("❌ CKEditor failed to initialize:", error);
          });
  }

  // Form Validation on Submit
  $('#jobForm').submit(function (event) {
      event.preventDefault();
      console.log("🚀 Syncing CKEditor before validation...");
      
      if (window.jobDescriptionEditor) {
          const editorContent = window.jobDescriptionEditor.getData().trim();
          $('textarea[name="description"]').val(editorContent);
          console.log(`📝 CKEditor content length: ${editorContent.length} characters`);
      }

      if (validateForm()) {
          console.log("✅ Form is valid. Submitting...");
          this.submit();
      } else {
          console.log("❌ Form validation failed!");
      }
  });

  /*** Skill Management ***/
  function addSkillInput() {
      var newInputGroup = `
          <div class="input-group mb-2 skill-input-group">
              <input type="text" class="form-control form-control-solid" name="moreSkills[]" placeholder="Enter a skill" />
              <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
                  <i class="fa fa-plus"></i>
              </button>
              <button class="btn btn-danger remove-skill-btn" type="button" title="Remove Skill">
                  <i class="fa fa-minus"></i>
              </button>
          </div>
      `;
      $('#skillsContainer').append(newInputGroup);
      toggleRemoveButtons();
  }

  function toggleRemoveButtons() {
      var totalSkillInputs = $('.skill-input-group').length;
      $('.remove-skill-btn').toggle(totalSkillInputs > 1);
  }

  $('#skillsContainer').on('click', '.add-skill-btn', function() {
      addSkillInput();
  });

  $('#skillsContainer').on('click', '.remove-skill-btn', function() {
      $(this).closest('.skill-input-group').remove();
      toggleRemoveButtons();
  });

  toggleRemoveButtons();

  /*** Validation Functions ***/
  function validateForm() {
      let isValid = true;

      const fields = {
          '#title': '#titleEmpty',
          '#description': '#descriptionEmpty',
          '#categoryId': '#categoryIdEmpty',
          '#subCategoryId': '#subCategoryIdEmpty',
          '#countryId': '#countryIdEmpty',
          '#cityId': '#cityIdEmpty',
          '#experienceLevel': '#experienceLevelEmpty',
          '#requiredSkills': '#requiredSkillsEmpty',
          '#validUntil': '#validUntilEmpty',
          '#salaryMin': '#salaryMinEmpty',
          '#salaryMax': '#salaryMaxEmpty',
      };

      console.log("🔍 Checking required fields...");

      for (const [field, errorField] of Object.entries(fields)) {
          const value = $(field).val()?.trim() || '';
          if (value === '') {
              console.warn(`⚠ Validation failed: ${field} is empty`);
              showError(field, errorField, 'This field is required.');
              isValid = false;
          } else {
              hideError(field, errorField);
          }
      }

      if (!validateSalaries()) {
          console.warn("⚠ Salary validation failed!");
          isValid = false;
      }

      if (!validateAges()) {
          console.warn("⚠ Age validation failed!");
          isValid = false;
      }

      const specialDetails = $('#special_requirements').val()?.trim() || '';
      if ($('#has_special_requirements').is(':checked') && specialDetails === '') {
          console.warn("⚠ Special requirements are checked but empty.");
          showError('#special_requirements', '#specialDetailsEmpty', 'Please provide details.');
          isValid = false;
      } else {
          hideError('#special_requirements', '#specialDetailsEmpty');
      }


      console.log(isValid ? "✅ Form is valid!" : "❌ Form validation failed!");
      return isValid;
  }

  function validateSalaries() {
      const minVal = anSalaryMin.getNumber();
      const maxVal = anSalaryMax.getNumber();
      let isValid = true;

      if (!minVal || isNaN(minVal) || minVal < 0) {
          showError('#salaryMin', '#salaryMinEmpty', 'Enter a valid salary minimum.');
          isValid = false;
      } else {
          hideError('#salaryMin', '#salaryMinEmpty');
      }

      if (!maxVal || isNaN(maxVal) || maxVal < 0) {
          showError('#salaryMax', '#salaryMaxEmpty', 'Enter a valid salary maximum.');
          isValid = false;
      } else if (maxVal < minVal) {
          showError('#salaryMax', '#salaryMaxEmpty', 'Max salary must be greater than or equal to min salary.');
          isValid = false;
      } else {
          hideError('#salaryMax', '#salaryMaxEmpty');
      }

      return isValid;
  }

  function validateAges() {
      const minAge = parseInt($('#min_age').val()?.trim() || '0', 10);
      const maxAge = parseInt($('#max_age').val()?.trim() || '0', 10);
      let isValid = true;

      if (isNaN(minAge) || minAge < 18 || minAge > 100) {
          showError('#min_age', '#minAgeEmpty', 'Min age must be between 18 and 100.');
          isValid = false;
      } else {
          hideError('#min_age', '#minAgeEmpty');
      }

      if (isNaN(maxAge) || maxAge < 18 || maxAge > 100) {
          showError('#max_age', '#maxAgeEmpty', 'Max age must be between 18 and 100.');
          isValid = false;
      } else if (maxAge < minAge) {
          showError('#max_age', '#maxAgeEmpty', 'Max age must be greater than min age.');
          isValid = false;
      } else {
          hideError('#max_age', '#maxAgeEmpty');
      }

      return isValid;
  }

  function showError(field, errorField, message) {
      $(field).addClass('border-danger');
      $(errorField).text(message).show();
  }

  function hideError(field, errorField) {
      $(field).removeClass('border-danger');
      $(errorField).text('').hide();
  }
});

