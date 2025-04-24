@extends('contributor.template-contributor')
@section('main-title', 'Chat with recruiters')
@section('title-dash', 'Chat')

@section('content')
    <div class="container m-0">
        <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i
                class="fa fa-chevron-left text-white"></i> Back</button>
        @if($activeConnections->count() == 0)
        <div class="card card-flush shadow-sm mb-5">
            <div class="card-body text-center">
                <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                    <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                        <!-- Metronic SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                            <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1">No connections found</h4>
                        <p class="mb-0">
                            To start chatting, please first connect with recruiters on the
                            <a href="{{ asset('/contributor/find/recruiters') }}">Find Recruiters</a> page.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="row">
            <div class="col-lg-12">
                @include('contributor.components.chat')
            </div>
        </div>
        @endif
    </div>
@endsection
