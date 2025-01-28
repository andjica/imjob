$(document).ready(function() {
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
        $("#currencyName").text('N/A');
        $("#currencySymbol").text('N/A');
        currencyInfoRow.addClass("d-none");
        currencyLoading.addClass("d-none");

        if (countryId) {
            // Fetch Cities
            loading.removeClass("d-none");
            currencyLoading.removeClass("d-none");
            $.ajax({
                url: '/cities/' + countryId,
                method: 'GET',
                success: function (response) {
                    console.log('Cities Response:', response);
                    if (response.cities && response.cities.length > 0) {
                        response.cities.forEach(function (city) {
                            $("#cityId").append(
                                '<option value="' + city.id + '">' + city.name + '</option>'
                            );
                        });
                        // Show the city row if cities are available
                        cityRow.removeClass("d-none");
                    } else {
                        $("#cityId").append('<option value="">No cities found</option>');
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
                }
            });
        };
    });
});
    
