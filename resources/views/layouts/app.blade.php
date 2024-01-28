<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-secondary shadow-lg">
            <div class="container">
                <a class="navbar-brand text-primary" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon "></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Discover') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end text-bg-secondary" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-bg-secondary" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 bg-secondary">
            @yield('content')
            <hr>
        </main>
        
    </div>
    
    <footer class="mt-auto py-3 text-bg-dark shadow-lg" style="position:absolute;width:100%;">
        <div class="mx-auto row">
            <div class="col-md-3">
                <h6><img src="{{asset('img/favicon.png')}}" style="width:10%">{{config('app.name')}}</h6>
                <p>Web-based E-commerce Application. Powered by a sip of milk-tea and possibly 1 kilogram of basreng.</p>
            </div>
            <div class="col-md-3">
                <h6 class="border-bottom">About Us</h6>
            </div>
            <div class="col-md-3">
                <h6 class="border-bottom">Useful Links</h6>
            </div>
            <div class="col-md-3">
                <h6 class="border-bottom">Contact</h6>
            </div>
        </div>
        <hr>
        <div class="container text-center">
            <div class="copyright text-sm text-lg-center">
            © <script>
                document.write(new Date().getFullYear())
            </script>,
            made with ❤ by
            <a href="https://github.com/kacanggelap/" class="font-weight-bold text-light" target="_blank">Darkhazel</a>
            for a better Web Application.
            </div>
        <p id="current-time-placeholder" class="text-center text-sm  text-lg-center"></p>
      </div>
            
        </div>
        
    </footer>
    <script>
    function updateCurrentTime() {
        var currentTimeElement = document.getElementById('current-time-placeholder');

        if (currentTimeElement) {
            function updateTime() {
                var now = new Date();
                var formattedTime = now.toLocaleTimeString('en-US', { hour12: false });
                currentTimeElement.textContent = "Current Time : " + formattedTime;
            }

            // Update the time immediately
            updateTime();

            // Update the time every seconds
            setInterval(updateTime, 500);
        }
    }

    document.addEventListener('DOMContentLoaded', updateCurrentTime);
</script>
</body>
</html>
