@extends('company-freelancer.template-company-freelancer') 
@section('main-title', 'Edit freelancer profile')

@section('title-dash', 'Here you can update your freelancer data')

@section('content')

<div class="container m-0">
    <div class="btn-back">
        <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white p-2 mb-5"> <i
                class="fa fa-chevron-left text-white"></i> Back</button>
    </div>
    <div class="row">
            <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
            </div>
    </div>
   
    @if(is_null($freelancer->education))
        @include('company-freelancer.components.freelancer.create-education')
    @else
        @include('company-freelancer.components.freelancer.edit-education')
    @endif

    <!-- Div card for profile update -->
     @include('company-freelancer.components.freelancer.edit-profile')
   
        <!-- End Div card for profile update -->
</div>



@endsection
@section('js')
<script src="{{asset('/js/custom/recruiter-education-validation.js')}}"></script>
<script src="{{asset('/js/custom/recruiter-profile-validation.js')}}"></script>

@endsection