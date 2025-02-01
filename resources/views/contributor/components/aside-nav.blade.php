<div id="kt_aside" class="aside aside-dark aside-hoverable" 
     data-kt-drawer="true" 
     data-kt-drawer-name="aside" 
     data-kt-drawer-activate="{default: true, lg: false}" 
     data-kt-drawer-overlay="true" 
     data-kt-drawer-width="{default:'200px', '300px': '250px'}" 
     data-kt-drawer-direction="start" 
     data-kt-drawer-toggle="#kt_aside_mobile_toggle">            
     <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                <!--begin::Logo-->
               <img src="{{asset('/images/logo1.png')}}" width="100px" class="img-fluid">
                <!--end::Logo-->
                <!--begin::Aside toggler-->
                <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor"></path>
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor"></path>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
                <!--end::Aside toggler-->
            </div>
            <!--end::Brand-->
            <!--begin::Aside menu-->
            <div class="aside-menu flex-column-fluid">
                <!--begin::Aside Menu-->
                <div class="hover-scroll-overlay-y my-2 py-2" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0" style="">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                    <div class="menu-item menu-accordion show {{ request()->route()->getName() && Str::startsWith(request()->route()->getName(), 'contributor-dashboard') ? 'show' : '' }}" data-kt-menu-trigger="click">
                        <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-heading text-muted text-uppercase fs-8 ls-1">Freelancer Management</span>
                                </div>
                            </div>
                            <div class="menu-link">
                                <span class="menu-icon">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                    <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="menu-title">Dashboard</span>
                                <span class="menu-arrow"></span>
                            </div>
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                              
                            <div class="menu-item menu-sub-indention menu-accordion">
                                    <a class="menu-link {{ Route::currentRouteName() === 'contributor-dashboard' ? 'active' : '' }}" 
                                    href="{{ route('contributor-dashboard') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </div>
                                <div class="menu-item menu-sub-indention menu-accordion">
                                    <a class="menu-link {{ Route::currentRouteName() === 'contributor-companies' ? 'active' : '' }}" 
                                    href="{{ route('contributor-companies') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Find Companies</span>
                                    </a>
                                </div>
                                <div class="menu-item menu-sub-indention menu-accordion">
                                    <a class="menu-link {{ Route::currentRouteName() === 'contributor-find-recruiter' ? 'active' : '' }}" 
                                    href="{{ route('contributor-find-recruiter') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Find Recruiters</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                        
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">

                            <!-- START E-commerce -->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion show">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm001.svg-->
                                        <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                            </svg>

                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">Posts</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">

                                    <div class="menu-item">
                                        <a class="menu-link {{ Route::currentRouteName() === 'contributor-post-create' ? 'active' : '' }}" href="{{asset('contributor/post/create')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Create</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link {{ Route::currentRouteName() === 'contributor-posts' ? 'active' : '' }}" href="{{asset('contributor/posts')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">All posts</span>
                                        </a>
                                    </div>
                                </div>
                            </div> 
                            <!-- START E-commerce -->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion show">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm001.svg-->
                                        <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                            </svg>

                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">Your profile</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">

                                    <div class="menu-item">
                                        <a class="menu-link {{ Route::currentRouteName() === 'contributor-edit' ? 'active' : '' }}" href="{{asset('contributoredit/edit')}}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Edit contributor</span>
                                        </a>
                                    </div>
                                    
                                </div>
                              
                                <!-- <div class="menu-sub menu-sub-accordion">

                                <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() === 'contributor-settings' ? 'active' : '' }}" href="{{asset('/contributorsettings')}}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">settings</span>
                                    </a>
                                </div>

                                </div> -->
                            </div> 
                        <!--end::Aside menu-->
                        <!--begin::Footer-->
                        <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
                            
                            <a href="{{asset('/contributor/settings')}}" class="btn btn-custom btn-primary w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="" data-bs-original-title="Make changes your profile information">
                            <i class="fa-solid fa-sliders"></i>
                             <span class="btn-label">Settings</span>
                               
                            </a>
                        </div> 
            <!--end::Footer-->
                </div>
                
            </div>
        </div>
    </div>
</div>



