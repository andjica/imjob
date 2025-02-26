<!-- Security Settings Card -->
<div class="row">
    <div class="col-lg-10">
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h3>Security Settings</h3>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-3">
                <!-- Email Update Form -->
                <form action="{{ route('user-email-update', $company->user_id) }}" method="POST" id="emailUpdateForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Email Address</label>
                        <div class="col-lg-10">
                            <input type="email" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" 
                                name="email" value="{{ $company->user->email }}" />
                        
                            <span class="text-danger" id="emailEmpty"> @error('email'){{ $message }} @enderror</span>
                        
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Email</button>
                    </div>
                </form>

                <div class="separator separator-dashed my-6"></div>

                <!-- Password Change Form -->
                <form action="{{ route('user-password-update', $company->user_id) }}" method="POST" id="passwordChangeForm">
                    @csrf
                    @method('PUT')

                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Current Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control form-control-lg form-control-solid @error('current_password') is-invalid @enderror" 
                                name="current_password" placeholder="Enter your current password"/>
                            
                                <span class="text-danger" id="currentPasswordEmpty">@error('current_password'){{ $message }}  @enderror</span>
                          
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">New Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" 
                                name="password" placeholder="Enter new password"  />
                           
                                <span class="text-danger" id="newPasswordEmpty"> @error('password'){{ $message }} @enderror</span>
                           
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-lg-2 col-form-label fw-bold fs-6">Confirm New Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control form-control-lg form-control-solid @error('password_confirmation') is-invalid @enderror" 
                                name="password_confirmation" placeholder="Confirm new password" />
                            
                                <span class="text-danger" id="confirmPasswordEmpty">@error('password_confirmation'){{ $message }} @enderror</span>
                           
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>

                <div class="separator separator-dashed my-6"></div>

                <!-- Password Reset Link -->
                <div class="row mb-5">
                    <label class="col-lg-2 col-form-label fw-bold fs-6">Forgot Password?</label>
                    <div class="col-lg-10">
                        <a href="{{ route('password.request') }}" class="btn btn-link">Send Password Reset Link</a>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
</div>
