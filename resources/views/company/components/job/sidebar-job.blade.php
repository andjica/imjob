    <!-- Sidebar Card -->
    <div class="card card-custom card-stretch">
        <div class="card-body px-4">
            <div class="navi navi-hover navi-active navi-link-rounded navi-bold">

                <!-- Active Jobs -->
                <div class="navi-item d-flex align-items-center justify-content-between py-3">
                    <a href="{{ asset('/company/dashboard/active/jobs') }}" 
                       class="d-flex align-items-center text-decoration-none {{ request()->is('company/dashboard/active/jobs') ? 'text-primary fw-bold' : 'text-muted text-hover-primary' }}">
                        <i class="ki-duotone ki-chart-simple-2 fs-3 me-3"></i>
                        <span>Active Jobs</span>
                    </a>
                </div>

                <!-- Inactive Jobs -->
                <div class="navi-item d-flex align-items-center justify-content-between py-3">
                    <a href="{{ asset('/company/dashboard/inactive/jobs') }}" 
                       class="d-flex align-items-center text-decoration-none {{ request()->is('company/dashboard/inactive/jobs') ? 'text-primary fw-bold' : 'text-muted text-hover-primary' }}">
                        <i class="ki-duotone ki-profile-circle fs-3 me-3"></i>
                        <span>Inactive Jobs</span>
                    </a>
                </div>

                <!-- Your Other Recruiters -->
                <div class="navi-item d-flex align-items-center justify-content-between py-3">
                    <a href="{{ asset('/company/dashboard/active/recruiters') }}" 
                       class="d-flex align-items-center text-decoration-none {{ request()->is('company/dashboard/active/recruiters') ? 'text-primary fw-bold' : 'text-muted text-hover-primary' }}">
                        <i class="ki-duotone ki-setting-2 fs-3 me-3"></i>
                        <span>Your Active Recruiters</span>
                    </a>
                </div>

                <!-- Create a New Job -->
                <div class="mt-4">
                    <a href="{{ asset('company/dashboard/job/create') }}" 
                       class="btn btn-md btn-primary text-white w-100 d-flex align-items-center justify-content-center">
                        <i class="ki-duotone ki-plus-circle fs-3 me-2"></i> Create a New Job
                    </a>
                </div>

            </div>
        </div>
    </div>

