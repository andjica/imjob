@extends('recruiter.template-recruiter') 
@section('main-title', 'Edit recruiter profile')

@section('title-dash', 'Here you can update your recruiter data')

@section('content')

<div class="container m-0">
    <div class="row mb-5">
            <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
            </div>
    </div>
   
    @if(is_null($recruiter->education))
        @include('recruiter.components.education.create')
    @else
        @include('recruiter.components.education.edit')
    @endif

    <!-- Div card for profile update -->
     @include('recruiter.components.edit-profile')
   
        <!-- End Div card for profile update -->
</div>



@endsection
@section('js')
<script src="{{asset('/js/custom/recruiter-education-validation.js')}}"></script>
<script src="{{asset('/js/custom/recruiter-profile-validation.js')}}"></script>
<script>

$(document).ready(function () {
    $("#countryId").on("change", function () {
        var countryId = $(this).val();

        // Reset city dropdown
        $("#cityId").html('<option value="">Select a city</option>');

        if (countryId) {
            $.ajax({
                url: "/country/" + countryId + "/phone-code",
                method: "GET",
                success: function (response) {
                    if (response && response) {
                        let code = response.toString().replace(/^\+/, ""); // uklanja eventualni višak "+"
                        $("#phoneCodeDisplay").text("+" + code);
                    } else {
                        $("#phoneCodeDisplay").text("+");
                    }
                },
                error: function () {
                    $("#phoneCodeDisplay").text("+");
                },
            });
            $.ajax({
                url: "/cities/" + countryId,
                method: "GET",
                success: function (response) {
                    console.log(response);
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
                    } else {
                        $("#cityId").append(
                            '<option value="">No cities found</option>'
                        );
                    }
                },
                error: function () {
                    alert("Failed to fetch cities. Please try again.");
                },
            });
        } else {
            // Hide the city row if no country is selected
            cityRow.addClass("d-none");
        }
    });
});
</script>
@endsection