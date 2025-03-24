@php use App\Models\User; @endphp
@extends('recruiter.template-recruiter')
@section('main-title', 'Your active connections')

@section('title-dash', 'All connections with companies and recruiter')
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
    
            <div class="col-lg-6">
            @include('recruiter.components.connection.company')
            </div>    
            <div class="col-lg-6">
            @include('recruiter.components.connection.contributor')
            </div>
        </div>
           
     </div>
    
@endsection

@section('js')
@endsection
