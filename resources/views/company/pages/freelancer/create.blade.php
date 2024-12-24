@extends('auth.template-auth')
@section('css')
<style>
    .background-image {
        background: url("{{ asset('images/card-category-info.svg') }}") no-repeat 250px;
        
        font-family: 'Arial', sans-serif;
         /* Ensure it covers the full height of the viewport */
        
   
        justify-content: center;
        align-items: center;
    }
    .border-danger
    {
        border:1px solid red;
    }
   
</style>
@endsection
@section('content')
<div class="container">
    <div class="row mb-20">
        <div class="col-12 mt-20">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white text-center py-4">
                <h2 class="mb-1 text-white">One more step :) and you are finish..</h2>
                <p class="text-white text-left"></p>
            </div>
        </div>
            <div class="card">
                <div class="card-header text-center py-4">
                    <h3 class="fw-bold">Complete your freelancer information</h3>
                    <p class="text-muted">Provide accurate details to set up your dashboard.</p>
                </div>
            <div class="card-body p-4 background-image">
                <form action="{{route('company-freelancer-recruiter-store')}}" method="post" id="recruiterForm" enctype="multipart/form-data">
                @csrf
                <h2 class="text-center">Freelancer Information</h2>
                <div class="row mb-3">
                    <!-- Recruiter Information -->
                    <label for="recruiterInformation" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-user text-primary me-2"></i> Recruiter Information
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="recruiterInformation" id="recruiterInformation" 
                            class="form-control @error('recruiterInformation') is-invalid @enderror" 
                            placeholder="Enter recruiter information" value="{{ old('recruiterInformation') }}">
                        <span class="text-danger" id="recruiterInformationEmpty">@error('recruiterInformation'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Birthday -->
                    <label for="birthday" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-calendar-alt text-primary me-2"></i> Birthday
                    </label>
                    <div class="col-lg-6">
                        <input type="date" name="birthday" id="birthday" 
                            class="form-control @error('birthday') is-invalid @enderror" 
                            value="{{ old('birthday') }}">
                        <span class="text-danger" id="birthdayEmpty">@error('birthday'){{ $message }}@enderror</span>
                    </div>
                </div>
               
                <div class="row mb-3">
                    <!-- Profile Image -->
                    <label for="profileImage" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-image text-primary me-2"></i> Profile Image
                    </label>
                    <div class="col-lg-6">
                        <input type="file" name="profileImage" id="profileImage" 
                            class="form-control @error('profileImage') is-invalid @enderror">
                        <span class="text-danger" id="profileImageEmpty">@error('profileImage'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Experience Level -->
                    <label for="experienceLevel" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-chart-line text-primary me-2"></i> Experience Level
                    </label>
                    <div class="col-lg-6">
                        <select name="experienceLevel" id="experienceLevel" 
                            class="form-control @error('experienceLevel') is-invalid @enderror">
                            <option value="">Select experience level</option>
                            <option value="junior">Junior</option>
                            <option value="mid">Mid</option>
                            <option value="senior">Senior</option>
                        </select>
                        <span class="text-danger" id="experienceLevelEmpty">@error('experienceLevel'){{ $message }}@enderror</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Availability -->
                    <label for="availability" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-clock text-primary me-2"></i> Availability
                    </label>
                    <div class="col-lg-6">
                    <select name="availability" id="availability" 
                    class="form-control @error('availability') is-invalid @enderror">
                    <option value="">Select Availability</option>
                                <option value="morning">Morning (8 AM - 12 PM)</option>
                                <option value="afternoon">Afternoon (12 PM - 5 PM)</option>
                                <option value="evening">Evening (5 PM - 9 PM)</option>
                                <option value="full_day">Full Day</option>
                            </select>
                        <span class="text-danger" id="availabilityEmpty">@error('availability'){{ $message }}@enderror</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- Recruiter Information -->
                    <label for="phoneNumber" class="col-lg-6 col-form-label text-end fw-bold">
                        <i class="fas fa-user text-primary me-2"></i>One more phone number
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="phoneNumber" id="phoneNumber" 
                            class="form-control @error('phoneNumber') is-invalid @enderror" 
                            placeholder="Enter recruiter information" value="{{ old('phoneNumber') }}">
                        <span class="text-danger" id="phoneNumberEmpty">@error('phoneNumber'){{ $message }}@enderror</span>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-2"></i> Submit Your personal freelancer information
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
<script src="{{asset('/js/custom/create-freelancer-validation.js')}}"></script>
@endsection