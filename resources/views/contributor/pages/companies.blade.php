@extends('contributor.template-contributor')
@section('main-title', 'Find Companies')
@section('title-dash', 'Find Companies')


@section('content')
    <div class="container m-0">

        <!-- Quick Search Form -->
        <div class="row mb-6">
            <div class="col-12">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white  p-2 mb-5"> <i class="fa fa-chevron-left text-white"></i> Back</button>
                <form action="{{ route('contributor-find-companies') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="Search by company name, country, city, address" value="{{ request('query') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        
        @if ($companies->count() == 0)
            <div class="row">
                <div class="col-lg-7">
                    <div class="card card-flush shadow-sm mb-5">
                        <div class="card-body text-center">
                            <div class="alert alert-warning d-flex align-items-center p-5 mb-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4">
                                    <!-- Metronic SVG Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path opacity="0.3"
                                            d="M12 22C17.523 22 22 17.523 22 12S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"
                                            fill="currentColor"></path>
                                        <path d="M10.75 15.5h2.5v2.5h-2.5v-2.5Zm0-10h2.5v7.5h-2.5V5.5Z" fill="currentColor">
                                        </path>
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1">No company is found</h4>
                                    <p class="mb-0">There are currently no compnanies.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
        <div class="row g-6">
                @foreach ($companies as $company)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <div class="card-toolbar">
                                <a href="{{asset('/contributor/company/'.$company->id.'/details')}}" class="btn btn-outline btn-sm btn-outline-dashed me-2 mb-2">View profile</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong>{{ $company->name }}</strong><br>
                            @if ($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }} Logo"
                                    class="h-50px rounded img-fluid">
                            @else
                                <i class="fas fa-building text-muted fa-2x"></i> <!-- Fallback Icon -->
                            @endif
                            <br>
                            <br>
                            <u>{{ $company->category->name }}</u><small>- {{ $company->subCategory->name }} - </small><br>
                            Type of company - {{ $company->companyType->name }},<i> <br>From {{ $company->city->name }}, {{ $company->country->name }}
                            </i>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
        @endif
    </div>
@endsection
