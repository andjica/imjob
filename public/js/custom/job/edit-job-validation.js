// $(document).ready(function () {
//     const jobWorldType = document.getElementById('jobWorldType').value;

//   // Function to update selection
//   function setJobType(type) {
//       // Update the hidden input value
//       document.getElementById('jobWorldType').value = type;

//       // Remove active class from both buttons
//       document.getElementById('jobWorldTypeNational').classList.remove('active', 'btn-primary');
//       document.getElementById('jobWorldTypeInternational').classList.remove('active', 'btn-primary');

//       // Add active class to selected button
//       if (type === 'national') {
//           document.getElementById('jobWorldTypeNational').classList.add('active', 'btn-primary');
//       } else {
//           document.getElementById('jobWorldTypeInternational').classList.add('active', 'btn-primary');
//       }
//   }

//   // Initialize with the old or saved value
//   if (jobWorldType === 'national') {
//       setJobType('national');
//   } else if (jobWorldType === 'international') {
//       setJobType('international');
//   }

//   // Make function globally accessible
//   window.setJobType = setJobType;
//   // AutoNumeric Configuration
//   const autoNumericOptions = {
//       decimalCharacter: ',',
//       digitGroupSeparator: '.',
//       decimalPlaces: 2,
//       unformatOnSubmit: true,
//   };

//   // Initialize AutoNumeric for salary fields
//   const anSalaryMin = new AutoNumeric('#salaryMin', autoNumericOptions);
//   const anSalaryMax = new AutoNumeric('#salaryMax', autoNumericOptions);

//   // Attach event listener for salary validation
//   $('#salaryMin, #salaryMax').on('input change', validateSalaries);

//  // Show/Hide Special Requirements Fields on Toggle
//  $('#has_special_requirements').on('change', function () {
//       if ($(this).is(':checked')) {
//           $('#specialRequirementsFields').removeClass('d-none');
//       } else {
//           $('#specialRequirementsFields').addClass('d-none');
//           $('#special_requirements').val(''); // Clear value when unchecked
//       }
//   }).trigger('change');

//   // Initialize CKEditor
//   if (document.querySelector('#description')) {
//       ClassicEditor.create(document.querySelector('#description'))
//           .then(editor => {
//               console.log("CKEditor is initialized!");
//               window.jobDescriptionEditor = editor;
//           })
//           .catch(error => {
//               console.error("CKEditor failed to initialize:", error);
//           });
//   }

//   // Form Validation on Submit
//   $('#jobForm').submit(function (event) {
//     //ovde nastaviti
//       event.preventDefault();
//       console.log("Syncing CKEditor before validation...");

//       if (window.jobDescriptionEditor) {
//           const editorContent = window.jobDescriptionEditor.getData().trim();
//           $('textarea[name="description"]').val(editorContent);
//           console.log(`📝 CKEditor content length: ${editorContent.length} characters`);
//       }

//       if (validateForm()) {
//           console.log("Form is valid. Submitting...");
//           this.submit();
//       } else {
//           console.log("Form validation failed!");
//       }
//   });

//   /*** Skill Management ***/
//   function addSkillInput() {
//       var newInputGroup = `
//           <div class="input-group mb-2 skill-input-group">
//               <input type="text" class="form-control form-control-solid" name="moreSkills[]" placeholder="Enter a skill" />
//               <button class="btn btn-success add-skill-btn" type="button" title="Add Skill">
//                   <i class="fa fa-plus"></i>
//               </button>
//               <button class="btn btn-danger remove-skill-btn" type="button" title="Remove Skill">
//                   <i class="fa fa-minus"></i>
//               </button>
//           </div>
//       `;
//       $('#skillsContainer').append(newInputGroup);
//       toggleRemoveButtons();
//   }

//   function toggleRemoveButtons() {
//       var totalSkillInputs = $('.skill-input-group').length;
//       $('.remove-skill-btn').toggle(totalSkillInputs > 1);
//   }

//   $('#skillsContainer').on('click', '.add-skill-btn', function() {
//       addSkillInput();
//   });

//   $('#skillsContainer').on('click', '.remove-skill-btn', function() {
//       $(this).closest('.skill-input-group').remove();
//       toggleRemoveButtons();
//   });

//   toggleRemoveButtons();

//   /*** Validation Functions ***/
//   function validateForm() {
//       let isValid = true;

//       const fields = {
//           '#title': '#titleEmpty',
//           '#description': '#descriptionEmpty',
//           '#categoryId': '#categoryIdEmpty',
//           '#subCategoryId': '#subCategoryIdEmpty',
//           '#countryId': '#countryIdEmpty',
//           '#cityId': '#cityIdEmpty',
//           '#experienceLevel': '#experienceLevelEmpty',
//           '#requiredSkills': '#requiredSkillsEmpty',
//           '#validUntil': '#validUntilEmpty',
//           '#salaryMin': '#salaryMinEmpty',
//           '#salaryMax': '#salaryMaxEmpty',
//       };

//       console.log("🔍 Checking required fields...");

//       for (const [field, errorField] of Object.entries(fields)) {
//           const value = $(field).val()?.trim() || '';
//           if (value === '') {
//               console.warn(`⚠ Validation failed: ${field} is empty`);
//               showError(field, errorField, 'This field is required.');
//               isValid = false;
//           } else {
//               hideError(field, errorField);
//           }
//       }

//       if (!validateSalaries()) {
//           console.warn("⚠ Salary validation failed!");
//           isValid = false;
//       }

//       if (!validateAges()) {
//           console.warn("⚠ Age validation failed!");
//           isValid = false;
//       }

//       const specialDetails = $('#special_requirements').val()?.trim() || '';
//       if ($('#has_special_requirements').is(':checked') && specialDetails === '') {
//           console.warn("⚠ Special requirements are checked but empty.");
//           showError('#special_requirements', '#specialDetailsEmpty', 'Please provide details.');
//           isValid = false;
//       } else {
//           hideError('#special_requirements', '#specialDetailsEmpty');
//       }

//       console.log(isValid ? "✅ Form is valid!" : "❌ Form validation failed!");
//       return isValid;
//   }

//   function validateSalaries() {
//       const minVal = anSalaryMin.getNumber();
//       const maxVal = anSalaryMax.getNumber();
//       let isValid = true;

//       if (!minVal || isNaN(minVal) || minVal < 0) {
//           showError('#salaryMin', '#salaryMinEmpty', 'Enter a valid salary minimum.');
//           isValid = false;
//       } else {
//           hideError('#salaryMin', '#salaryMinEmpty');
//       }

//       if (!maxVal || isNaN(maxVal) || maxVal < 0) {
//           showError('#salaryMax', '#salaryMaxEmpty', 'Enter a valid salary maximum.');
//           isValid = false;
//       } else if (maxVal < minVal) {
//           showError('#salaryMax', '#salaryMaxEmpty', 'Max salary must be greater than or equal to min salary.');
//           isValid = false;
//       } else {
//           hideError('#salaryMax', '#salaryMaxEmpty');
//       }

//       return isValid;
//   }

//   function validateAges() {
//       const minAge = parseInt($('#min_age').val()?.trim() || '0', 10);
//       const maxAge = parseInt($('#max_age').val()?.trim() || '0', 10);
//       let isValid = true;

//       if (isNaN(minAge) || minAge < 18 || minAge > 100) {
//           showError('#min_age', '#minAgeEmpty', 'Min age must be between 18 and 100.');
//           isValid = false;
//       } else {
//           hideError('#min_age', '#minAgeEmpty');
//       }

//       if (isNaN(maxAge) || maxAge < 18 || maxAge > 100) {
//           showError('#max_age', '#maxAgeEmpty', 'Max age must be between 18 and 100.');
//           isValid = false;
//       } else if (maxAge < minAge) {
//           showError('#max_age', '#maxAgeEmpty', 'Max age must be greater than min age.');
//           isValid = false;
//       } else {
//           hideError('#max_age', '#maxAgeEmpty');
//       }

//       return isValid;
//   }

//   function showError(field, errorField, message) {
//       $(field).addClass('border-danger');
//       $(errorField).text(message).show();
//   }

//   function hideError(field, errorField) {
//       $(field).removeClass('border-danger');
//       $(errorField).text('').hide();
//   }
// });

$(document).ready(function () {
    const jobWorldType = document.getElementById("jobWorldType").value;

    // Function to update selection
    function setJobType(type) {
        // Update the hidden input value
        document.getElementById("jobWorldType").value = type;

        // Remove active class from both buttons
        document
            .getElementById("jobWorldTypeNational")
            .classList.remove("active", "btn-primary");
        document
            .getElementById("jobWorldTypeInternational")
            .classList.remove("active", "btn-primary");

        // Add active class to selected button
        if (type === "national") {
            document
                .getElementById("jobWorldTypeNational")
                .classList.add("active", "btn-primary");
        } else {
            document
                .getElementById("jobWorldTypeInternational")
                .classList.add("active", "btn-primary");
        }
    }

    // Initialize with the old or saved value
    if (jobWorldType === "national") {
        setJobType("national");
    } else if (jobWorldType === "international") {
        setJobType("international");
    }

    // Make function globally accessible
    window.setJobType = setJobType;
    // AutoNumeric Configuration
    const autoNumericOptions = {
        decimalCharacter: ",",
        digitGroupSeparator: ".",
        decimalPlaces: 2,
        unformatOnSubmit: true,
    };

    // Initialize AutoNumeric for salary fields
    const anSalaryMin = new AutoNumeric("#salaryMin", autoNumericOptions);
    const anSalaryMax = new AutoNumeric("#salaryMax", autoNumericOptions);

    // Attach event listener for salary validation
    $("#salaryMin, #salaryMax").on("input change", validateSalaries);

    // Show/Hide Special Requirements Fields on Toggle
    $("#has_special_requirements")
        .on("change", function () {
            if ($(this).is(":checked")) {
                $("#specialRequirementsFields").removeClass("d-none");
            } else {
                $("#specialRequirementsFields").addClass("d-none");
                $("#special_requirements").val(""); // Clear value when unchecked
            }
        })
        .trigger("change");

    // Initialize CKEditor
    if (document.querySelector("#description")) {
        ClassicEditor.create(document.querySelector("#description"))
            .then((editor) => {
                console.log("✅ CKEditor is initialized!");
                window.jobDescriptionEditor = editor;
            })
            .catch((error) => {
                console.error("❌ CKEditor failed to initialize:", error);
            });
    }

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
        $("#skillsContainer").append(newInputGroup);
        toggleRemoveButtons();
    }

    function toggleRemoveButtons() {
        var totalSkillInputs = $(".skill-input-group").length;
        $(".remove-skill-btn").toggle(totalSkillInputs > 1);
    }

    $("#skillsContainer").on("click", ".add-skill-btn", function () {
        addSkillInput();
    });

    $("#skillsContainer").on("click", ".remove-skill-btn", function () {
        $(this).closest(".skill-input-group").remove();
        toggleRemoveButtons();
    });

    toggleRemoveButtons();

    function validateField(field, errorField) {
        const value = $(field).val().trim();
        if (value === "") {
            showError(field, errorField, "This field is required.");
            $(field).addClass("border-danger").removeClass("border-success");
        } else {
            hideError(field, errorField);
            $(field).addClass("border-success").removeClass("border-danger");
        }
    }

    const fields = {
        "#title": "#titleEmpty",
        "#requiredSkills": "#requiredSkillsEmpty",
        "#salaryMin": "#salaryMinEmpty",
        "#salaryMax": "#salaryMaxEmpty",
        // "otherSub":"#otherCategoryEmpty",
    };

    for (const [field, errorField] of Object.entries(fields)) {
        $(field).on("input", function () {
            validateField(field, errorField);
        });
    }

    // Validate Select2 dropdown separately City
    $("#cityId").on("change", function () {
        validateField("#cityId", "#cityIdEmpty");
    });

    // Validate Select2 dropdown separately for SubCategory
    $("#subCategoryId").on("change", function () {
        validateField("#subCategoryId", "#subCategoryIdEmpty");
    });

    /*** Validation Functions ***/
    function validateForm() {
        let isValid = true;
        console.log("🔍 Checking required fields...");

        for (const [field, errorField] of Object.entries(fields)) {
            const value = $(field).val()?.trim() || "";
            if (value === "") {
                showError(field, errorField, "This field is required.");
                $(field)
                    .addClass("border-danger")
                    .removeClass("border-success");
                isValid = false;
            } else {
                hideError(field, errorField);
                $(field)
                    .addClass("border-success")
                    .removeClass("border-danger");
            }
        }

        // Validate Select2 dropdown
        const cityIdSelect = $("#cityId");
        const selectedCity = cityIdSelect.val();
        const select2Container = cityIdSelect
            .next(".select2-container")
            .find(".select2-selection");

        if (!selectedCity) {
            showError("#cityId", "#cityIdEmpty", "Please choose a valid city");
            cityIdSelect
                .addClass("border-danger")
                .removeClass("border-success");
            select2Container
                .addClass("border-danger")
                .removeClass("border-success");
            isValid = false;
        } else {
            hideError("#cityId", "#cityIdEmpty");
            cityIdSelect
                .addClass("border-success")
                .removeClass("border-danger");
            select2Container
                .addClass("border-success")
                .removeClass("border-danger");
        }

        // Validate Select2 dropdown for SubCategory
        const subCategorySelect = $("#subCategoryId");
        const selectedSubCategory = subCategorySelect.val();
        const subCategorySelect2Container = subCategorySelect
            .next(".select2-container")
            .find(".select2-selection");

        if (!selectedSubCategory) {
            showError(
                "#subCategoryId",
                "#subCategoryIdEmpty",
                "Please choose a valid subcategory"
            );
            subCategorySelect
                .addClass("border-danger")
                .removeClass("border-success");
            subCategorySelect2Container
                .addClass("border-danger")
                .removeClass("border-success");
            isValid = false;
        } else {
            hideError("#subCategoryId", "#subCategoryIdEmpty");
            subCategorySelect
                .addClass("border-success")
                .removeClass("border-danger");
            subCategorySelect2Container
                .addClass("border-success")
                .removeClass("border-danger");
        }

        console.log(
            isValid ? "✅ Form is valid!" : "❌ Form validation failed!"
        );
        return isValid;
    }

    // Event listener for live validation on the description field
    $("#description").on("input", function () {
        const description = $(this).val().trim();

        if (description === "") {
            showError(
                "#description",
                "#descriptionEmpty",
                "This field is required."
            );
            $(this).addClass("border-danger").removeClass("border-success");
        } else {
            hideError("#description", "#descriptionEmpty");
            $(this).removeClass("border-danger").addClass("border-success");
        }
    });

    // Other
    $("#subCategoryId").select2();
    $("#subCategoryId").on("change select2:select", function () {
        let selectedValue = $(this).val();
        let otherSubRow = $("#otherSubRow");
        let otherSubInput = $("#otherSub");

        if (selectedValue === "Other") {
            otherSubRow.removeClass("d-none");
        } else {
            otherSubRow.addClass("d-none");
            otherSubInput.val(""); // Clear input when hidden
        }
    });
    //Add validation for 'Other' input field
    $("#otherSub").on("keyup", function () {
        var other = $("#otherSub").val();

        if (other == "") {
            $("#otherCategoryEmpty").text("Please write your category.");
            $("#otherSub")
                .addClass("border-danger")
                .removeClass("border-success");
            $("#otherSub").next(".invalid-feedback").show();
        } else if (!/^.{4,}$/.test(other)) {
            $("#otherSub").addClass("border-danger");
            $("#otherCategoryEmpty")
                .text("Category must be at least 4 characters long")
                .show();
        } else {
            $("#otherCategoryEmpty").text("");
            $("#otherSub")
                .removeClass("border-danger")
                .addClass("border-success");
        }
    });

    // Min and Max age validation
    $("#min_age").on("keyup", function () {
        var minAge = $("#min_age").val();

        if (minAge == "") {
            $("#minAgeEmpty").text("Min age is a required field");
            $("#min_age")
                .addClass("border-danger")
                .removeClass("border-success");
            $("#min_age").next(".invalid-feedback").show();
        } else if (isNaN(minAge) || minAge < 18 || minAge > 100) {
            $("#minAgeEmpty").text(
                "Please enter a valid age between 18 and 100."
            );
            $("#min_age")
                .addClass("border-danger")
                .removeClass("border-success");
            $("#min_age").next(".invalid-feedback").show();
        } else {
            $("#minAgeEmpty").text("");
            $("#min_age")
                .removeClass("border-danger")
                .addClass("border-success");
            $("#min_age").next(".invalid-feedback").hide();
        }
    });

    $("#max_age").on("keyup", function () {
        var maxAge = $("#max_age").val();

        if (maxAge == "") {
            $("#maxAgeEmpty").text("Max age is a required field");
            $("#max_age")
                .addClass("border-danger")
                .removeClass("border-success");
            $("#max_age").next(".invalid-feedback").show();
        } else if (isNaN(maxAge) || maxAge < 18 || maxAge > 100) {
            $("#maxAgeEmpty").text(
                "Please enter a valid age between 18 and 100."
            );
            $("#max_age")
                .addClass("border-danger")
                .removeClass("border-success");
            $("#max_age").next(".invalid-feedback").show();
        } else {
            $("#maxAgeEmpty").text("");
            $("#max_age")
                .removeClass("border-danger")
                .addClass("border-success");
            $("#max_age").next(".invalid-feedback").hide();
        }

        // Ensure max_age is greater than or equal to min_age
        var minAge = $("#min_age").val();
        if (parseInt(maxAge) < parseInt(minAge)) {
            $("#maxAgeEmpty").text(
                "Max age must be greater than or equal to Min age."
            );
            $("#max_age")
                .addClass("border-danger")
                .removeClass("border-success");
            $("#max_age").next(".invalid-feedback").show();
        }
    });

    function validateSalaries() {
        const minVal = anSalaryMin.getNumber();
        const maxVal = anSalaryMax.getNumber();
        let isValid = true;

        if (!minVal) {
            showError(
                "#salaryMin",
                "#salaryMinEmpty",
                "Min salary is required."
            );
            isValid = false;
        } else {
            hideError("#salaryMin", "#salaryMinEmpty");
        }

        if (!maxVal) {
            showError(
                "#salaryMax",
                "#salaryMaxEmpty",
                "Max salary is required."
            );
            isValid = false;
        } else {
            hideError("#salaryMax", "#salaryMaxEmpty");
        }

        if (minVal && maxVal && minVal > maxVal) {
            showError(
                "#salaryMax",
                "#salaryMaxEmpty",
                "Max salary must be greater than Min salary."
            );
            isValid = false;
        }

        return isValid;
    }

    function validateValidUntil() {
        const validUntil = $("#validUntil").val().trim();
        const selectedDate = new Date(validUntil);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Remove time portion

        const maxDate = new Date("2050-12-31");
        maxDate.setHours(23, 59, 59, 999); // Include the entire day

        // Clear previous error messages and styles
        $("#validUntilEmpty").text("").hide();
        $("#validUntil").removeClass("border-danger border-success");

        let isValid = true;

        if (validUntil === "") {
            $("#validUntil").addClass("border-danger");
            $("#validUntilEmpty").text("Please select a valid date.").show();
            isValid = false;
        } else if (isNaN(selectedDate.getTime())) {
            $("#validUntil").addClass("border-danger");
            $("#validUntilEmpty").text("Please enter a valid date.").show();
            isValid = false;
        } else if (selectedDate < today) {
            $("#validUntil").addClass("border-danger");
            $("#validUntilEmpty")
                .text("Valid Until date must be in the future.")
                .show();
            isValid = false;
        } else if (selectedDate > maxDate) {
            $("#validUntil").addClass("border-danger");
            $("#validUntilEmpty")
                .text(
                    "Valid Until date cannot be later than December 31, 2050."
                )
                .show();
            isValid = false;
        }

        if (isValid) {
            $("#validUntil").addClass("border-success");
        }

        return isValid;
    }

    // Attach keyup and change event listeners for real-time validation
    $("#validUntil").on("keyup change", function () {
        validateValidUntil();
    });

    // Form Validation on Submit
    $("#jobForm").submit(function (event) {
        const subCategoryId = $("#subCategoryId").val();
        const otherCategory = $("#otherSub").val();
        if (subCategoryId === "Other") {
     
            if (!otherCategory.trim()) {
                $("#otherSub").addClass("border-danger");
                $("#otherCategoryEmpty")
                    .text("Please write your category.")
                    .show();
                isValid = false;
            }
        }
        if (window.jobDescriptionEditor) {
            const editorContent = window.jobDescriptionEditor.getData().trim();
            $('textarea[name="description"]').val(editorContent);
            console.log(
                `📝 CKEditor content length: ${editorContent.length} characters`
            );
        }

        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function showError(field, errorField, message) {
        $(field).addClass("border-danger");
        $(errorField).text(message).show();
    }

    function hideError(field, errorField) {
        $(field).removeClass("border-danger");
        $(errorField).text("").hide();
    }
});
