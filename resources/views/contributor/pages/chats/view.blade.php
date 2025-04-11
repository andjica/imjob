@extends('contributor.template-contributor')
@section('main-title', 'Chat with recruiters')
@section('title-dash', 'Chat')

@section('content')
    <div class="container m-0">
        <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i
                class="fa fa-chevron-left text-white"></i> Back</button>
        <div class="row">
            {{-- <div class="col-lg-5">
                <div class="contributor__recruiters">
                    @foreach ($activeConnections as $recruiter)
                        <div class="d-flex flex-stack pt-2 border-bottom recruiter-item"
                            data-id="{{ $recruiter->user->id }}"
                            data-name="{{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}">
                            <div class="symbol symbol-40px me-5">
                                @if ($recruiter->profile_image)
                                    <img src="{{ asset(Storage::url($recruiter->profile_image)) }}" alt="Profile Image"
                                        class="img-fluid rounded-circle shadow-sm" style="width: 60px; height: 60px;">
                                    <!-- Smaller size here -->
                                @else
                                    <img src="{{ asset('images/user-286.png') }}" alt="Profile Image"
                                        class="img-fluid rounded-circle shadow-sm" style="width: 60px; height: 60px;">
                                @endif
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Recruiter-->
                                <div class="flex-grow-1 me-2">
                                    <p class="fw-bold card-title text-dark h5"
                                        data-name="{{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}">
                                        {{ $recruiter->user->first_name }}
                                        {{ $recruiter->user->last_name }}</p>
                                    <span
                                        class="text-muted fw-semibold d-block fs-7">{{ $recruiter->title_function }}</span>
                                    <small><i>- @if ($recruiter->is_freelancer == 0)
                                                Freelancer
                                            @else
                                                Recruiter
                                            @endif
                                        </i></small><br>
                                    <small><i>{{ $recruiter->country->name }},
                                            {{ $recruiter->city->name }}</i></small><br>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
            <div class="col-lg-12">
                @include('contributor.components.chat')
            </div>
        </div>
    </div>
@endsection
