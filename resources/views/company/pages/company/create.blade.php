@extends('auth.template-auth')
@section('css')
<style>
    .background-image {
        background: url("{{ asset('images/card-company-info.svg') }}") no-repeat 250px;
        
        font-family: 'Arial', sans-serif;
         /* Ensure it covers the full height of the viewport */
        
   
        justify-content: center;
        align-items: center;
    }
    .border-danger
    {
        border:1px solid red !important;
    }
   
</style>
@endsection
@section('content')
<div class="container">
    <div class="row mb-20">
        <div class="col-12 mt-20">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white text-center py-4">
                <h2 class="mb-1 text-white">Welcome {{auth()->user()->first_name}}!</h2>
                <p class="text-white text-left"></p>
            </div>
        </div>
            <div class="card">
                <div class="card-header text-center py-4">
                    <h3 class="fw-bold">Before you start, complete Your Company Information</h3>
                    <p class="text-muted">Provide accurate details to set up your company dashboard.</p>
                </div>
                <div class="card-body p-4 background-image">
                    <form  id="companyForm" action="{{ route('company-dashboard-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                    <!-- Company Type -->
                    <label for="companyTypeId" class="col-lg-6 col-form-label text-end fw-bold text-uppercase">
                        <i class="fas fa-briefcase text-primary me-2"></i> Choose Your Company Type
                    </label>
                    <div class="col-lg-6 form-label fw-semibold fs-6">
                        <select name="companyTypeId" id="companyTypeId" 
                            class="form-control border-primary text-dark fw-semibold @error('companyTypeId') is-invalid @enderror">
                            <option value="" class="text-muted">Select your type of company</option>
                            @foreach ($companyTypes as $ctype)
                                <option value="{{ $ctype->id }}" 
                                    {{ old('companyTypeId') == $ctype->id ? 'selected' : '' }}>{{ $ctype->name }}</option>
                            @endforeach
                        </select>
                       
                            <span class="text-danger fw-bold" id="companyTypeEmpty"> @error('companyTypeId'){{ $message }}@enderror</span>
                        
                    </div>
                </div>
                        <div class="row mb-3">
                            <!-- Owner Title -->
                            <label for="ownerTitle" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-user-tie text-primary me-2"></i> Owner Title
                            </label>
                            <div class="col-lg-6">
                                <select name="ownerTitle" id="ownerTitle" 
                                    class="form-control @error('ownerTitle') is-invalid @enderror">
                                    <option value="">Select a title</option>
                                    <option value="CEO" {{ old('ownerTitle') == 'CEO' ? 'selected' : '' }}>CEO</option>
                                    <option value="Main Director" {{ old('ownerTitle') == 'Main Director' ? 'selected' : '' }}>Main Director</option>
                                    <option value="Owner" {{ old('ownerTitle') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                </select>
                                
                                    <span class="text-danger" id="ownerTitleEmpty">@error('ownerTitle'){{ $message }}@enderror</span>
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Company Name -->
                            <label for="name" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-building text-primary me-2"></i> Company Name
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="companyName" id="companyName" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="Enter your company name" value="{{ old('name') }}">
                                
                                    <span class="text-danger" id="companyNameEmpty">@error('name'){{ $message }} @enderror</span>
                              
                            </div>
                        </div>
                        <div class="row mb-3" id="categoryRow">
                    <label for="categoryId" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-globe text-primary me-2"></i> Category
                    </label>
                    <div class="col-lg-6">
                        <select name="categoryId" id="categoryId" data-control="select2"
                            class="form-control @error('categoryId') is-invalid @enderror">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                        </select>
                        <span class="text-danger" id="categoryEmpty"></span>
                    </div>
                </div>
            
                 <div class="row mb-3" id="subCategoryRow">
                            <label for="subCategoryId" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-globe text-primary me-2"></i> Sub Category
                            </label>
                            <div class="col-lg-6">
                                <select name="subCategoryId" id="subCategoryId" data-control="select2"
                                    class="form-control @error('subCategoryId') is-invalid @enderror">
                                    <option value="">Select a sub category</option>
                                </select>
                                <span class="text-danger" id="subCategoryEmpty"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <!-- Registration Number -->
                            <label for="registrationNumber" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-id-card text-primary me-2"></i> Registration Number
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="registrationNumber" id="registrationNumber" 
                                    class="form-control @error('registrationNumber') is-invalid @enderror" 
                                    placeholder="Enter registration number" value="{{ old('registrationNumber') }}">
                                
                                    <span class="text-danger" id="registrationNumberEmpty">@error('registrationNumber'){{ $message }} @enderror</span>
                               
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Tax Number -->
                            <label for="taxNumber" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-receipt text-primary me-2"></i> Tax Number
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="taxNumber" id="taxNumber" 
                                    class="form-control @error('taxNumber') is-invalid @enderror" 
                                    placeholder="Enter tax number" value="{{ old('taxNumber') }}">
    
                                    <span class="text-danger" id="taxNumberEmpty"> @error('taxNumber'){{ $message }} @enderror</span>
                               
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Country -->
                            <label for="countryId" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-globe text-primary me-2"></i> Country
                            </label>
                            <div class="col-lg-6">
                                <select name="countryId" id="countryId" data-control="select2" 
                                    class="form-control @error('countryId') is-invalid @enderror">
                                    <option value="">Select a country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('countryId') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                               
                                <span class="text-danger" id="countryIdEmpty"> @error('countryId'){{ $message }} @enderror</span>
                               
                            </div>
                        </div>
                       
                        <div class="row mb-3" id="cityRow">
                            <label for="cityId" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-globe text-primary me-2"></i> City
                            </label>
                            <div class="col-lg-6">
                                <select name="cityId" id="cityId" data-control="select2"
                                    class="form-control @error('cityId') is-invalid @enderror">
                                    <option value="">Select a city</option>
                                </select>
                                <span class="text-danger" id="cityEmpty"></span>
                            </div>
                        </div>
                        <div class="row mb-3" id="addressRow">
                            <label for="address" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i> Address
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="address" id="address" 
                                    class="form-control @error('address') is-invalid @enderror" 
                                    placeholder="Enter your address" value="{{ old('address') }}">
                                <span class="text-danger" id="addressEmpty"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                                <!-- Phone Number -->
                                <label for="phoneNumber" class="col-lg-6 col-form-label text-end fw-bold">
                                    <i class="fas fa-phone text-primary me-2"></i> Phone Number
                                </label>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-text border-0 border-end border-2 border-gray-300" id="phoneCodeDisplay">+XXX</span>
                                        <input type="text" name="phoneNumber" id="phoneNumber" 
                                            class="form-control @error('phoneNumber') is-invalid @enderror" 
                                            placeholder="Enter phone number" value="{{ old('phoneNumber') }}" 
                                            aria-describedby="phoneCodeDisplay">
                                    </div>
                                    <span class="text-danger" id="phoneempty">@error('phoneNumber') {{ $message }} @enderror</span>
                                </div>
                        </div>


                        <div class="row mb-3">
                            <!-- Email -->
                            <label for="email" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-envelope text-primary me-2"></i> Email Address of company
                            </label>
                            <div class="col-lg-6">
                                <input type="email" name="email" id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Enter email address" value="{{ old('email') }}">
                               
                                    <span class="text-danger" id="emailEmpty"> @error('email'){{ $message }} @enderror</span>
                               
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Logo -->
                            <label for="logo" class="col-lg-6 col-form-label text-end fw-bold">
                                <i class="fas fa-image text-primary me-2"></i> Upload Logo (optional)
                            </label>
                            <div class="col-lg-6">
                                <input type="file" name="logo" id="logo" 
                                    class="form-control @error('logo') is-invalid @enderror">
                              
                                    <span class="text-danger" id="logoEmpty">  @error('logo'){{ $message }} @enderror</span>
                               
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i> Submit Company Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('/js/custom/create-company-validation.js')}}"></script>
@endsection