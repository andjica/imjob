@extends('contributor.template-contributor')
@section('main-title', 'Setting')

@section('title-dash', 'Settings')

@section('content')
    <div class="container m-0">
        <!-- Alerts -->
        <div class="row">
            <div class="col-lg-10">
                @include('alerts.success')
                @include('alerts.errors')
            </div>
        </div>
        <!--End Alerts -->
        <div class="row">
            <div class="btn-back">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i
                        class="fa fa-chevron-left text-white"></i> Back</button>
            </div>
            @include('contributor.components.security-settings')
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/custom/security-validation.js') }}"></script>
@endsection
