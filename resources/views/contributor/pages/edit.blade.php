@extends('contributor.template-contributor')
@section('main-title', 'Edit contributor')
@section('title-dash', 'Edit')


@section('content')
    <div class="container m-0">
    <div class="row">
            <div class="col-lg-10">
            @include('alerts.success')
            @include('alerts.errors')
            </div>
    </div>
        <div class="row">
            <div class="btn-back">
                <button onclick="window.history.back()" class="btn btn-sm bg-linear-pink text-white p-2 mb-5"> <i
                        class="fa fa-chevron-left text-white"></i> Back</button>
            </div>
            <div class="col-lg-10">
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Edit Contributor</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-3">
                        <form action="{{asset('/contributor/update')}}" method="POST" id="contributorForm">
                            @csrf
                            <!-- Contributor Full Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Contributor name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name"
                                    value="{{ $contributor->name }}"
                                    placeholder="Enter full name">
                                <div class="text-danger" id="nameEmpty">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ $contributor->email }}"
                                    placeholder="Enter email">
                                <div class="text-danger" id="emailEmpty"> @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <!-- Contributor Type -->
                            <div class="row mb-5">
                                <label class="col-lg-2 col-form-label fw-bold fs-6 required">Contributor type:</label>
                                <div class="col-lg-8">
                                <select name="contributorTypeId" id="contributorTypeId" data-control="select2"
                                    class="form-control form-control-solid @error('contributorTypeId') is-invalid @enderror">
                                    <option value="{{$contributor->contributorType->id}}">{{$contributor->contributorType->name}}</option>
                                    @foreach ($contributorTypes as $contributorType)
                                        <option value="{{ $contributorType->id }}"
                                            {{ old('contributorTypeId', $contributor->contributorType->id) == $contributorType->id ? 'selected' : '' }}
                                            @if (trim($contributorType->name) === 'Other(Specify)') data-is-other="true" @endif>
                                            {{ $contributorType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                    <span class="text-danger" id="contributorTypeIdEmpty">
                                        @error('contributorTypeId')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <!-- Custom Contributor Type -->
                            <div class="row mb-5 {{ $contributor->contributorType->name === 'Other(Specify)' || $contributor->custom_contributor_type ? '' : 'd-none' }}" id="customContributorTypeWrapper">
                                <label class="col-lg-2 col-form-label fw-bold fs-6">Specify your type:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="customContributorType" id="customContributorType"
                                        value="{{ old('customContributorType', $contributor->custom_contributor_type) }}"
                                        class="form-control form-control-solid @error('customContributorType') is-invalid @enderror">
                                    <span class="text-danger" id="customContributorTypeEmpty">@error('customContributorType'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <!-- Country -->
                            <div class="row mb-5">
                                <label class="col-lg-2 col-form-label fw-bold fs-6 required">Country:</label>
                                <div class="col-lg-8">
                                    <select name="countryId" id="countryId" data-control="select2"
                                        class="form-control form-control-solid @error('countryId') is-invalid @enderror">
                                        <option value="">Select a Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('countryId', $contributor->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="countryIdEmpty">
                                        @error('countryId')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <!-- City -->
                            <div class="row mb-5">
                                <label class="col-lg-2 col-form-label fw-bold fs-6 required">City:</label>
                                <div class="col-lg-8">
                                    <select name="cityId" id="cityId" data-control="select2"
                                        class="form-control form-control-solid @error('cityId') is-invalid @enderror">
                                        <option value="">Select a City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('cityId', $contributor->city_id) == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="cityIdEmpty">
                                        @error('cityId')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    Edit Profile
                                </button>
                            </div>
                            <div class="spinner-border text-primary d-none" role="status" id="loading"
                                style="position: absolute; top: 50%; left: 50%; z-index: 1000;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('/js/custom/country-city-ajax.js') }}"></script>
<script src="{{asset('/js/custom/contributor/create-profile.js')}}"></script>

@endsection
