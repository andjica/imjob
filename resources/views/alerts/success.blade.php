@if (session('success'))
<div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row p-5 mb-10">
    <!--begin::Icon-->
    <span class="svg-icon svg-icon-2hx svg-icon-success me-4 mb-5 mb-sm-0">
        <!-- Metronic's Success Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
            <path d="M10.5 15.5L7 12L8.5 10.5L10.5 12.5L15.5 7.5L17 9L10.5 15.5Z" fill="currentColor"></path>
        </svg>
    </span>
    <!--end::Icon-->

    <!--begin::Content-->
    <div class="d-flex flex-column text-success pe-0 pe-sm-10">
        <h4 class="mb-2">Success</h4>
        <span>{{ session('success') }}</span>
    </div>
    <!--end::Content-->

    <!--begin::Close-->
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <!--end::Close-->
</div>
@endif
