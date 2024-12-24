@extends('company.template-company')

@section('content')
@section('title-dash', 'Recruiters')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-muted text-white pt-10">
                    <h3 class="card-title mt-3">Recruiters List</h3><br>
                    <hr>
                    <p class="text-muted fs-6">
                        Here, you can find and connect with top-tier recruiters to help you grow your team and achieve your business goals. 
                        Simply browse the list of available recruiters, make a request, and wait for their response. It's that easy!
                    </p>
                    <p class="text-muted fs-6">
                        Once you’ve sent a request to a recruiter, the status will show as 
                        <span class="fw-semibold text-warning">Pending</span>. This means the recruiter has not yet responded to your request. 
                        Please allow some time for them to review and accept your invitation.
                    </p>
                    <p class="text-muted fs-6">
                        Once a recruiter accepts your request, you’ll be notified, and you can start collaborating to build the team your company deserves.
                    </p>
                    
                </div>

                <div class="card-body p-4">
                <div class="card-header p-0" id="kt_contacts_list_header">
                    <!--begin::Form-->
                    @if (request('search'))
                        <form method="GET" action="{{ route('company-dashboard-find-recruiters') }}">
                            <button type="submit" class="btn btn-primary mb-3 btn-sm">
                                <i class="fa-solid fa-chevron-left"></i> Back to All Recruiters
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('company-dashboard-find-recruiters') }}" method="GET" class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
                        <!--begin::Icon-->
                        <i class="fas fa-search fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"></i>
                        <!--end::Icon-->

                        <!--begin::Input-->
                        <input type="text" id="searchRecruiter" class="form-control form-control-solid ps-13" name="search" 
                            value="{{ old('search', request('search')) }}" placeholder="Search recruiter by first name, last name, email, title, company name">
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
            @if ($recruiters->count() === 0)
                <div class="card card-flush shadow-sm mb-5">
                    <div class="card-body text-center">
                        <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                                    <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                                </svg>
                            </span>
                            <div class="d-flex flex-column">
                               
                                <h4 class="mb-1">No Recruiters Found</h4>
                                <p class="mb-0">There are currently no active recruiters in the system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
        <div class="row g-3">
            @foreach ($recruiters as $recruiter)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        
                        <div class="card-body text-center">
                        @if ($recruiter->profile_image)
                                <img src="{{ asset('/images/' . $recruiter->profile_image) }}" 
                                    alt="Profile Image" 
                                    class="img-fluid rounded-circle shadow-sm"
                                    style="width: 60px; height: 60px;"> <!-- Smaller size here -->
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                            <h5 class="card-title">{{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}</h5>
                            <p class="text-muted mb-2">{{ $recruiter->title_function }}</p>
                            <p class="text-muted">{{ $recruiter->user->email }}</p>
                            <p class="small">Birthday: {{ $recruiter->birthday }}</p>

                            @php
                                $pivot = $company->recruiters->where('id', $recruiter->id)->first()->pivot ?? null;
                            @endphp

                            @if ($pivot && $pivot->status === 'onpending')
                                <button class="btn btn-warning btn-sm" disabled>Pending</button>
                            @elseif ($company->recruiters->contains($recruiter->id))
                                <button class="btn btn-success btn-sm" disabled>Connected</button>
                            @else
                                <form method="POST" action="{{ route('company-recruiters-call', ['recruiter' => $recruiter->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Make a request</button>
                                </form>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <span class="d-block text-gray-800 fw-semibold">Current Works for:</span>
                            @if ($recruiter->activeCompanies->count() === 0)
                                Without working
                            @else
                                @foreach ($recruiter->activeCompanies as $ractive)
                                    {{ $ractive->name }} (From: {{ $ractive->pivot->from_date }})<br>
                                @endforeach
                            @endif
                            <div class="mt-2">
                                <a href="{{ route('admin-dashboard-recruiter-profile', $recruiter->id) }}" class="btn btn-link btn-sm">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $recruiters->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
   <script src="{{asset('/assets/custom/user/users-table.js')}}"></script>
@endsection

