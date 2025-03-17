@isset($recruiter)
<div class="card">
            <div class="card-body pt-15 px-0">
                <div class="d-flex flex-column text-center mb-9 px-9">
                    <!-- Profile Image -->
                    @if (!empty($recruiter->profile_image) && Storage::exists('public/' . $recruiter->profile_image))
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('storage/' . $recruiter->profile_image) }}"
                                alt="{{ $recruiter->user->first_name }}" class="objfit">
                        </div>
                    @else
                        <img src="{{ asset('images/user-286.png') }}" alt="Default Profile Image"
                            class="img-fluid rounded-circle objfit" width="160px">
                    @endif

                    <!-- Recruiter Name & Location -->
                    <div class="text-center mt-3">
                        <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-4">
                            Recruiter <br>{{ $recruiter->user->first_name }} {{ $recruiter->user->last_name }}
                        </a>
                        <span class="text-muted d-block fw-semibold">
                            {{ optional($recruiter->city)->name }}, {{ optional($recruiter->country)->name }}
                        </span>  
                    </div>

                    <!-- Current Employment -->
                    <small class="mt-3 d-block">
                        Current works for: <br>
                        @forelse ($recruiter->activeCompanies as $ractive)
                            {{ $ractive->name }} (From: {{ $ractive->pivot->from_date }})<br>
                        @empty
                            <span class="text-muted">No active company</span>
                        @endforelse
                    </small>
                </div>

                <!-- Recruiter Stats -->
                <div class="row px-9 mb-4 text-center">
                    <div class="col-md-6">
                        <div class="text-gray-800 fw-bold fs-3">
                            <span class="m-0 counted" data-kt-countup="true" data-kt-countup-value="642" data-kt-initialized="1">
                                
                            {{ $recruiter->jobsForLoggedCompany()->count() }}

                            </span> 
                        </div>
                        <span class="text-gray-500 fs-8 d-block fw-bold">Active Jobs</span>                          
                    </div>

                    <div class="col-md-6">
                        <div class="text-gray-800 fw-bold fs-3">
                            <span class="m-0 counted" data-kt-countup="true" data-kt-countup-value="24" data-kt-initialized="1">
                                {{ $recruiter->activeCompanies->count() }}
                            </span> 
                        </div>
                        <span class="text-gray-500 fs-8 d-block fw-bold">Connections</span>                          
                    </div>
                   
                </div>
                <ul class="nav nav-pills nav-pills-custom flex-column border-transparent fs-5 fw-bold">

                <li class="nav-item">
                    <a class="nav-link text-muted text-active-primary ps-4 border-0 active" href="{{asset('/company/dashboard/active/jobs/by/recruiter/'.$recruiter->id)}}">
                        <i class="ki-duotone ki-row-horizontal fs-3 text-muted me-3"></i>                            
                        Active Jobs by {{ $recruiter->user->first_name }}
                    </a>
                </li>
                </ul>

            </div>
        </div>
@endisset