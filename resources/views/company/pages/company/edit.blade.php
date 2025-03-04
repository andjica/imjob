@extends('company.template-company')
@section('main-title', 'Edit company profile')

@section('title-dash', 'Edit your company information')

@section('content')
<div class="container m-0">
    <div class="row bg-white">
      
        @include('alerts.success')
        @include('alerts.errors')
            <!--begin::Card-->
          
            @include('company.components.company.edit')
            <!--end::Card-->
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('/js/custom/create-company-validation.js')}}"></script>

@endsection
