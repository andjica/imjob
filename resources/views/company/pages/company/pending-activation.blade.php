@extends('auth.template-auth')

@section('css')
    <style>
        .full-height-center {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f6f9;
            padding: 30px;
        }

        .activation-container {
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .activation-container h1 {
            font-size: 24px;
            color: #4CAF50; /* Metronic green */
            margin-bottom: 10px;
        }

        .activation-container p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }

        .activation-container img {
            max-width: 200px;
            margin: 20px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        .bg-gradient-purple {
            background: linear-gradient(90deg, #6234D5 0%, #815DDD 50%, #C15DDD 100%);
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
<div class="full-height-center">
    <div class="activation-container mb-10 ">
        <img src="{{ asset('/images/upgrade.svg') }}" alt="Awaiting Activation">
        <h1 class="text-primary">Your Company Account is Pending for Activation</h1>
        <p>
            Thank you for registering your company with us!<br><br>
            Your account is currently under review by our administrative team. Once the verification process is complete and your account is activated, you will receive a confirmation email. You will then be able to log in and start managing your activities on the platform.
        </p>

        <p>
            If you have any questions, feel free to <a href="mailto:support@example.com">contact our support team</a>.
        </p>
        <a href="{{ url('/') }}" class="cta-button bg-gradient-purple">Return to Home</a>
    </div>
</div>
@endsection
