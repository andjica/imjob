<!-- resources/views/company/waiting_activation.blade.php -->

@extends('auth.template-auth')
@section('css')
    <style>
        /* Custom styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
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
        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 20px;
        }
    </style>
</head>
@section('content')

<div class="activation-container mb-20">
    <img src="{{ asset('/images/upgrade.svg') }}" alt="Awaiting Activation">
    <h1 class="text-primary">Your Company Account is Pending for Activation</h1>
    <p>
        Thank you for registering your company with us!<br><br> Your account is currently under review by our admin team.
        Once your account is activated, you will be notified via email and can start managing your activities on our platform.
    </p>
    <p>
        If you have any questions, feel free to <a href="mailto:support@example.com">contact our support team</a>.
    </p>
    <!-- Redirect to homepage -->
    <a href="{{ url('/') }}" class="cta-button">Return to Home</a>

   
</div>

@endsection
