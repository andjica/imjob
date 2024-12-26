@extends('admin.template-dashboard')

@section('content')
@section('title-dash', 'Notifications')
     <div class="container">
        <div class="row">
            <div class="col-lg-10">
                @include('alerts.success')
                @include('alerts.errors')
            
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
                        <!-- Loop through the inactive companies -->
                        @foreach ($inactiveCompanies as $company)
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <strong>{{ $company->name }}</strong><br>
                                    <span>{{ $company->user->email }}</span>
                                    <hr>
                                    <span class="text-muted fs-7 fw-bold justify-content-right">{{ $company->created_at->diffForHumans() }}</span>

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
                    <!-- <div class="card-footer text-end">
                    <a href="" class="btn btn-link text-muted">
                        <i class="fa fa-arrow-right"></i> View More notifications
                    </a>
                </div> -->
                </div>

            </div>
              
            </div>
        </div>
     </div>
@endsection

