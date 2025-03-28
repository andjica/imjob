<!-- resources/views/emails/company_activation.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration Confirmation</title>

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
            width: 150px; /* Logo size */
        }
        .email-body {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        .email-body h3 {
            color: #4CAF50; /* Metronic green */
            font-size: 20px;
        }
        .cta-button {
            display: inline-block;
            padding: 10px 20px;
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
        .btn-primary {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <!-- Metronic Logo (use your logo here) -->
            <a href="{{ route('home') }}" class="navbar-brand fw-bold">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo Im job" height="60">
           
        </a>
        </div>

        <div class="email-body">
            <h3 class="text-primary">Thank you for registering with us, {{ $company->name }}!</h3>

            <p>We have received your company registration, and your account is currently under review.</p>

            <p>Our team will review the information provided, and you will be notified by email once your company is activated. After activation, you'll be able to manage your activities and start using our platform.</p>

            <p>If you have any questions or need assistance, don't hesitate to <a href="mailto:support@example.com">contact us</a>.</p>

            <!-- Call-to-Action button -->
            <a href="{{ url('/') }}" class="cta-button">Visit our platform</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Im job. All rights reserved.</p>
            <p>If you did not register on our platform, please ignore this email.</p>
            <p>For support, <a href="mailto:imjob@info.com">contact us</a>.</p>
        </div>
    </div>


<!-- Global Javascript Bundle -->
<script src="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/scripts.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/widgets.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/widgets.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/apps-chats/chat.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/intro.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/modals/create-app.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/modals/upgrade-plan.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/modals/users-search.js"></script>

</body>
</html>

