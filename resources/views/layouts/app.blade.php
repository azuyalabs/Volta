<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/volta.css') }}" rel="stylesheet">
</head>
<body>
<div id="volta" v-cloak>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-md navbar-light navbar-volta sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/images/volta-logo.png') }}" width="205" alt="{{ config('app.name', 'Laravel') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
                <!-- Left Side Of Navbar -->
                    <div class="ml-5">
                        <b-link
                                href="/dashboard"
                                class="btn btn-primary btn-sm text-uppercase"
                                title="Live!"
                                target="_blank"
                        >
                            <svgicon icon="details" class="button-icon-sm" color="#fff"></svgicon>
                            Live!
                        </b-link>
                        <b-link href="https://github.com/azuyalabs/Volta/wiki" target="_blank" title="Documentation" class="pl-3">
                            Documentation
                        </b-link>
                    </div>
            @endauth

            <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">@lang('auth.register.short_title')</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    @lang('profile.section')
                                </a>
                                <a class="dropdown-item" href="{{ route('preferences') }}">
                                    @lang('preferences.section')
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main -->
    <div class="container-fluid mt-4">
        <div class="row">
            @auth
                <nav class="col-md-2 d-none d-md-block" id="sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('home') ? 'active' : '' }}"
                                   href="{{ route('home') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-compass">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polygon
                                                points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                                    </svg>
                                    Home
                                </a>
                            </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('machines*') ? 'active' : '' }}"
                                       href="{{ route('machines.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-grid">
                                            <rect x="3" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="3" width="7" height="7"></rect>
                                            <rect x="14" y="14" width="7" height="7"></rect>
                                            <rect x="3" y="14" width="7" height="7"></rect>
                                        </svg>
                                        Equipment
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('threedprinterjobs*') ? 'active' : '' }}"
                                       href="{{ route('threedprinterjobs.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-send">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                        Print Jobs
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('spools*') ? 'active' : '' }}"
                                       href="{{ route('spools.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-disc">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <line x1="12" y1="6" x2="12" y2="5"></line>
                                            <line x1="12" y1="6" x2="12" y2="5" transform="rotate(120, 12, 12)"></line>
                                            <line x1="12" y1="6" x2="12" y2="5" transform="rotate(240, 12, 12)"></line>
                                            <line x1="21" y1="20" x2="23" y2="20"></line>
                                        </svg>
                                        Filament Spools
                                    </a>
                                </li>

                        </ul>
                        @role('admin')
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                            <span>Administration</span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="/manufacturers">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-truck">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                    Manufacturers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/new/products">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                                        <path d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z"></path>
                                        <polyline points="2.32 6.16 12 11 21.68 6.16"></polyline>
                                        <line x1="12" y1="22.76" x2="12" y2="11"></line>
                                    </svg>
                                    Products
                                </a>
                            </li>
                        </ul>
                        @endrole

                    </div>
                </nav>
            @endauth

            @auth
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    @elseauth
                        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
                            @endauth

                            @include('partials.flash-message')
                            @yield('content')
                        </main>
        </div>
    </div>
</div>
<footer class="d-flex justify-content-center align-items-center">
    <div>
        <p>&copy; 2018 - {{ date('Y') }} <strong>Volta</strong> is an <a href="#">AzuyaLabs</a> project.</p>
    </div>
</footer>

<!-- Global Volta Object -->
<script>
    window.Volta = @json($voltaScriptVariables);
</script>

<!-- Scripts -->
<script src="{{ asset('js/volta.js') }}"></script>
</body>
</html>
