@extends('company-freelancer.template-company-freelancer')

@section('title-dash', 'Company detail')

@section('content')
<div class="container m-0">
<div class="row mt-5">
            <div class="col-lg-10">
                
                    <!-- Company Information Card -->
                    <div class="card card-custom shadow-sm">
                        <div class="card-header border-0 bg-light text-white">
                            <h3 class="card-title">
                                <i class="fas fa-building me-2 text-white"></i> Company Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Company Logo and Name -->
                            <div class="d-flex align-items-center mb-4">
                                @if(!empty($company->logo) && Storage::exists('public/' . $company->logo))
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="rounded-circle me-3" width="60" height="60">
                                @else
                                    <div class="symbol symbol-60px bg-light me-3">
                                        <i class="fas fa-building fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="mb-0">{{ $company->name }}</h4>
                                    <span class="badge badge-light">{{ $company->owner_title }}</span>
                                </div>
                            </div>
                            <!-- Company Details -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt fs-5 text-info me-3"></i>
                                        <span>{{ $company->address }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope fs-5 text-success me-3"></i>
                                        <span>{{ $company->email }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-phone fs-5 text-warning me-3"></i>
                                        <span>{{ $company->phone_number }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-id-badge fs-5 text-secondary me-3"></i>
                                        <span>Reg No: {{ $company->registration_number }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-receipt fs-5 text-muted me-3"></i>
                                        <span>Tax No: {{ $company->tax_number }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">
                                            <i class="fas fa-tags me-2"></i>
                                            Category: <strong>{{ $company->category->name ?? 'N/A' }}</strong>
                                        </span>
                                        <span class="text-muted">
                                            <i class="fas fa-list-ul me-2"></i>
                                            Sub-Category: <strong>{{ $company->subCategory->name ?? 'N/A' }}</strong>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">
                                            <i class="fas fa-users me-2"></i>
                                            Employees: <strong>{{ $company->number_of_employees }}</strong>
                                        </span>
                                        <span class="text-muted">
                                            <i class="fas fa-city me-2"></i>
                                            City: <strong>{{ $company->city->name ?? 'N/A' }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="card-footer bg-light d-flex justify-content-end">
                            <a href="#" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-edit me-1"></i> Edit Company
                            </a>
                            <a href="#" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye me-1"></i> View Company
                            </a>
                        </div>
                    </div>
                    <!-- End Company Information Card -->
                
            </div>
        </div>
</div>
@endsection


