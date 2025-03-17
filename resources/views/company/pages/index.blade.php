@extends('company.template-company')
@section('main-title', 'Welcome user '. auth()->user()->first_name)
@section('title-dash', 'Welcome')
@section('content')
    <div class="container m-0">
        <div class="row">
            <div class="col-lg-10">
                @include('alerts.errors')
                @include('alerts.success')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @include('company.components.intro-banner')
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-10">
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
                            @if (!empty($company->logo) && Storage::exists('public/' . $company->logo))
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}"
                                    class="rounded-circle me-3" width="60" height="60">
                            @else
                                <div
                                    class="symbol symbol-60px bg-light me-3 d-flex align-items-center justify-content-center">
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
                                    <span>From: <strong>{{ $company->country->name }},
                                            {{ $company->city->name ?? 'N/A' }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-tags me-2 text-muted"></i>
                                    <span>Category: <strong>{{ $company->category->name ?? 'N/A' }}</strong></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-list-ul me-2 text-muted"></i>
                                    <span>Sub-Category:
                                        <strong>{{ $company->subCategory->name ?? 'N/A' }}</strong></span>
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
            </div>
        </div>
    </div>
@endsection
