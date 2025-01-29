@extends('contributor.template-contributor')
@section('main-title', 'Welcome, ' . auth()->user()->first_name)
@section('title-dash', 'Contributor Overview')

@section('css')
    <style>
        .objfit {
            object-fit: cover !important;
        }
    </style>
@endsection

@section('content')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-10">
            @include('alerts.errors')
            @include('alerts.success')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            @if(!auth()->user()->contributor)
                @include('contributor.components.create')
            @else
                @include('contributor.components.banner-create')
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            @if(auth()->user()->contributor)
                @php 
                    $contributor = auth()->user()->contributor;
                
                @endphp
                @include('contributor.components.profile')
            @endif
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('/js/custom/country-city-ajax.js') }}"></script>
<script src="{{asset('/js/custom/contributor/create-profile.js')}}"></script>


@endsection

