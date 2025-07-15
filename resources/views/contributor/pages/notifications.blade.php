@extends('contributor.template-contributor')
@section('main-title', 'Your Active Connections')
@section('title-dash', 'Notification')


@section('content')
<div class="container m-0">
    <div class="row">
            <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
            </div>
    </div>
    <div class="row">
            <div class="btn-back">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white p-2 mb-5"> <i
                        class="fa fa-chevron-left text-white"></i> Back</button>
            </div>
    </div>
        @if ($newRecruiters->count() == 0)
            <div class="row">
                <div class="col-lg-12">
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
                                    <h4 class="mb-1">No new requestiest from recruiters</h4>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Your new Notifications by Recruiters</h4>
                </div>
                <div class="card-body">
        
                <small class="card-title fw-light fst-italic">Recruiters follow request to you</small><br>

                    @foreach ($newRecruiters as $not)
                        <div class="alert alert-warning justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $not->user->first_name }} {{ $not->user->last_name }}</strong><br>
                                <span>{{ $not->user->email }}</span>
                                <br>
                                <br>
                                <span>Country: {{ $not->country->name }}, City: {{ $not->city->name }}</span>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success btn-sm" title="Accept" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $not->id }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $not->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <hr>
                                <span class="text-muted fs-7 fw-bold justify-content-right">{{ $not->created_at->diffForHumans() }}</span>
                                
                            </div>

                            <!-- Accept Modal -->
                            <div class="modal fade" id="acceptModal{{ $not->id }}" tabindex="-1" aria-labelledby="acceptModalLabel{{ $not->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light-success">
                                            <h5 class="modal-title" id="acceptModalLabel{{ $not->id }}">Accept Recruiter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Accept connection with this recruiter?</p>
                                            <ul>
                                            <a href="{{asset('/contributor/recruiter/'.$not->id.'/view')}}" class="">
                                            @if ($not?->profile_image)
                                                <img src="{{ asset(Storage::url($not->profile_image)) }}"
                                                    alt="Profile Image" class="img-fluid rounded-circle shadow-sm"
                                                    style="width: 60px; height: 60px;">
                                            @else
                                                <img src="{{ asset('images/user-286.png') }}" alt="Profile Image"
                                                    class="img-fluid rounded-circle shadow-sm"
                                                    style="width: 60px; height: 60px;">
                                            @endif
                                            </a>
                                                <li><strong>First name and last name:</strong> {{ $not->user->first_name }} {{ $not->user->last_name }}</li>
                                                <li><strong>Email:</strong> {{ $not->user->email }}</li>
                                                <li><strong>Country:</strong> {{ $not->country->name }}</li>
                                                <li><strong>Created At:</strong> {{ $not->created_at->format('d-m-Y') }}</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{asset('/contributor/change-status')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="contributor_id" value="{{auth()->user()->contributor->id}}">
                                                <input type="hidden" name="recruiter_id" value="{{$not->id}}">
                                                <input type="hidden" name="status" value="Active">
                                                <input type="submit" class="btn btn-success" value="Active">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $not->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $not->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light-danger">
                                            <h5 class="modal-title" id="rejectModalLabel{{ $not->id }}">Reject Recruiter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to reject this recruiter?</p>
                                            <ul>
                                                <li><strong>Name:</strong> {{ $not->name }}</li>
                                                <li><strong>Email:</strong> {{ $not->user->email }}</li>
                                                <li><strong>Country:</strong> {{ $not->country->name }}</li>
                                                <li><strong>Registration number:</strong> {{ $not->registration_number}}</li>
                                                <li><strong>Created At:</strong> {{ $not->created_at->format('d-m-Y') }}</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{asset('/contributor/change-status')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="contributor_id" value="{{auth()->user()->contributor->id}} ">
                                                <input type="hidden" name="recruiter_id" value="{{$not->id}}">
                                                <input type="hidden" name="status" value="Rejected">
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
               
            </div>
                </div>
            </div>
        </div>
        @endif
    </div> 
@endsection
