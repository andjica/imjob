$(document).ready(function () {
    $("#countryId").on("change", function () {
    
        var countryId = $(this).val();
        var cityRow = $("#cityRow"); // Assuming you have a row with id 'cityRow' for cities
        var currencyInfoRow = $("#currencyInfoRow");
        var loading = $("#loading");
        var currencyLoading = $("#currencyLoading");
        // Reset city dropdown
        $("#cityId").html('<option value="">Select a city</option>');
        loading.addClass("d-none");

        // Reset currency information
        $("#currencyName").text("N/A");
        $("#currencySymbol").text("N/A");
        currencyInfoRow.addClass("d-none");
        currencyLoading.addClass("d-none");

        if (countryId) {
            
            // Fetch Cities
            loading.removeClass("d-none");
            currencyLoading.removeClass("d-none");
            $.ajax({
                url: "/cities/" + countryId,
                method: "GET",
                success: function (response) {
                    console.log("Cities Response:", response);
                    if (response.cities && response.cities.length > 0) {
                        response.cities.forEach(function (city) {
                            $("#cityId").append(
                                '<option value="' +
                                    city.id +
                                    '">' +
                                    city.name +
                                    "</option>"
                            );
                        });
                        // Show the city row if cities are available
                        cityRow.removeClass("d-none");
                    } else {
                        $("#cityId").append(
                            '<option value="">No cities found</option>'
                        );
                        // Optionally hide the city row if no cities are found
                        cityRow.addClass("d-none");
                    }
                },
                error: function () {
                    alert("Failed to fetch cities. Please try again.");
                    // Optionally hide the city row on error
                    cityRow.addClass("d-none");
                },
                complete: function () {
                    // Hide loading indicator
                    loading.addClass("d-none");
                    currencyLoading.addClass("d-none");
                },
            });

            // Fetch Currency Information
            $.ajax({
                url: "/country/" + countryId + "/currency",
                method: "GET",
                success: function (response) {
                    console.log("Currency Response:", response);
                    if (response.currency_name && response.currency_symbol) {
                        $("#currencyName").text(response.currency_name);
                        $("#currencySymbol").text(response.currency_symbol);
                        currencyInfoRow.removeClass("d-none");
                    } else {
                        $("#currencyName").text("N/A");
                        $("#currencySymbol").text("N/A");
                        currencyInfoRow.addClass("d-none");
                    }
                },
                error: function () {
                    alert(
                        "Failed to fetch currency information. Please try again."
                    );
                    currencyInfoRow.addClass("d-none");
                },
                complete: function () {
                    // Hide loading indicator
                    loading.addClass("d-none");
                },
            });
        } else {
            // Hide the city and currency rows if no country is selected
            cityRow.addClass("d-none");
            currencyInfoRow.addClass("d-none");
        }
    });

    $("#categoryId").on("change", function () {
        var categoryId = $(this).val();
        var subCategoryRow = $("#subCategoryRow");
        var loading = $("#loading");

        // Reset subCategory dropdown
        $("#subCategoryId").html(
            '<option value="">Select a subcategory</option>'
        );

        if (categoryId) {
            // Show the loading spinner
            loading.removeClass("d-none");

            // Make AJAX call to fetch subcategories
            $.ajax({
                url: "/subcategories/" + categoryId,
                method: "GET",
                dataType: "json", // Ensure the response is parsed as JSON
                success: function (response) {
                    console.log("Subcategories Response:", response);
                    if (
                        response.subcategories &&
                        response.subcategories.length > 0
                    ) {
                        response.subcategories.forEach(function (subCategory) {
                            $("#subCategoryId").append(
                                '<option value="' +
                                    subCategory.id +
                                    '">' +
                                    subCategory.name +
                                    "</option>"
                            );
                        });
                        // Show the subcategory row if not already visible
                        subCategoryRow.removeClass("d-none");
                    } else {
                        $("#subCategoryId").append(
                            '<option value="">No subcategories found</option>'
                        );
                        // Optionally, keep the subcategory row visible to show the message
                        subCategoryRow.removeClass("d-none");
                    }
                    // At the end apped "Other" option
                    $("#subCategoryId").append(
                        '<option value="Other">Other</option>'
                    );
                },
                error: function () {
                    $("#ajaxErrorMessage").text(
                        "Failed to fetch subcategories. Please try again."
                    );
                    $("#ajaxErrors").removeClass("d-none");
                    // Optionally, hide the subcategory row on error
                    subCategoryRow.addClass("d-none");
                },
                complete: function () {
                    // Hide the loading spinner regardless of success or error
                    loading.addClass("d-none");
                },
            });
        } else {
            // If no category is selected, hide the subcategory row and ensure spinner is hidden
            subCategoryRow.addClass("d-none");
            loading.addClass("d-none");
        }
    });

    // Show or hide "otherSub" input field based on selection
    $('#subCategoryId').select2();
    $('#subCategoryId').on("change select2:select", function () {
       
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
});
