<div class="card mb-5 mb-xl-8">
    <!--begin::Body-->
        <div class="card-body pt-15 px-0">
            <!--begin::Member-->
            <div class="d-flex flex-column text-center mb-9 px-9">
                <!--begin::Photo-->
                
                @if (!empty($recruiter->profile_image) && Storage::exists('public/' . $recruiter->profile_image))
                  <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('storage/' . $recruiter->profile_image) }}"
                                alt="{{ $recruiter->user->first_name }}" class="objfit">
                        </div>
                    @else
                        <img src="{{ asset('images/user-286.png') }}" alt="Default Profile Image"
                            class="img-fluid rounded-circle objfit" width="160px">
                    @endif
                
                <!--end::Photo-->

                <!--begin::Info-->
                <div class="text-center">
                    <!--begin::Name-->

                    <a href="" class="text-gray-800 fw-bold text-hover-primary fs-4">Recruiter <br>{{$recruiter->user->first_name}} {{$recruiter->user->last_name}}</a>
                    <!--end::Name-->

                    <!--begin::Position-->    
                    <span class="text-muted d-block fw-semibold">{{$recruiter->city->name}}, {{$recruiter->country->name}}</span>      
                    <small>
                        Current works for:  <br>
                        @foreach ($recruiter->activeCompanies as $ractive)
                        {{ $ractive->name }} (From:
                        {{ $ractive->pivot->from_date }})
                        <br>
                    @endforeach</small>
                    <!--end::Position-->             
                </div>
                <!--end::Info-->                
            </div>
            <!--end::Member-->

            <!--begin::Row-->
            <div class="row px-9 mb-4">                 
                <!--begin::Col-->
                <div class="col-md-4 text-center">                          
                    <div class="text-gray-800 fw-bold fs-3">
                        <span class="m-0 counted" data-kt-countup="true" data-kt-countup-value="642" data-kt-initialized="1">{{$jobs->count()}}</span> 
                    </div>
                    
                    <span class="text-gray-500 fs-8 d-block fw-bold">Active jobs</span>                          
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-md-5 text-center">                          
                    <div class="text-gray-800 fw-bold fs-3">
                        <span class="m-0 counted" data-kt-countup="true" data-kt-countup-value="24" data-kt-initialized="1">{{$recruiter->activeCompanies->count()}}</span> 
                    </div>
                    
                    <span class="text-gray-500 fs-8 d-block fw-bold">CONNECTIONS</span>                          
                </div>
                <!--end::Col-->

             
            </div>
            <!--end::Row--> 
            
            <!--begin::Navbar-->
            <div class="m-0">
                <!--begin::Navs-->
                <ul class="nav nav-pills nav-pills-custom flex-column border-transparent fs-5 fw-bold">
                                        <!--begin::Nav item-->
                        <li class="nav-item mt-5">
                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0 active" href="/metronic8/demo1/pages/social/feeds.html">
                                <i class="ki-duotone ki-row-horizontal fs-3 text-muted me-3"><span class="path1"></span><span class="path2"></span></i>                            

                                Active Jobs by {{$recruiter->user->first_name}}
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                <!--end::Bullet-->
                            </a>
                        </li>
                        <!--end::Nav item-->
                                        <!--begin::Nav item-->
                        <li class="nav-item mt-5">
                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0 " href="/metronic8/demo1/pages/social/activity.html">
                                <i class="ki-duotone ki-chart-simple-2 fs-3 text-muted me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                            

                                Activity
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                <!--end::Bullet-->
                            </a>
                        </li>
                        <!--end::Nav item-->
                                        <!--begin::Nav item-->
                        <li class="nav-item mt-5">
                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0 " href="/metronic8/demo1/pages/social/followers.html">
                                <i class="ki-duotone ki-profile-circle fs-3 text-muted me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>                            

                                Followers
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                <!--end::Bullet-->
                            </a>
                        </li>
                        <!--end::Nav item-->
                                        <!--begin::Nav item-->
                        <li class="nav-item mt-5">
                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0 " href="/metronic8/demo1/pages/social/settings.html">
                                <i class="ki-duotone ki-setting-2 fs-3 text-muted me-3"><span class="path1"></span><span class="path2"></span></i>                            

                                Settings
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                <!--end::Bullet-->
                            </a>
                        </li>
                        <!--end::Nav item-->
                                </ul>
                <!--begin::Navs-->            
            </div>
            <!--end::Navbar-->        
        </div>
        <!--end::Body-->
    </div>        


