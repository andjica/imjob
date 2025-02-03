@extends('auth.template-auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="text-center mb-10">
                                <h1 class="text-gray-900 mb-3 fw-light">Sign In</h1><br>
                                <a href="">
                                    <img src="{{asset('/images/logo1.png')}}" class="img-fluid" width="100px">
                                </a>
                                <div class="text-gray-500 fw-semibold fs-4">
                                    New Here? <a href="/metronic8/vue/demo1/sign-up" class="link-primary fw-bold"> Create an Account </a>
                                </div>
                            </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="text-center">
                              
                                <div class="text-center text-muted text-uppercase fw-bold mb-5">or</div>
                                <a href="{{ route('auth-google') }}" class="btn btn-flex btn-light btn-lg  mb-5">
                                    <img alt="Logo" src="{{asset('/images/google-icon.svg')}}" class="h-20px me-3"> Login with Google 
                                </a>
                                <!-- <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                                    <img alt="Logo" src="{{asset('/images/linkedin.png')}}" class="h-20px me-3"> Continue with LinkedIn 
                                </a>
                                <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100">
                                    <img alt="Logo" src="{{asset('/images/apple-black.svg')}}" class="h-20px me-3"> Continue with Apple 
                                </a> -->
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
