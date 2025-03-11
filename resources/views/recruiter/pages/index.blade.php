@extends('recruiter.template-recruiter')
@section('title-dash', 'Welcome')
@section('content')
    <div class="container m-0">
        <div class="row">
            <div class="col-lg-10">
                @include('alerts.errors')
                @include('alerts.success')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @include('recruiter.components.banner-find')
            </div>
            <div class="col-lg-12 mt-5">
                @include('recruiter.components.info')
            </div>
        </div>
    </div>
@endsection
