@extends('auth.template-auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">
             
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="text-center mb-10">
                                <h1 class="text-gray-900 mb-3">Welcome to</h1>
                                <a href="">
                                        <img src="{{asset('/images/im-job-logo.svg')}}" class="img-fluid" width="150px">
                                    </a>
                                  
                                <div class="text-gray-500 fw-semibold fs-4 mt-3">
                                    Enjoy our platform <br> Here you can create an Account 
                                </div>
                            </div>
                            <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Choose Your Account Type') }}</label>
                            <div class="col-md-6">
                                <select name="role" id="role" class="form-control">
                                    @foreach ($roles as $role)
                                        @if (in_array($role->id, [2, 3, 4]))
                                            <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Explanation for Account Type -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div id="role-description" class="alert alert-info">
                                    Select an account type to see its features and purpose.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                            <div class=" text-muted text-uppercase fw-bold mb-5">or</div>
                                <a href="{{ route('auth-google') }}" class="btn btn-flex btn-light btn-lg  mb-5">
                                    <img alt="Logo" src="{{asset('/images/google-icon.svg')}}" class="h-20px me-3"> Register with Google 
                                </a>
                                
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                               
                            </div>
                        </div>
                        <div class="row mt-5">
                                <div class="text-gray-500 fw-semibold fs-4 mt-5">
                                    You already have an Account?<a href="{{asset('/login')}}" class="link-primary fw-bold"> Sign in </a>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const roleDescription = document.getElementById('role-description');

        // Mapping role IDs to descriptions
        const descriptions = {
            2: "Collaborate seamlessly with recruiters in your organization, streamline hiring processes, and achieve shared recruitment goals. Perfect for Freelancers, Agencies, or Basic companies.",
            3: "Manage recruitment tasks efficiently for a single company or handle hiring across multiple organizations. Ideal for HR professionals or external recruitment specialists.",
            4: "Join as a specialized contributor such as an embassy, airline company, ministry, or other unique entity. Contribute services or expertise to enhance platform capabilities."
        };

        // Update description based on selected role
        function updateRoleDescription() {
            const selectedRole = roleSelect.value;
            roleDescription.textContent = descriptions[selectedRole] || "Select an account type to see its features and purpose.";
        }

        // Initial description update
        updateRoleDescription();

        // Event listener for role selection
        roleSelect.addEventListener('change', updateRoleDescription);
    });
</script>
@endsection
