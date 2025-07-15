@section('main-title', 'Dashboard')
@section('title-dash', 'All Connections')

<div class="card">
<div class="card-header">
    <h4 class="card-title">Your new Notifications by Companies</h4>
</div>
<div class="card-body">
@if($connections->count() == 0)
<div class="alert alert-warning align-items-center p-5 mb-0">
            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                    <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                </svg>
            </span>
            <div class="d-flex flex-column">
                <h4 class="mb-1">There are currently no connections</h4>
                <p class="mb-0">For start connection make follow request to new recruiter! You can find recruiter on
                     <a href="{{asset('/company/dashboard/find/recruiters')}}">Find recruiter page.</a></p>
            </div>
</div>
@else
    @foreach ($connections as $connection)
    <div class="alert alert-light mb-3">
            <div class="d-flex justify-content-between align-items-center border-top pt-2">
                <div class="d-flex align-items-center">
                @if ($connection->recruiter?->profile_image !== null) 
                        <img src="{{ asset(Storage::url($connection->recruiter->profile_image)) }}"
                            alt="Profile Image" class="img-fluid rounded-circle shadow-sm"
                            style="width: 60px; height: 60px;">
                    @else
                        <img src="{{ asset('images/user-286.png') }}" alt="Profile Image"
                            class="img-fluid rounded-circle shadow-sm"
                            style="width: 60px; height: 60px;">
                    @endif
                    <div>
                        <strong>First name and last name:{{ $connection->recruiter->user->first_name }} {{ $connection->recruiter->user->last_name }}</strong>
                        <span>{{ $connection->recruiter->user->email }}</span><br>
                        <span>Country: {{ $connection->recruiter->country->name }}, City: {{ $connection->recruiter->city->name }}</span><br>
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
    @endif
</div>

</div>