<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="navbar-brand fw-bold">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo Im job" width="100px" class="img-fluid">
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <!-- Dashboard Link -->
        
            <!-- Role-Based Menus -->
            @if (auth()->check() && auth()->user()->role == 'recruiter')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('recruiter.dashboard') ? 'active' : '' }}" href="{{ route('recruiter.dashboard') }}">Recruiter Dashboard</a>
                </li>
            @elseif (auth()->check() && auth()->user()->role == 'company')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('company.dashboard') ? 'active' : '' }}" href="{{ route('company.dashboard') }}">Company Dashboard</a>
                </li>
            @endif

            <!-- Authentication Links -->
            <a class="nav-link" href="{{route('index')}}">Home</a>
            <a class="nav-link" href="{{route('about-us')}}">About Us</a>
            <a class="nav-link" href="{{route('contact-us')}}">Contact Us</a>
            @if (auth()->check())
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Dashboard</a>
            </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-link nav-link text-danger p-0" type="submit">Logout</button>
                    </form>
                </li>
            @else
                
                @if(request()->routeIs('register'))
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-white" href="{{ route('register') }}">Sign Up</a>
                </li>
                @endif
            @endif
        </ul>

        </div>
    </div>
</nav>