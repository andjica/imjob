@extends('front.template-front')

@section('content')
<div class="d-flex flex-column flex-root">
    <div class="mb-0" id="home">
        <!--begin::Wrapper-->
  
                    @include('front.components.section-banner');
                    <div class="landing-curve landing-dark-color mb-10 mb-lg-20">
                        <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
                        </svg>
                    </div>
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
@endsection