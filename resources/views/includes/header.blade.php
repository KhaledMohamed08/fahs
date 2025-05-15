<header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            {{-- Uncomment the line below if you also wish to use an image logo --}}
            <img src="{{ asset('assets/img/logo.png') }}" alt="">
            <h1 class="sitename">{{ config('app.name') }}</h1>
        </a>

        {{-- Navigation Menu --}}
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li class="dropdown">
                    <a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Dropdown 1</a></li>
                        <li class="dropdown">
                            <a href="#"><span>Deep Dropdown</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">Deep Dropdown 1</a></li>
                                <li><a href="#">Deep Dropdown 2</a></li>
                                <li><a href="#">Deep Dropdown 3</a></li>
                                <li><a href="#">Deep Dropdown 4</a></li>
                                <li><a href="#">Deep Dropdown 5</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Dropdown 2</a></li>
                        <li><a href="#">Dropdown 3</a></li>
                        <li><a href="#">Dropdown 4</a></li>
                    </ul>
                </li>
                <li><a href="#contact">Contact</a></li>

                @auth
                    {{-- Authenticated User Menu with Avatar --}}
                    <li class="dropdown">
                        <a href="#" class="d-flex align-items-center">
                            {{-- <img src="https://avatar.iran.liara.run/username?username={{ explode(' ', auth()->user()->name)[0] }}+{{ explode(' ', auth()->user()->name)[1] }}"
                                alt="User Avatar" class="rounded-circle me-2" width="40" height="40"> --}}
                            <span>Hi, <span class="text-primary">{{ explode(' ', auth()->user()->name)[0] }}</span></span>
                            <i class="bi bi-chevron-down toggle-dropdown ms-1"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('profile.index') }}">
                                    <i class="bi bi-person-circle me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a class="text-danger" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth


            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        {{-- Auth / Guest Buttons --}}
        @guest
            <a class="btn-getstarted" href="{{ route('page.login') }}">Login / Register</a>
        @endguest

    </div>
</header>
