@php use App\Models\User; @endphp
@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Your notifications')

@section('title-dash', 'All Notifications')
@section('css')
   
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
            <div class="col-lg-5">
                @include('company-freelancer.components.notifications.company')
            </div>
            <div class="col-lg-5">
            @include('company-freelancer.components.notifications.contributor')
            </div>
        </div>
     </div>
    
@endsection

@section('js')
@endsection
