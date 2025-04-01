<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikacioni kod</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Global Stylesheets -->
    <link href="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/style.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/custom.style.css" rel="stylesheet">
    <style>
        /* Custom styling for email to make it beautiful with Metronic */
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
            width: 150px;
        }

        .email-body {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        .email-body h1 {
            text-align: center;
            color: #009EF7;
        }

        .email-body h3 {
            color: #3457D0;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <!-- Metronic Logo (use your logo here) -->
            <a href="{{ route('home') }}" class="navbar-brand fw-bold">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Im job" height="30">

            </a>
        </div>
        <div class="email-body">
            <h3>Hello, {{ $user->first_name }}!</h3>
            <p>Thank You for registration.</p>
            <p>Your verification code is:</p>
            <h1>{{ $code }}</h1>
            <p>Please enter this code in aplication to verifia acount.</p>
            <br>
            <p>Regrads,<br>IMjob</p>
        </div>
    </div>
</body>

</html>
