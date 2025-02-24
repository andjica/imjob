@extends('front.template-front')

@section('content')
    <div class="mb-0" id="home">
        <!--begin::Wrapper-->
        <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom">
            <!--begin::Header-->
            <div class="landing-header"  data-kt-sticky-name="landing-header"
                data-kt-sticky-offset="{default: '200px', lg: '300px'}" style="animation-duration: 0.3s;">
                <div class="d-flex flex-column flex-root">
                                <!--begin::Container-->
                    @include('front.components.section-banner');
                    @include('front.components.section-how-it-works');
                    @include('front.components.section-things-better');
                    @include('front.components.section-teams');
                    @include('front.components.section-price');
                    @include('front.components.section-clients-say');
                    @include('front.components.section-info');
                </div>
                <!--end::Header-->
            </div>
            <!--end::Wrapper-->
        </div>
    </div>
@endsection
