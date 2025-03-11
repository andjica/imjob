@isset($recruiter)
    <div class="card shadow-sm">
        <div class="card-header border-0 bg-light text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0 d-flex align-items-center">
                <i class="fas fa-user me-2 text-primary"></i> Recruiter Information
            </h3>
            <a href="{{ asset('/recruiter/edit') }}" title="Edit your profile" data-bs-toggle="tooltip"
                data-bs-placement="left"><i class="fas fa-pen-to-square fa-1x text-primary" style="cursor: pointer;"></i></a>
        </div>
        <div class="card-body pt-9 pb-0 bg-white">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">
                <!--begin: Profile Picture-->
                <div class="me-7 mb-4">
                    @if (!empty($recruiter->profile_image) && Storage::exists('public/' . $recruiter->profile_image))
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('storage/' . $recruiter->profile_image) }}"
                                alt="{{ $recruiter->user->first_name }}" class="objfit">
                        </div>
                    @else
                        <img src="{{ asset('images/user-286.png') }}" alt="Default Profile Image"
                            class="img-fluid rounded-circle objfit" width="160px">
                    @endif
                </div>
                <!--end::Profile Picture-->

                <!--begin::Recruiter Info-->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Basic Info-->
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <h2 class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                    {{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}
                                </h2>
                                <i class="fas fa-check-circle text-primary fs-3" aria-hidden="true" title="Verified"></i>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-briefcase text-muted me-2" aria-hidden="true"></i>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-500">Experience Level:</span>
                                    <span class="fw-bold">{{ $recruiter->experience_level }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center me-6 mb-3">
                                <i class="fas fa-calendar-alt text-muted me-2" aria-hidden="true"></i>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-muted">Availability</span>
                                    <span class="fs-2 fw-bold">{{ $recruiter->availability }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-birthday-cake text-muted me-2" aria-hidden="true"></i>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-muted">Age</span>
                                    <span class="fs-2 fw-bold">{{ \Carbon\Carbon::parse($recruiter->birthday)->age }}
                                        years</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Basic Info-->

                        <!--begin::Actions-->
                        <div class="d-flex align-items-center w-200px w-sm-200px flex-column mt-3">
                            @if (isset($recruiter->education) && !empty($recruiter->education))
                                <!-- Completed Profile Card -->
                                <div class="d-flex justify-content-between w-100 mb-2">
                                    <span class="fw-semibold fs-6 text-gray-500">
                                        <i class="fas fa-check-circle text-primary me-2" aria-hidden="true"></i>
                                        Profile Completed
                                    </span>
                                    <span class="fw-bold fs-6 text-success">100%</span>
                                </div>

                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                    <div class="bg-info rounded h-5px" role="progressbar" style="width: 100%;"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <a href="{{ asset('/recruiter/edit') }}" class="btn btn-info btn-sm w-100">
                                    <i class="fas fa-eye me-2" aria-hidden="true"></i> View Profile
                                </a>
                            @else
                                <!-- Profile Completion Card -->
                                <div class="d-flex justify-content-between w-100 mb-2">
                                    <span class="fw-semibold fs-6 text-gray-500">
                                        <i class="fas fa-user-edit text-primary me-2" aria-hidden="true"></i>
                                        Profile Completion
                                        <ul class="list-unstyled mt-2">
                                            <li>
                                                @if (!empty($recruiter->education))
                                                    <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-danger me-2" aria-hidden="true"></i>
                                                @endif
                                                Profile Education
                                            </li>
                                            <li>
                                                @if (!empty($recruiter->language_skills))
                                                    <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-danger me-2" aria-hidden="true"></i>
                                                @endif
                                                Your Language Skills
                                            </li>
                                        </ul>
                                    </span>
                                    @php

                                        $completionPercentage = 50;
                                    @endphp
                                    <span class="fw-bold fs-6">
                                        <i class="fas fa-percentage text-info me-1" aria-hidden="true"></i>
                                        {{ $completionPercentage }}%
                                    </span>
                                </div>

                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                    <div class="bg-info rounded h-5px" role="progressbar"
                                        style="width: {{ $completionPercentage }}%;" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <a href="{{ asset('/recruiter/edit') }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-edit me-2" aria-hidden="true"></i> Complete Profile
                                </a>
                            @endif
                        </div>
                        <!--end::Actions-->
                    </div>

                    <!--begin::Nav Tabs-->
                    <ul class="nav nav-pills nav-pills-custom nav-pills-rounded mb-5">
                        <li class="nav-item mb-3">
                            <a class="nav-link" href="">
                                <i class="fas fa-user-circle me-2" aria-hidden="true"></i> recruiter Overview
                            </a>
                        </li>
                        <li class="nav-item mb-3">
                            <a class="nav-link" href="{{ asset('/company/recruiter/active/jobs') }}">
                                <i class="fas fa-briefcase me-2" aria-hidden="true"></i> Your Posted Jobs
                            </a>
                        </li>
                        @if ($recruiter->companies->count() > 0)
                            <li class="nav-item mb-3">
                                Your connections
                                <div class="symbol-group symbol-hover mb-3">
                                    @foreach ($recruiter->companies as $cm)
                                        {{ $cm->name }}
                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip"
                                            data-bs-original-title="Alan Warden" data-kt-initialized="1">
                                            @if ($cm->logo != null)
                                                <img alt="Pic" src="{{ Storage::url($cm->logo) }}">
                                            @else
                                                <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                    <!--end::Nav Tabs-->
                </div>
                <!--end::recruiter Info-->
            </div>
            <!--end::Details-->
            <!-- <div class="card-footer bg-light d-flex justify-content-end">
            <a href="#" class="btn btn-primary btn-sm">
                <i class="fas fa-edit me-1"></i> Edit profile
            </a>
           
        </div> -->
        </div>
    </div>
@endisset
