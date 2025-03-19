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
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Your new Notifications by Companies</h4>
                    </div>
                    <div class="card-body">
                    <small class="card-title fw-light fst-italic">Companies follow request to you</small><br>
                    @if($newNotifications->count() == 0)
                    <div class="alert alert-warning align-items-center p-5 mb-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">No requests from companies</h4>
                                    <p class="mb-0">There are currently no new requests for connections from companies</p>
                                </div>
                            </div>
                    @else
                   
                        @foreach ($newNotifications as $not)
                            <div class="alert alert-warning justify-content-between align-items-center mb-3">
                                <div>
                                    @if($not->company->logo)
                                        <img src="{{ Storage::url($not->company->logo) }}" alt="{{ $not->company->name }}" class="rounded-circle" width="50" height="50">
                                    @else
                                        <i class="fas fa-building fa-2x text-muted"></i>
                                    @endif
                                    <strong>{{ $not->company->name }}</strong><br>
                                    <span>{{ $not->company->user->email }}</span>
                                    <br>
                                    <span>Category: {{ $not->company->category->name }}</span>
                                    <br>
                                    <span>Country: {{ $not->company->country->name }}, City: {{ $not->company->city->name }}</span>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-success btn-sm" title="Accept" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $not->company->id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $not->company->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <hr>
                                    <span class="text-muted fs-7 fw-bold justify-content-right">{{ $not->created_at->diffForHumans() }}</span>
                                  
                                </div>
                               
                                <!-- Accept Modal -->
                                <div class="modal fade" id="acceptModal{{ $not->company->id }}" tabindex="-1" aria-labelledby="acceptModalLabel{{ $not->company->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light-success">
                                                <h5 class="modal-title" id="acceptModalLabel{{ $not->company->id }}">Accept Company</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Accept connection with this company?</p>
                                                <ul>
                                                    <li><strong>Name:</strong> {{ $not->company->name }}</li>
                                                    <li><strong>Email:</strong> {{ $not->company->user->email }}</li>
                                                    <li><strong>Country:</strong> {{ $not->company->country->name }}</li>
                                                    <li><strong>Registration number:</strong> {{ $not->company->registration_number}}</li>
                                                    <li><strong>Created At:</strong> {{ $not->company->created_at->format('d-m-Y') }}</li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <form action=" {{ route('company-freelancer-follow-change-status') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{$not->company->id}}">
                                                    <input type="hidden" name="recruiter_id" value="{{auth()->user()->recruiter->id}}">
                                                    <input type="hidden" name="status" value="Active">
                                                    <input type="submit" class="btn btn-success" value="Active">
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $not->company->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $not->company->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light-danger">
                                                <h5 class="modal-title" id="rejectModalLabel{{ $not->company->id }}">Reject Company</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to reject this company?</p>
                                                <ul>
                                                    <li><strong>Name:</strong> {{ $not->company->name }}</li>
                                                    <li><strong>Email:</strong> {{ $not->company->user->email }}</li>
                                                    <li><strong>Country:</strong> {{ $not->company->country->name }}</li>
                                                    <li><strong>Registration number:</strong> {{ $not->company->registration_number}}</li>
                                                    <li><strong>Created At:</strong> {{ $not->company->created_at->format('d-m-Y') }}</li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('company-freelancer-follow-change-status') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{$not->company->id}}">
                                                    <input type="hidden" name="recruiter_id" value="{{auth()->user()->recruiter->id}}">
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
                        @endif
                        <hr>
                        <small class="card-title fw-light fst-italic">Your follow request</small>
                        @foreach ($recruiterToCompaniesFollowRequest as $follow)
                            <div class="alert alert-light mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <div class="d-flex align-items-center">
                                        @if($follow->company->logo)
                                            <img src="{{ Storage::url($follow->company->logo) }}" alt="{{ $follow->company->name }}" class="rounded-circle me-3" width="50" height="50">
                                        @else
                                            <i class="fas fa-building fa-2x text-muted me-3"></i>
                                        @endif 
                                        <div>
                                            <strong>{{ $follow->company->name }}</strong><br>
                                            <span>{{ $follow->company->user->email }}</span><br>
                                            <span>Category: {{ $follow->company->category->name }}</span><br>
                                            <span>Country: {{ $follow->company->country->name }}, City: {{ $follow->company->city->name }}</span><br>
                                            <span class="text-muted fs-7 fw-bold">{{ $follow->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                      
                                            <span class="badge bg-light-warning text-dark me-2 p-3 fw-light">Status on Pending</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <small class="card-title fw-light fst-italic">Older Notifications</small>

                        @foreach ($connections as $connection)
                        <div class="alert alert-light mb-3">
                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <div class="d-flex align-items-center">
                                        @if($connection->company->logo)
                                            <img src="{{ Storage::url($connection->company->logo) }}" alt="{{ $connection->company->name }}" class="rounded-circle me-3" width="50" height="50">
                                        @else
                                            <i class="fas fa-building fa-2x text-muted me-3"></i>
                                        @endif 
                                        <div>
                                            <strong>{{ $connection->company->name }}</strong><br>
                                            <span>{{ $connection->company->user->email }}</span><br>
                                            <span>Category: {{ $connection->company->category->name }}</span><br>
                                            <span>Country: {{ $connection->company->country->name }}, City: {{ $connection->company->city->name }}</span><br>
                                            <span class="text-muted fs-7 fw-bold">{{ $connection->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                    @if(trim($connection->status) === "Pending")
                                            <span class="badge bg-light-warning text-dark me-2 p-3 fw-light">Status on Pending</span>
                                        @elseif(trim($connection->status) === "Active")
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" title="You are connected with this company">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        @elseif(trim($connection->status) === "Rejected")
                                            <span class="badge bg-light-success text-dark me-2 p-3 fw-light">You are rejected</span>
                                        @else
                                            <span class="badge bg-light-danger text-dark me-2 p-3 fw-light">Unknown Status</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @endforeach
                  
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-5">
            @include('company-freelancer.components.notifications.contributor-notifications')
            </div>
        </div>
     </div>
    
@endsection

@section('js')
@endsection
