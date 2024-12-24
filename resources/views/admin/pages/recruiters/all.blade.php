@extends('admin.template-dashboard')

@section('content')
@section('title-dash', 'Recruiters')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-muted text-white">
                    <h3 class="card-title">Recruiters List</h3>
                </div>
                <div class="card-body p-4">
                    @if ($recruiters->count() === 0)
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
                                <form method="GET" action="{{ route('admin-dashboard-recruiters') }}">
                                                <button type="submit" class="btn btn-primary mb-3 btn-sm">
                                                    <i class="fa-solid fa-chevron-left"></i> Back to All Recruiters
                                                </button>
                                            </form>
                                    <h4 class="mb-1">No Recruiters Found</h4>
                                    <p class="mb-0">There are currently no active recruiters in the system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                     <!--begin::Contacts-->
            <div class="card card-flush" id="kt_contacts_list">
                    <!--begin::Header-->
                <div class="card-header p-0" id="kt_contacts_list_header">
                    <!--begin::Form-->
                    @if (request('search'))
                        <form method="GET" action="{{ route('admin-dashboard-recruiters') }}">
                            <button type="submit" class="btn btn-primary mb-3 btn-sm">
                                <i class="fa-solid fa-chevron-left"></i> Back to All Recruiters
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin-dashboard-recruiters') }}" method="GET" class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
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
            </div>
                <!-- Recruiters Table -->
            <div class="card card-flush">
              
                <div class="card-body p-0 rounded">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="text-gray-600 fw-bold bg-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>First Name / Last Name</th>
                                <th>Profile Image</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recruiters as $index => $recruiter)
                                <tr class="text-center">
                                    <td class="fw-bold text-gray-800">{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        <span class="d-block text-dark fw-semibold">{{ $recruiter->user->first_name }}</span>
                                        <span class="text-muted">{{ $recruiter->user->last_name }}</span>
                                    </td>
                                    <td>
                                    @if(Storage::exists('public/' . $recruiter->profile_image))
                                        <img src="{{ asset('storage/' . $recruiter->profile_image) }}" alt="{{  $recruiter->user->first_name }}" class="objfit img-fluid" width="150px">
                                    @else
                                        <p>No profile image available.</p>
                                    @endif
                                    </td>
                                    <td class="text-gray-600">{{ $recruiter->user->email }}</td>
                                    <td>{{ $recruiter->birthday }}</td>
                                    <td class="fw-bold">
                                    @if($recruiter->is_freelancer == 1)
                                        {{$recruiter->user->first_name}} is freelancer in own company <br>- <a href="">{{$recruiter->freelancerCompany->company->name}}</a>
                                    @else
                                    {{ $recruiter->title_function }}
                                    @endif
                                    </td>
                                    <td>
                                        <span class="d-block text-gray-800 fw-semibold">Current Works for:</span>
                                        @if($recruiter->activeCompanies->count() == 0)
                                            Witouth working
                                        @else
                                        @foreach($recruiter->activeCompanies as $ractive)
                                            {{ $ractive->name }} (From: {{ $ractive->pivot->from_date }})<br>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                    <!-- Dropdown Action for View Profile -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="{{ route('admin-dashboard-recruiter-profile', $recruiter->id) }}">View Profile</a></li>
                                            <!-- You can add more actions here -->
                                            <li><a class="dropdown-item" href="{{ route('admin-dashboard-recruiter-profile', $recruiter->id) }}">Edit</a></li>
                                            <li><a class="dropdown-item text-danger" href="{{ route('admin-dashboard-recruiter-profile', $recruiter->id) }}">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-warning" role="alert">
                                            No recruiters found.
                            
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

