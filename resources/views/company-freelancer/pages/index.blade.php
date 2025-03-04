@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Welcome user '.auth()->user()->first_name)
@section('title-dash', 'Freelancer Overview')

@section('css')
    <style>
        .objfit {
            object-fit: cover !important;
        }
    </style>
@endsection

@section('content')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
            <div class="card shadow-sm">
            <div class="card-header border-0 bg-light text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0 d-flex align-items-center">
                    <i class="fas fa-user me-2 text-primary"></i> Freelancer Information 
                </h3>
                <a href="{{asset('/company/freelancer/edit')}}" title="Edit your profile" data-bs-toggle="tooltip" data-bs-placement="left"><i class="fas fa-pen-to-square fa-1x text-primary" style="cursor: pointer;"></i></a>
            </div>
                <div class="card-body pt-9 pb-0 bg-white">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Profile Picture-->
                        <div class="me-7 mb-4">
                            @if(!empty($freelancer->profile_image) && Storage::exists('public/' . $freelancer->profile_image))
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <img src="{{ asset('storage/' . $freelancer->profile_image) }}" alt="{{ $freelancer->user->first_name }}" class="objfit">
                                </div>
                            @else
                                <img src="{{ asset('images/user-286.png') }}" alt="Default Profile Image" class="img-fluid rounded-circle objfit" width="160px">
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
                                            {{ $freelancer->user->first_name }} {{ $freelancer->user->last_name }} 
                                        </h2> 

                                        <i class="fas fa-check-circle text-primary fs-3" aria-hidden="true" title="Verified"></i>
                                    </div>

                                    <p class="text-muted fw-semibold">
                                        You have your own company <strong>{{ $freelancer->freelancerCompany->company->name }}</strong><br>
                                        From {{ $freelancer->freelancerCompany->company->country->name }}
                                    </p>
                                </div>
                                <!--end::Basic Info-->

                                <!--begin::Actions-->
                                <div class="d-flex align-items-center w-200px w-sm-200px flex-column mt-3">
                                    @if(isset($freelancer->education) && !empty($freelancer->education))
                                        <!-- Completed Profile Card -->
                                        <div class="d-flex justify-content-between w-100 mb-2">
                                            <span class="fw-semibold fs-6 text-gray-500">
                                                <i class="fas fa-check-circle text-primary me-2" aria-hidden="true"></i> Profile Completed
                                            </span>
                                            <span class="fw-bold fs-6 text-success">100%</span>
                                        </div>

                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                            <div class="bg-info rounded h-5px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <a href="{{ asset('/company/freelancer/view') }}" class="btn btn-info btn-sm w-100">
                                            <i class="fas fa-eye me-2" aria-hidden="true"></i> View Profile
                                        </a>
                                    @else
                                        <!-- Profile Completion Card -->
                                        <div class="d-flex justify-content-between w-100 mb-2">
                                            <span class="fw-semibold fs-6 text-gray-500">
                                                <i class="fas fa-user-edit text-primary me-2" aria-hidden="true"></i> Profile Completion
                                                <ul class="list-unstyled mt-2">
                                                    <li>
                                                        @if(!empty($freelancer->education))
                                                            <i class="fas fa-check-circle text-success me-2" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fas fa-times-circle text-danger me-2" aria-hidden="true"></i>
                                                        @endif
                                                        Profile Education
                                                    </li>
                                                    <li>
                                                        @if(!empty($freelancer->language_skills))
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
                                                <i class="fas fa-percentage text-info me-1" aria-hidden="true"></i> {{ $completionPercentage }}%
                                            </span>
                                        </div>
                                        
                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                            <div class="bg-info rounded h-5px" role="progressbar" style="width: {{ $completionPercentage }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <a href="{{ asset('/company/freelancer/edit') }}" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-edit me-2" aria-hidden="true"></i> Complete Profile
                                        </a>
                                    @endif
                                   
                           
                                </div>
                                <!--end::Actions-->
                            </div>

                            <!--begin::Additional Info-->
                            <div class="d-flex flex-wrap mb-4">
                                <div class="d-flex align-items-center me-5 mb-3">
                                    <i class="fas fa-tags text-muted me-2" aria-hidden="true"></i>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-500">Category:</span>
                                        <span class="fw-bold">{{ $freelancer->freelancerCompany?->company?->category?->name  ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center me-5 mb-3">
                                    <i class="fas fa-list text-muted me-2" aria-hidden="true"></i>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-500">Sub-Category:</span>
                                        <span class="fw-bold">{{ $freelancer->freelancerCompany?->company?->subCategory?->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-briefcase text-muted me-2" aria-hidden="true"></i>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-500">Experience Level:</span>
                                        <span class="fw-bold">{{ $freelancer->experience_level }}</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Additional Info-->

                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap mb-4">
                                <div class="d-flex align-items-center me-6 mb-3">
                                    <i class="fas fa-calendar-alt text-muted me-2" aria-hidden="true"></i>
                                    <div class="d-flex flex-column">
                                        <span class="fs-2 fw-bold">{{ $freelancer->availability }}</span>
                                        <span class="fw-semibold text-muted">Availability</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-birthday-cake text-muted me-2" aria-hidden="true"></i>
                                    <div class="d-flex flex-column">
                                        <span class="fs-2 fw-bold">{{ \Carbon\Carbon::parse($freelancer->birthday)->age }} years</span>
                                        <span class="fw-semibold text-muted">Age</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Stats-->

                            <!--begin::Nav Tabs-->
                            <ul class="nav nav-pills nav-pills-custom nav-pills-rounded mb-5">
                                <!-- <li class="nav-item mb-3">
                                    <a class="nav-link" href="">
                                        <i class="fas fa-user-circle me-2" aria-hidden="true"></i> Freelancer Overview
                                    </a>
                                </li> -->
                                <li class="nav-item mb-3">
                                    <a class="nav-link" href="{{asset('/company/freelancer/company/'.auth()->user()->company->id.'/details')}}">
                                        <i class="fas fa-building me-2" aria-hidden="true"></i> Your Company Overview
                                    </a>
                                </li>
                                <li class="nav-item mb-3">
                                    <a class="nav-link" href="">
                                        <i class="fas fa-briefcase me-2" aria-hidden="true"></i> Your Posted Jobs
                                    </a>
                                </li>
                                @if($freelancer->companies->count() > 0)
                                <li class="nav-item mb-3">
                                        Your connections 
                                        <div class="symbol-group symbol-hover mb-3">
                                                @foreach($freelancer->companies as $cm)
                                                {{$cm->name}}
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="Alan Warden" data-kt-initialized="1">
                                                    @if($cm->logo != null)    
                                                    <img alt="Pic" src="{{Storage::url($cm->logo)}}">
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
                        <!--end::Freelancer Info-->
                    </div>
                    <!--end::Details-->
                    <!-- <div class="card-footer bg-light d-flex justify-content-end">
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit profile
                    </a>
                   
                </div> -->
                </div>
            </div>
        </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-10">
                @if($freelancer->freelancerCompany && $freelancer->freelancerCompany->company)
                    @php
                        $company = $freelancer->freelancerCompany->company;
                    @endphp
                    <!-- Company Information Card -->
                    <div class="card card-dashed shadow-sm mb-5">
                        <div class="card-header border-0 bg-light text-white">
                            <h3 class="card-title">
                                <i class="fas fa-building me-2 text-primary"></i> Company Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Company Logo and Name -->
                            <div class="d-flex align-items-center mb-4">
                                @if(!empty($company->logo) && Storage::exists('public/' . $company->logo))
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="rounded-circle me-3" width="60" height="60">
                                @else
                                    <div class="symbol symbol-60px bg-light me-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-building fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="mb-0">{{ $company->name }}</h4>
                                    <span class="badge badge-light">{{ $company->owner_title }}</span>
                                </div>
                            </div>
                            <!-- Company Details in Three Columns -->
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-city me-2 text-dark"></i>
                                        <span>From: <strong>{{ $company->country->name }}, {{ $company->city->name ?? 'N/A' }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-tags me-2 text-muted"></i>
                                        <span>Category: <strong>{{ $company->category->name ?? 'N/A' }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-list-ul me-2 text-muted"></i>
                                        <span>Sub-Category: <strong>{{ $company->subCategory->name ?? 'N/A' }}</strong></span>
                                    </div>
                                </div>
                                <!-- Column 2 -->
                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-users me-2 text-muted"></i>
                                        <span>Employees: <strong>{{ $company->number_of_employees }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope fs-5 text-muted me-2"></i>
                                        <span>Email: {{ $company->email }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-phone fs-5 text-muted me-2"></i>
                                        <span>Phone: {{ $company->phone_number }}</span>
                                    </div>
                                </div>
                                <!-- Column 3 -->
                                <div class="col-md-4 mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-id-badge fs-5 text-secondary me-2"></i>
                                        <span>Reg No: {{ $company->registration_number }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-receipt fs-5 text-muted me-2"></i>
                                        <span>Tax No: {{ $company->tax_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!-- Optional: Action Buttons -->
                    <!--
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-primary">Edit</a>
                        <a href="#" class="btn btn-secondary">Delete</a>
                    </div>
                    -->
                </div>
                    <!-- End Company Information Card -->
                @else
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            Company information is not available. 
                            <a href="#" class="alert-link">Add Company</a>.
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
