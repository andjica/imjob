@extends('auth.template-auth')

@section('css')
<style>
    .card-header {
        min-height: auto !important;
        background-color: #f4f5fa; /* Adjust as per Metronic's palette */
        border-bottom: 2px solid #e2e5ec;
    }
    .card-header h3 {
        font-weight: 600;
        font-size: 1.5rem;
        color: #3f4254; /* Metronic's primary text color */
    }
    .card-body {
        background-color: #fff; /* Light background for better readability */
        padding: 2rem;
        border-radius: 0.35rem;
    }
    .btn-link {
        color: #3699ff; /* Metronic's link color */
        font-weight: 500;
    }
    .btn-link:hover {
        text-decoration: underline;
        color: #1e73be; /* Darker hover effect */
    }
    .alert-success {
        background-color: #c9f7f5;
        color: #1bc5bd;
        border-color: #c9f7f5;
    }
</style>
@endsection

@section('content')
<div class="container mt-20">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center py-4">
                    <h3>{{ __('Verify Your Email Address') }}</h3>
                </div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <p class="mb-4">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>
                    <p>
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                {{ __('click here to request another') }}
                            </button>.
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
