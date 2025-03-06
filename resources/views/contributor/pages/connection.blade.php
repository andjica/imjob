@extends('contributor.template-contributor')
@section('content')
    <div class="container">
        @if ($activeConnection->count() == 0)
            <div class="row">
                <div class="col-lg-7">
                    <div class="card card-flush shadow-sm mb-5">
                        <div class="card-body text-center">
                            <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                    <!-- Metronic SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path opacity="0.3"
                                            d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"
                                            fill="currentColor"></path>
                                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor">
                                        </path>
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">No connection Found</h4>
                                    <p class="mb-0">There are currently no connections. Please <a
                                            href="{{ asset('/contributor/find/recruiters') }}">follow a new recruiters.</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($activeConnection as $ac)
                            <div class="d-flex flex-stack pt-2 border-bottom">
                                <!--begin::Image-->
                                <div class="symbol symbol-40px me-5">
                                    @if ($ac->profile_image == null)
                                        <img src="{{ asset('images/user-286.png') }}" alt="Profile Image"
                                            class="img-fluid rounded-circle shadow-sm" style="width: 60px; height: 60px;">
                                    @else
                                        <img src="{{ Storage::url($ac->profile_image) }}" alt="Profile Image"
                                            class="img-fluid rounded-circle shadow-sm" style="width: 60px; height: 60px;">
                                    @endif
                                </div>
                                <!--end::Image-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Recruiter-->
                                    <div class="flex-grow-1 me-2">
                                        <h5 class="card-title">{{ $ac->user->first_name }} {{ $ac->user->last_name }}</h5>
                                        <span class="text-muted fw-semibold d-block fs-7">{{ $ac->title_function }}</span>
                                        <p class="text-muted">{{ $ac->user->email }}</p>

                                    </div>
                                    <!-- This button is shown if the recruiter is connected and the status is active -->
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-primary btn-sm mt-4" data-bs-toggle="tooltip"
                                            data-bs-placement="left" title="You are connected with this company">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    </div>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
