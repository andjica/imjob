@extends('front.template-front')

@section('content')
    <!--begin::Content-->
    <div class="card">
        <!--begin::Body-->
        <div class="card-body p-lg-12">
            <div class="col-md-6 pe-lg-10">
                <!--begin::Form-->
                <form action="{{asset('/')}}" method="POST" class="form mb-15 fv-plugins-bootstrap5 fv-plugins-framework">
                    <h1 class="fw-bold text-gray-900 mb-9">Send Us Email</h1>
                    @csrf
                    <!--begin::Input group-->
                    <div class="row mb-5">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold mb-2">Name</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter your name">
                            <!--end::Input-->
                            <span id="name-error"></span>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                            <!--end::Label-->
                            <label class="fs-5 fw-semibold mb-2">Email</label>
                            <!--end::Label-->

                            <!--end::Input-->
                            <input type="text" class="form-control form-control-sm" placeholder="Enter your email" id="email" name="email">
                            <!--end::Input-->
                            <span id="email-error"></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-5 fv-row">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold mb-2">Subject</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control form-control-sm" placeholder="Enter subject" id="subject" name="subject">
                        <!--end::Input-->
                        <span id="subject-error"></span>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-10 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2">Message</label>

                        <textarea class="form-control form-control-sm" rows="6" id="message" name="message"
                            placeholder="">        </textarea>
                            <span id="message-error"></span>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Submit-->
                    <button type="submit" class="btn btn-primary" id="submit_button">

                        <!--begin::Indicator label-->
                        <span class="indicator-label">
                            Send Feedback</span>
                        <!--end::Indicator label-->

                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!--end::Indicator progress--> </button>
                    <!--end::Submit-->
                </form>
                <!--end::Form-->
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::content-->
@endsection

@section('js')
    <script src="{{asset('/js/custom/contact-us-validation.js')}}"></script>
@endsection