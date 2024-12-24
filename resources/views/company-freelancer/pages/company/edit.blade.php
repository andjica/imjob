@extends('company-freelancer.template-company-freelancer')

@section('title-dash', 'Edit Company')

@section('content')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-10">
        @include('alerts.success')
        @include('alerts.errors')
            <!--begin::Card-->
           @include('company-freelancer.components.company.edit')
            <!--end::Card-->
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('/js/custom/create-company-validation.js')}}"></script>
@endsection

