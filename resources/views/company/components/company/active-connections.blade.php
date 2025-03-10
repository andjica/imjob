<div class="col-lg-12">

            @if ($activeRecruiters->count() === 0)
                <div class="card card-flush shadow-sm mb-5">
                    <div class="card-body text-center">
                        <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                            <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path opacity="0.3"
                                        d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"
                                        fill="currentColor" />
                                    <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <div class="d-flex flex-column">

                            <h4 class="mb-1 fw-bold text-dark">No Recruiters or Employees Found</h4>
                                <p class="mb-0 text-muted">
                                    You currently have no recruiters or employees in your connections list.  
                                    Start expanding your network by connecting with professionals.  
                                    <a href="{{ asset('/company/dashboard/find/recruiters') }}" class="text-primary fw-bold">Find Recruiters</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="card shadow-sm">
        <div class="card-header bg-muted text-white pt-10">
            <h3 class="card-title mt-3">Your Employee / Recruiter List</h3><br>
            <hr>
            
            <p class="text-muted fs-6">
                You are connected with this persons, you can give 
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
                <form action="{{ route('company-dashboard-find-recruiters') }}" method="GET"
                    class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
                    <!--begin::Icon-->
                    <i
                        class="fas fa-search fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"></i>
                    <!--end::Icon-->

                    <!--begin::Input-->
                    <input type="text" id="searchRecruiter" class="form-control form-control-solid ps-13"
                        name="search" value="{{ old('search', request('search')) }}"
                        placeholder="Search recruiter by first name, last name, email, title, company name">
                    <!--end::Input-->
                </form>
                <!--end::Form-->
            </div>
                <div class="row g-3">
                    @foreach ($activeRecruiters as $recruiter)
                        <div class="d-flex flex-stack pt-2">
                            <!--begin::Image-->
                            <div class="symbol symbol-40px me-5">
                                @if ($recruiter->profile_image)
                                    <img src="{{ asset(Storage::url($recruiter->profile_image)) }}"
                                        alt="Profile Image" class="img-fluid rounded-circle shadow-sm"
                                        style="width: 60px; height: 60px;"> <!-- Smaller size here -->
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </div>
                            <!--end::Image-->

                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Recruiter-->
                                <div class="flex-grow-1 me-2">
                                    <h5 class="card-title">{{ $recruiter->user->first_name }}
                                        {{ $recruiter->user->last_name }}</h5>

                                    <span
                                        class="text-muted fw-semibold d-block fs-7">{{ $recruiter->title_function }}</span>
                                    <p class="text-muted">{{ $recruiter->user->email }}</p>
                                </div>
                                <!--end:Recruiter-->

                                <!--begin:Action-->
                               <!-- Delete Recruiter Button -->
                                <button type="button" class="btn btn-sm btn-danger me-2 mb-2 delete-recruiter-button"
                                    data-bs-toggle="modal" data-bs-target="#deleteRecruiterModal"
                                    data-recruiter-id="{{ $recruiter->id }}"
                                    data-recruiter-name="{{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}">
                                    Remove
                                </button>
                                <!--end:Action-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteRecruiterModal" tabindex="-1" aria-labelledby="deleteRecruiterModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteRecruiterModalLabel">Remove Recruiter</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to remove <strong id="recruiterName">{{$recruiter->user->first_name}}{{$recruiter->user->last_name}}</strong> from your connections?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form id="deleteRecruiterForm" method="POST" action="{{asset('/company/dashboard/status-change/to-delete')}}">
                                        @csrf
                                        <input type="hidden" name="recruiter_id" id="recruiterId" value="{{$recruiter->id}}">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            @endif
        </div>

    </div>
</div>
