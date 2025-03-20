@extends('company.template-company')
@section('main-title', 'Notifications')
@section('css')
<style>
    .background-image {
        background: url("{{ asset('images/card-company-info.svg') }}") no-repeat 250px;
        
        font-family: 'Arial', sans-serif;
         /* Ensure it covers the full height of the viewport */
        
   
        justify-content: center;
        align-items: center;
    }
    .border-danger
    {
        border:1px solid red !important;
    }
   
</style>
@endsection
@section('content')
<div class="container m-0 pb-5">
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
        <div class="row">
            <div class="col-lg-10">
                @include('company.components.notification.recruiter')
            </div>
        </div>
     </div>

@endsection
