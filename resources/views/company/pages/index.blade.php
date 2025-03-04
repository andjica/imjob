@extends('company.template-company')
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
            @include('company.components.intro-banner')
        </div>
    </div>
</div>
@endsection
