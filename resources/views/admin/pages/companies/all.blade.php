@extends('admin.template-dashboard')

@section('content')
@section('title-dash', 'Recruiters')
     <div class="container">
        <div class="row">
            <div class="col-lg-7">
                @include('alerts.success')
                @include('alerts.errors')
                @if($companies->count() == 0)
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
                                    <h4 class="mb-1">No Companies Found</h4>
                                    <p class="mb-0">There are currently no active companies in the system. Please add new companies or adjust your search criteria.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <!--begin::Contacts-->
                <div class="card card-flush" id="kt_contacts_list">
                    <!--begin::Card header-->
                    <div class="card-header pt-7" id="kt_contacts_list_header">
                        <!--begin::Form-->
                        @if (request('search'))
                            <form method="GET" action="{{ route('admin-dashboard-companies') }}">
                                <button type="submit" class="btn btn-primary mb-3 btn-sm"><i class="fa-solid fa-chevron-left"></i> Back to All Companies</button>
                            </form>
                        @endif
                        <form action="{{route('admin-dashboard-companies')}}" method="GET" class="d-flex align-items-center position-relative w-100 m-0" autocomplete="off">
                            <!--begin::Icon-->

                            <i class="fas fa-search fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"><span class="path1"></span><span class="path2"></span></i>            <!--end::Icon-->

                            <!--begin::Input-->
                            <input type="text" id="searchUser"class="form-control form-control-solid ps-13" name="search" value="" placeholder="Search company">
                            <!--end::Input-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-5" id="kt_contacts_list_body">
                        <!--begin::List-->
                        <div class="row">
                        <div class="card  card-xl-stretch mb-5 mb-xl-8">
                                <!--begin::Header-->
                                <div class="card-header align-items-center border-0 mt-3">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="fw-bold text-gray-900 fs-3">Your active companies</span>
                                        <span class="text-gray-500 mt-2 fw-semibold fs-6"> @if ($countActiveCompanies > 100)
                                            <span class="badge bg-success">More than 100 Companies</span>
                                        @else
                                        Current number of active Companies is <span class="badge bg-info">{{ $countActiveCompanies}} </span>
                                        @endif</span>
                                    </h3>
                                    <div class="card-toolbar">
                                        <!--begin::Menu-->
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="ki-duotone ki-category fs-6 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>            </button>
                                        
                            <!--begin::Menu 2-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator mb-3 opacity-75"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        New Ticket
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        New Customer
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                    <!--begin::Menu item-->
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-title">New Group</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--end::Menu item-->

                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Admin Group
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Staff Group
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->            
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Member Group
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        New Contact
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                            <!--end::Menu 2-->
                                        <!--end::Menu-->
                                    </div>
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body pt-5">
                                    <hr>
                                        @foreach($companies as $company)             
                                        <!--begin::Item-->
                                        <div class="d-flex mb-7">
                                            <!--begin::Symbol-->
                                            <div class="symbol  flex-shrink-0 me-4">
                                                @if($company->logo == null)
                                                <i class="fas fa-circle-question text-muted fa-5x"></i>
                                                @else
                                                <img src="{{asset('storage/'.$company->logo)}}"  alt="{{$company->name}} logo" width="120px" class="img-fluid">
                                                @endif                      
                                            </div>
                                            <!--end::Symbol-->

                                            <!--begin::Section-->
                                            <div class="d-flex align-items-center flex-wrap flex-grow-1 mt-n2 mt-lg-n1">
                                                <!--begin::Title-->
                                                <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pe-3">
                                                    <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold"><h3>{{$company->name}}</h3></a>
                                                    Company type {{$company->companyType->name}}
                                                    <span class="text-gray-500 fw-semibold fs-7 my-1">From {{$company->country->name}}</span>

                                                    <span class="text-gray-500 fw-semibold fs-7">
                                                        By: <a href="#" class="text-primary fw-bold">{{$company->owner_title}} Created by {{$company->user->first_name}} {{$company->user->last_name}}</a>
                                                    </span>
                                                    @if($company->companyType->name == "Freelancer")
                                                    Company by main person {{$company->freelancerCompany->recruiter->user->first_name}}{{$company->freelancerCompany->recruiter->user->last_name}}
                                                    @endif
                                                </div>
                                                <!--end::Title-->

                                                <!--begin::Info-->
                                                <div class="text-end py-lg-0 py-2">
                                                    <span class="text-gray-800 fw-bolder fs-3"></span>

                                                    <span class="text-gray-500 fs-7 fw-semibold d-block"></span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Item-->
                                        @endforeach
                                        {{$companies->links()}}
                                    
                                
                                </div>
                                <!--end::Body-->
                            </div>
                        
                        </div>

                <!--end::List-->

            <!--end::Card body-->

                </div>

        <!--end::Contacts-->
            </div>
            @endif
            </div>
       <div class="col-lg-5">
        <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Company Registration Notifications</h4>
                </div>
                <div class="card-body">
                    @if($inactiveCompanies->count() == 0)
                    <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                    <!-- Metronic SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path opacity="0.3" d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z" fill="currentColor"/>
                                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor"/>
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">No requestiest from companies</h4>
                                    <p class="mb-0">There are currently no new requestiest for activation companies in the system.</p>
                                </div>
                            </div>
                    @else
                    @foreach ($inactiveCompanies->take(7) as $company)
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $company->name }}</strong><br>
                                <span>{{ $company->user->email }}</span>
                            </div>
                            <div class="d-flex">
                                <!-- Accept Button -->
                                @include('admin.components.popup-modals.company-accept')
                                <!-- Reject Button -->
                                @include('admin.components.popup-modals.company-reject')
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
                <div class="card-footer text-end">
                <a href="{{asset('/admin/dashboard/notifications')}}" class="btn btn-link text-muted">
                    <i class="fa fa-arrow-right"></i> View More notifications
                </a>
            </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
   <script src="{{asset('/assets/custom/user/users-table.js')}}"></script>
@endsection

