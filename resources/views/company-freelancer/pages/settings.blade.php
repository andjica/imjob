@extends('company-freelancer.template-company-freelancer') 
@section('main-title', 'Setting')

@section('title-dash', 'Settings')

@section('content')
<div class="container m-0">
    <!-- Alerts -->
    <div class="row mb-5">
            <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
            </div>
    </div>
     <!--End Alerts -->
    <div class="row">
        @include('company-freelancer.components.freelancer.security-settings')
    </div>
</div>
   
@endsection

@section('js')
<script src="{{asset('/js/custom/security-validation.js')}}"></script>
@endsection