@extends('company.template-company')
@section('main-title', 'Edit company profile')

@section('title-dash', 'Edit your company information')

@section('content')
    <div class="container m-0">
        <div class="btn-back">
            <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i
                    class="fa fa-chevron-left text-white"></i> Back</button>
        </div>
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
    <script src="{{ asset('/js/custom/create-company-validation.js') }}"></script>

@endsection
