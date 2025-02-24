<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Im job App</title>
    <meta name="description" content="TCP App">
    <meta name="keywords" content="Im job web aplication">
    <link rel="shortcut icon" href="{{ asset('templates/metronic') }}/media/logos/favicon.ico">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Global Stylesheets -->
    <link href="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/style.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/custom.style.css" rel="stylesheet">



    @yield('css')
 
</head>
<body class="">
   @include('auth.nav')

    @yield('content')
   

    <footer class="footer-z-index landing-dark-bg py-4">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="text-muted">
            <a href="#">
                <img alt="Logo" src="{{asset('images/im-job-logo.svg')}}" class="h-15px h-md-20px">
            </a>
            © {{ date('Y') }} <a href="https://yourcompany.com" class="text-primary fw-bold" target="_blank">Your Company</a>. All Rights Reserved.
        </div>
        <div class="d-flex align-items-center">
            <a class="nav-link" href="{{route('index')}}">Home</a>
            <a class="nav-link" href="{{route('about-us')}}">About Us</a>
            <a class="nav-link" href="{{route('contact-us')}}">Contact Us</a>
        </div>
    </div>
</footer>

</body>
<script>var hostUrl = "assets/";</script>
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
@yield('js')
</body>
</html>
