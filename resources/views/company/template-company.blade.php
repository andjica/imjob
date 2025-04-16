<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tcp App</title>
    <meta name="description" content="TCP App">
    <meta name="keywords" content="Angular, VueJs, React, Laravel, company themes, web design, figma, web development">
    <link rel="shortcut icon" href="{{ asset('templates/metronic') }}/media/logos/favicon.ico">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <!-- Global Stylesheets -->
    <link href="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/style.bundle.css" rel="stylesheet">
    <link href="{{ asset('templates/metronic') }}/css/custom.style.css" rel="stylesheet">
    <meta name="company-id" content="{{ auth()->user()->company->id ?? '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
</head>
<body>

</body>
@php
    $route = request()->server('REQUEST_URI');
@endphp

<div class="d-flex flex-column flex-root">

    <div class="page d-flex flex-row flex-column-fluid">
        <!-- Sidebar -->
        @include('company.components.aside-nav')
        <!-- End Sidebar -->

        <!-- Wrapper -->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

            <!-- Header -->
            @include('company.components.header')
            <!-- End Header -->

            @include('company.components.page-title')

            <div id="content" class="d-flex flex-column flex-column-fluid">
                @yield('content')
            </div>
            @include('chat.chat')
        </div>
        <!-- End Wrapper -->
    </div>
    <!-- End Page -->
</div>


<script>var hostUrl = "assets/";</script>

<!-- Global Javascript Bundle -->
<script src="{{ asset('templates/metronic') }}/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/scripts.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/widgets.bundle.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/widgets.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/apps-chats/chat.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/intro.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/modals/upgrade-plan.js"></script>
<script src="{{ asset('templates/metronic') }}/js/custom/modals/users-search.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="{{ mix('js/app.js') }}" defer></script>


@yield('js')
</body>
</html>
