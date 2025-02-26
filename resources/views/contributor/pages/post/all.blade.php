@extends('contributor.template-contributor')
@section('content')
    <div class="container m-0">
    @include('alerts.success')
    @include('alerts.errors')
        <div class="row">
        @if($posts->count() == 0)
            <div class="col-lg-7">
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
                            <h4 class="mb-1">No posts Found</h4>
                            <p class="mb-0">There are currently no posts. Please <a href="{{asset('/contributor/post/create')}}">create a new post.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            @foreach ($posts as $p)
                <div class="col-lg-5">
                    <div class="card shadow-sm border mt-2">
                        <div class="card-body">
                            {{ $p->description }}<br>

                            @if ($p->image != null)
                                <img src="{{ $p->image }}" alt="Image from contributor .{{$p->image}}" />
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        </div>
    </div>
@endsection
