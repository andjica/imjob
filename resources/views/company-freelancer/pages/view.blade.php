@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Profile overview')
@section('title-dash', 'View')

@section('content')
    <div class="container-fluid m-0 pb-5">
        <div class="row">
            <div class="col-lg-10">
                @include('alerts.success')
                @include('alerts.errors')
                <div class="card shadow-sm">
                    <div class="card-header border-0 bg-light text-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 d-flex align-items-center">
                            <i class="fas fa-user me-2 text-primary"></i> Freelancer Information
                        </h3>
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

                            <!--begin::Freelancer Info-->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                    <!--begin::Basic Info-->
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <h2 class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                                {{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}
                                            </h2>

                                            <i class="fas fa-check-circle text-primary fs-3" aria-hidden="true"
                                                title="Verified"></i>
                                        </div>

                                        <p class="text-muted fw-semibold">
                                            You have your own company
                                            <strong>{{ $recruiter->freelancerCompany->company->name }}</strong><br>
                                            From {{ $recruiter->freelancerCompany->company->country->name }}
                                        </p>
                                    </div>
                                    <!--end::Basic Info-->
                                </div>

                                <!--begin::Additional Info-->
                                <div class="d-flex flex-wrap mb-4">
                                    <div class="d-flex align-items-center me-5 mb-3">
                                        <i class="fas fa-tags text-muted me-2" aria-hidden="true"></i>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-500">Category:</span>
                                            <span
                                                class="fw-bold">{{ $recruiter->freelancerCompany?->company?->category?->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center me-5 mb-3">
                                        <i class="fas fa-list text-muted me-2" aria-hidden="true"></i>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-500">Sub-Category:</span>
                                            <span
                                                class="fw-bold">{{ $recruiter->freelancerCompany?->company?->subCategory?->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-briefcase text-muted me-2" aria-hidden="true"></i>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-500">Experience Level:</span>
                                            <span class="fw-bold">{{ $recruiter->experience_level }}</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Additional Info-->

                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap mb-4">
                                    <div class="d-flex align-items-center me-6 mb-3">
                                        <i class="fas fa-calendar-alt text-muted me-2" aria-hidden="true"></i>
                                        <div class="d-flex flex-column">
                                            <span class="fs-2 fw-bold">{{ $recruiter->availability }}</span>
                                            <span class="fw-semibold text-muted">Availability</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-birthday-cake text-muted me-2" aria-hidden="true"></i>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fs-2 fw-bold">{{ \Carbon\Carbon::parse($recruiter->birthday)->age }}
                                                years</span>
                                            <span class="fw-semibold text-muted">Age</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Freelancer Info-->
                        </div>
                        <!--end::Details-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header border-0 bg-light text-white">
                        <h3 class="card-title mb-0 d-flex align-items-center">
                            <i class="fa-solid fa-building-columns me-2"></i>Education Detail
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div>
                                <h4 class="mb-0">{{ $recruiter->name }}</h4>
                                <span class="badge badge-light">{{ $recruiter->owner_title }}</span>
                            </div>
                        </div>
                        <!-- Profile Details in Three Columns -->
                        <div class="row">
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $recruiter->user->first_name }}
                                        {{ $recruiter->user->last_name }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">School</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $recruiter->education->school }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Degree</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $recruiter->education->degree }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Field of Study</label>
                                <div class="col-lg-8">
                                    @if ($recruiter->education->field_of_study != null)
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $recruiter->education->field_of_study }}</span>
                                    @else
                                        <span class="fw-bold fs-6 text-gray-800">/</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Graduation</label>
                                <div class="col-lg-8">
                                    @if ($recruiter->education->year_of_graduation != null)
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $recruiter->education->year_of_graduation }}</span>
                                    @else
                                        <span class="fw-bold fs-6 text-gray-800">/</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Description</label>
                                <div class="col-lg-8">
                                    @if ($recruiter->education->description != null)
                                        <span
                                            class="fw-bold fs-6 text-gray-800">{{ $recruiter->education->description }}</span>
                                    @else
                                        <span class="fw-bold fs-6 text-gray-800">/</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Email</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $recruiter->user->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <label class="col-lg-4 fw-semibold text-muted">Phone</label>
                                <div class="col-lg-8">
                                    <span class="fw-bold fs-6 text-gray-800">{{ $recruiter->phone_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Company Information Card -->
            </div>
        </div>
    </div>
@endsection
