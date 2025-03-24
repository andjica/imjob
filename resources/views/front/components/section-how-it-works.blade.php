@section('css')
<style>
.responsive-img {
    width: 100%; /* Full width of the parent container */
    max-width: 150px; /* Adjust based on your design */
    height: auto; /* Maintain aspect ratio */
    object-fit: cover; /* Ensures images fit nicely */
}

/* Ensure equal height on different devices */
@media (min-width: 768px) {
    .responsive-img {
        max-width: 200px;
        height: 200px;
    }
}

@media (min-width: 1024px) {
    .responsive-img {
        max-width: 250px; 
        height: 600px;
    }
}
</style>
@endsection


<div class="mb-n10 mb-lg-n20 z-index-2 mt-10">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-17">
            <!--begin::Title-->
            <h3 class="fs-2hx text-gray-900 mb-5" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">How
                it
                Works</h3>
            <!--end::Title-->

            <!--begin::Text-->
            <div class="fs-5 text-muted fw-bold">
            Empowering
                your career with<br>
                AI technology
            </div>
            <!--end::Text-->
        </div>
        <!--end::Heading-->

        <!--begin::Row-->
        <div class="row w-100 gy-10 mb-md-20">
            <!--begin::Col-->
            <div class="col-md-4 px-5">
                <!--begin::Story-->
                <div class="text-center mb-10 mb-md-0">
                    <!--begin::Illustration-->
                    <img src="{{ asset('images/upgrade.svg') }}" class="mh-125px mb-9" alt="">
                    <!--end::Illustration-->

                    <!--begin::Heading-->
                    <div class="d-flex flex-center mb-5">
                        <!--begin::Badge-->
                        <span class="badge badge-circle badge-light-success fw-bold p-5 me-3 fs-3">1</span>
                        <!--end::Badge-->

                        <!--begin::Title-->
                        <div class="fs-5 fs-lg-3 fw-bold text-gray-900">
                        Connect with Recruiters</div>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Description-->
                    <div class="fw-semibold fs-6 fs-lg-4 text-muted">
                    Companies can easily find and collaborate with professional recruiters to streamline the hiring process, ensuring access to top talent.
                    </div>
                    <!--end::Description-->
                </div>
                <!--end::Story-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-4 px-5">
                <!--begin::Story-->
                <div class="text-center mb-10 mb-md-0">
                    <!--begin::Illustration-->
                    <img src="{{ asset('images/card-company-info.svg') }}" class="mh-125px mb-9" alt="">
                    <!--end::Illustration-->

                    <!--begin::Heading-->
                    <div class="d-flex flex-center mb-5">
                        <!--begin::Badge-->
                        <span class="badge badge-circle badge-light-success fw-bold p-5 me-3 fs-3">2</span>
                        <!--end::Badge-->

                        <!--begin::Title-->
                        <div class="fs-5 fs-lg-3 fw-bold text-gray-900">
                        Interact with Candidates </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Description-->
                    <div class="fw-semibold fs-6 fs-lg-4 text-muted">
                    Recruiters and companies manage job postings and track applications via the web app,<br> while candidates use a mobile app to apply, communicate, and stay updated on job opportunities.
                    </div>
                    <!--end::Description-->
                </div>
                <!--end::Story-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-4 px-5">
                <!--begin::Story-->
                <div class="text-center mb-10 mb-md-0">
                    <!--begin::Illustration-->
                    <img src="{{ asset('images/upgrade.svg') }}" class="mh-125px mb-9" alt="">
                    <!--end::Illustration-->

                    <!--begin::Heading-->
                    <div class="d-flex flex-center mb-5">
                        <!--begin::Badge-->
                        <span class="badge badge-circle badge-light-success fw-bold p-5 me-3 fs-3">3</span>
                        <!--end::Badge-->

                        <!--begin::Title-->
                        <div class="fs-5 fs-lg-3 fw-bold text-gray-900">
                        Hire with Confidence </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Description-->
                    <div class="fw-semibold fs-6 fs-lg-4 text-muted">
                    Streamline the entire recruitment process with AI-powered insights, ensuring the best candidate matches and an efficient hiring experience.
                    </div>
                    <!--end::Description-->
                </div>
                <!--end::Story-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Product slider-->
        <div class="tns tns-default tns-initiazlied">
            <!--begin::Slider-->
            <div class="tns-outer" id="tns1-ow">
                <div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span
                        class="current">5</span> of 4</div>
                <div id="tns1-mw" class="tns-ovh">
                    <div class="tns-inner" id="tns1-iw">
                        <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                            data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true"
                            data-tns-nav="false" data-tns-items="1" data-tns-center="false" data-tns-dots="false"
                            data-tns-prev-button="#kt_team_slider_prev1" data-tns-next-button="#kt_team_slider_next1"
                            class="  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1"
                            data-kt-initialized="1" style="transform: translate3d(-66.6667%, 0px, 0px);">
                            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10 tns-item tns-slide-cloned"
                                aria-hidden="true" tabindex="-1">
                                <img src="{{ asset('images/screen1.png') }}" class="card-rounded shadow mh-lg-650px mw-100 responsive-img"
                                    alt="">
                            </div>

                            <!--begin::Item-->
                            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10 tns-item" id="tns1-item0"
                                aria-hidden="true" tabindex="-1">
                                <img src="{{ asset('images/screen2.png') }}" class="card-rounded shadow mh-lg-650px mw-100 responsive-img"
                                    alt="">
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10 tns-item" id="tns1-item1"
                                aria-hidden="true" tabindex="-1">
                                <img src="{{ asset('images/national.jpg') }}"
                                    class="card-rounded shadow mh-lg-650px mw-100 responsive-img" alt="">
                            </div>
                            <!--end::Item-->

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Slider-->

            <!--begin::Slider button-->
            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev1" aria-controls="tns1"
                tabindex="-1" data-controls="prev">
                <i class="ki-duotone ki-left fs-2x"></i>
                <</button>
                    <!--end::Slider button-->

                    <!--begin::Slider button-->
                    <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next1" aria-controls="tns1"
                        tabindex="-1" data-controls="next">
                        <i class="ki-duotone ki-right fs-2x"></i>></button>
                    <!--end::Slider button-->
        </div>
        <!--end::Product slider-->
    </div>
    <!--end::Container-->
</div>