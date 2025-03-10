<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You're Invited by {{ $company->name }}!</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Global Stylesheets -->
    <link href="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/style.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/custom.style.css" rel="stylesheet">
    <style>
        /* Custom styling for email */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header img {
            width: 150px; /* Logo size */
        }
        .email-body {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            text-align: center;
        }
        .email-body h3 {
            color: #4CAF50; /* Metronic green */
            font-size: 22px;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #009EF7;
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
            padding-top: 30px;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .footer p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <a href="{{ route('home') }}" class="navbar-brand fw-bold">
            <img src="{{ asset('/images/logo1.png') }}" width="80px" class="img-fluid" alt="Im job logo">
            </a>
        </div>

        <div class="email-body">
        <h3>Hello,</h3>
        <p><strong>{{ $company->name }}</strong> has invited you to join their team on <strong>Im Job</strong>!</p>
        
        <img src="{{ asset('/images/workforce.webp') }}" alt="Invitation" width="60" style="margin: 20px auto;">

        <p>Click the button below to register and join {{ $company->name }}.</p>

        <!-- Call-to-Action button (Redirect to Register Page) -->
        <a href="{{ route('register', ['invited_by' => $company->id]) }}" class="cta-button">Register Now</a>

    </div>


        <div class="footer">
            <p>&copy; {{ date('Y') }} Im Job. All rights reserved.</p>
            <p>If you didn’t expect this email, you can safely ignore it.</p>
            <p>For support, <a href="mailto:imjob@info.com">contact us</a>.</p>
        </div>
    </div>

<!-- Global Javascript Bundle -->
<script src="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/scripts.bundle.js"></script>
</body>
</html>
