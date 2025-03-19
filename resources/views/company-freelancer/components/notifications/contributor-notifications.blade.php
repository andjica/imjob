<div class="card">
    <div class="card-header">
        <h4 class="card-title">Your new Notifications by Contributors</h4>
    </div>
    <div class="card-body">
        <small class="card-title fw-light fst-italic">Contributor follow request to you</small><br>
        @if($newNotificationsFromContributor->count() == 0)
            <div class="alert alert-warning align-items-center p-5 mb-0">
                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                    </svg>
                </span>
                <div class="d-flex flex-column">
                    <h4 class="mb-1">No requests from contributor</h4>
                    <p class="mb-0">There are currently no new requests for connections from companies</p>
                </div>
            </div>
    @else
    
        @foreach ($newNotificationsFromContributor as $not)
            <div class="alert alert-warning justify-content-between align-items-center mb-3">
                <div>
                    <strong>{{ $not->contributor->name }}</strong><br>
                    <span>{{ $not->contributor->user->email }}</span>
                    <br>
                    <span>Contributor Type: 
                        @if($not->custom_contributor_type != null) 
                                {{$not->custom_contributor_type}}
                                @else
                                    {{ $not->contributor->contributorType->name }}
                        
                        @endif
                    </span>
                    <br>
                    <span>Country: {{ $not->contributor->country->name }}, City: {{ $not->contributor->city->name }}</span>
                    <div class="d-flex">
                        <button type="button" class="btn btn-success btn-sm" title="Accept" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $not->contributor->id }}">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $not->contributor->id }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <hr>
                    <span class="text-muted fs-7 fw-bold justify-content-right">{{ $not->created_at->diffForHumans() }}</span>
                    
                </div>
                
                <!-- Accept Modal -->
                <div class="modal fade" id="acceptModal{{ $not->contributor->id }}" tabindex="-1" aria-labelledby="acceptModalLabel{{ $not->contributor->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light-success">
                                <h5 class="modal-title" id="acceptModalLabel{{ $not->contributor->id }}">Accept Company</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Accept connection with this company?</p>
                                <ul>
                                    <li><strong>Name:</strong> {{ $not->contributor->name }}</li>
                                    <li><strong>Email:</strong> {{ $not->contributor->user->email }}</li>
                                    <li><strong>Country:</strong> {{ $not->contributor->country->name }}</li>
                                    <li><strong>Created At:</strong> {{ $not->contributor->created_at->format('d-m-Y') }}</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <form action=" {{ route('company-freelancer-make-connection-accept-contributor') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="contributor_id" value="{{$not->contributor->id}}">
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
                    <div class="modal fade" id="rejectModal{{ $not->contributor->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $not->contributor->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light-danger">
                                <h5 class="modal-title" id="rejectModalLabel{{ $not->contributor->id }}">Reject Company</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to reject this company?</p>
                                <ul>
                                    <li><strong>Name:</strong> {{ $not->contributor->name }}</li>
                                    <li><strong>Email:</strong> {{ $not->contributor->user->email }}</li>
                                    <li><strong>Country:</strong> {{ $not->contributor->country->name }}</li>
                                    <li><strong>Registration number:</strong> {{ $not->contributor->registration_number}}</li>
                                    <li><strong>Created At:</strong> {{ $not->contributor->created_at->format('d-m-Y') }}</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('company-freelancer-make-connection-accept-contributor') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="contributor_id" value="{{$not->contributor->id}}">
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
        @foreach ($recruiterToContributorFollowRequest as $follow)
            <div class="alert alert-light mb-3 bg-light">
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <div class="d-flex align-items-center">

                        <div>
                            <strong>{{ $follow->contributor->name }}</strong><br>
                            <span>{{ $follow->contributor->user->email }}</span><br>
                            <span>Contributor Type: 
                                @if($follow->custom_contributor_type != null) 
                                {{$follow->custom_contributor_type}}
                                @else
                                    {{ $follow->contributor->contributorType->name }}
                        
                                @endif
                            </span><br>
                            <span>Country: {{ $follow->contributor->country->name }}, City: {{ $follow->contributor->city->name }}</span><br>
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

        @foreach ($recruiterContributorConnections as $connection)
        <div class="alert alert-light mb-3">
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <div class="d-flex align-items-center">
                        <div>
                            <strong>{{ $connection->contributor->name }}</strong><br>
                            <span>{{ $connection->contributor->user->email }}</span><br>
                            <span>Contributor Type: @if($connection->custom_contributor_type != null) 
                                {{$connection->custom_contributor_type}}
                                @else
                                    {{ $connection->contributor->contributorType->name }}
                        
                                @endif</span><br>
                            <span>Country: {{ $connection->contributor->country->name }}, City: {{ $connection->contributor->city->name }}</span><br>
                            <span class="text-muted fs-7 fw-bold">{{ $connection->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="card-toolbar">
                    @if(trim($connection->status) === "Pending")
                            <span class="badge bg-light-warning text-dark me-2 p-3 fw-light">Status on Pending</span>
                        @elseif(trim($connection->status) === "Active")
                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" title="You are connected with this contributor">
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