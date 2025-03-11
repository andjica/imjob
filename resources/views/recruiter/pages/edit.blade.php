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
   
    {{-- @if(is_null($recruiter->education))
        @include('recruiter.components.create-education')
    @else
        @include('recruiter.components.edit-education')
    @endif --}}

    <!-- Div card for profile update -->
     @include('recruiter.components.edit-profile')
   
        <!-- End Div card for profile update -->
</div>



@endsection
@section('js')
<script src="{{asset('/js/custom/recruiter-education-validation.js')}}"></script>
<script src="{{asset('/js/custom/recruiter-profile-validation.js')}}"></script>

@endsection