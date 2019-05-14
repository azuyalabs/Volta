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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="volta" v-cloak>
    <nav class="navbar navbar-expand-md navbar-light navbar-volta sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/img/volta-logo.png') }}" width="205" alt="{{ config('app.name', 'Laravel') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto" id="navbarMenu">
                        <li class="{{ Request::is('home') ? 'active' : '' }}"><a class="nav-link"
                                                                                 href="{{ route('home') }}">Home</a>
                        </li>
                        @can('list', App\Machine::class)
                            <li class="{{ Request::is('machines*') ? 'active' : '' }}"><a class="nav-link"
                                                                                          href="{{ route('machines.index') }}">Equipment</a>
                            </li>
                        @endcan
                        @can('list', App\Spool::class)
                            <li class="{{ Request::is('spools*') ? 'active' : '' }}"><a class="nav-link"
                                                                                        href="{{ route('spools.index') }}">Filament
                                    Spools</a></li>
                        @endcan

                    </ul>

                    <b-link
                            href="/dashboard"
                            class="btn btn-primary btn-sm text-uppercase"
                            title="Live!"
                            target="_blank"
                    >
                        <svgicon icon="details" class="button-icon-sm" color="#fff"></svgicon>
                        Live!
                    </b-link>
                    <b-link href="/docs" title="Documentation" class="pl-3">
                        Documentation
                    </b-link>
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

    <div class="container">
        <div class="row mt-4">
            <div class="col-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center pt-0" href="/telescope"
                           target="_blank">Telescope</a>
                    </li>
                    <li class="nav-item">
                        <router-link active-class="active" to="/manufacturers"
                                     class="nav-link d-flex align-items-center pt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M0 3c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm2 2v12h16V5H2zm8 3l4 5H6l4-5z"></path>
                            </svg>
                            <span>Manufacturers</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link active-class="active" to="/products" class="nav-link d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M7 17H2a2 2 0 0 1-2-2V2C0 .9.9 0 2 0h16a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2h-5l4 2v1H3v-1l4-2zM2 2v11h16V2H2z"></path>
                            </svg>
                            <span>Products</span>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="col-10">
                @include('partials.flash-message')
                <router-view></router-view>
            </div>
        </div>

    </div>
</div>
<footer class="d-flex justify-content-center align-items-center">
    <div>
        <p>&copy; {{ date('Y') }} <strong>Volta</strong> is an <a href="#">AzuyaLabs</a> project.</p>
    </div>
</footer>

<!-- Global Volta Object -->
<script>
    window.Volta = @json($voltaScriptVariables);
</script>

<!-- Scripts -->
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
