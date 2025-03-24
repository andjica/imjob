@extends('company.template-company')

@section('content')
@section('main-title', 'Add employee')
@section('title-dash', 'Add employee')
<div class="container m-0">
    <div class="row">
         @include('alerts.success')
        @include('alerts.errors')
        <!-- First Card: Add Employee :) -->
        <div class="btn-back">
            <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i class="fa fa-chevron-left text-white"></i> Back</button>
        </div>
        <div class="col-8">
             @include('company.components.company.form-add-employee')
        </div>

        <!-- Second Card: Send Email -->
            <div class="col-4">
                @include('company.components.company.email-add-employees')
            </div>
        </div>
        <div class="row mt-5">
            @include('company.components.company.active-connections')
        </div>
        
        
   
</div>
@endsection
<!-- Select2 Script for Image Support -->
@section('js')
<script src="{{asset('/js/custom/employee/select-recruiter.js')}}"></script>
<script src="{{asset('/js/custom/employee/email-validation.js')}}"></script>
@endsection
