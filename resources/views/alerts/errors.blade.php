@if (session('error'))
<div class="alert alert-danger d-flex align-items-center p-5 mb-10">
    <!--begin::Icon-->
    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.25" d="M11.5 4L20 20H3L11.5 4Z" fill="red" />
            <path d="M11.5 14.5C10.67 14.5 10 13.83 10 13C10 12.17 10.67 11.5 11.5 11.5C12.33 11.5 13 12.17 13 13C13 13.83 12.33 14.5 11.5 14.5ZM11.5 7.5C10.67 7.5 10 8.17 10 9V10H13V9C13 8.17 12.33 7.5 11.5 7.5Z" fill="red" />
        </svg>
    </span>
    <!--end::Icon-->
    <!--begin::Content-->
    <div class="d-flex flex-column">
        <h4 class="mb-1 text-danger">Error</h4>
        <span>{{ session('error') }}</span>
    </div>
    <!--end::Content-->
</div>
@endif