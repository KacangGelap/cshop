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

    <!-- Assets -->
    <link rel="stylesheet" href="{{asset('sass/app.scss')}}">
    
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    {{-- <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</head>
<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-secondary shadow-lg">
            <div class="container">
                <a class="navbar-brand text-primary" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
        </nav> --}}
        <main class="pb-4 bg-secondary">
          <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-primary text-decoration-none">
                            <img src="{{asset('img/favicon.png')}}" class="w-50">
                            <span class="fs-5 d-none d-sm-inline">{{config('app.name')}}</span>
                        </a>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link align-middle px-0 text-bg-dark">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            @if(Auth::user()->role == 'admin')
                            <li>
                                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Admin Control Panel</span> </a>
                                <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{route('user')}}" class="nav-link px-0 align-middle">
                                            <span class="ms-3 d-none d-sm-inline text-primary">User Management</span></a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0 text-bg-dark"> 
                                            <span class="ms-3 d-none d-sm-inline text-primary">Item</span></a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            
                            <li>
                                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                    <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Bootstrap</span></a>
                                <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="#" class="nav-link px-0 text-bg-dark"> <span class="d-none d-sm-inline ">Item</span> 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0 text-bg-dark"> <span class="d-none d-sm-inline">Item</span> 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Products</span> </a>
                                    <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-bg-dark">Product</span> 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-bg-dark">Product</span> 2</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-bg-dark">Product</span> 3</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-bg-dark">Product</span> 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Customers</span> </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="dropdown pb-4">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/kacanggelap.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                                <span class="d-none d-sm-inline mx-1">{{Auth::user()->name}}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="#">New project...</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col py-3">
                    @yield('content')
                </div>
            </div>
        </div>
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
