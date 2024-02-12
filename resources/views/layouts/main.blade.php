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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    {{-- <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</head>
<body>
    <div id="app">
        <main class="pb-4 bg-secondary">
          <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="/" class="row d-flex justify-content-center mb-md-0 mx-auto text-primary text-decoration-none border-bottom">
                            <div>
                            <img src="{{asset('img/favicon.png')}}" class="w-100 justify-content-center">
                            <p class="text-center">{{config('app.name')}}</p>
                            </div>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link align-middle px-0 text-bg-dark">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            @if(Auth::user()->role == 'admin')
                            <li>
                                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-bg-dark">
                                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Admin Panels</span> </a>
                                <ul class="collapse {{Route::current()->getName() == 'User Management' ? 'show' : ''}} nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{route('User Management')}}" class="nav-link px-0 align-middle text-primary">
                                            <span class="ms-3 d-none d-sm-inline "></span>User Management</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/item')}}" class="nav-link px-0 align-middle text-primary"> 
                                            <span class="ms-3 d-none d-sm-inline "></span>Item Management</a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if(Auth::user()->role == 'user')
                            <li>
                                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-bg-dark">
                                    <i class="fs-4 bi-cart"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Keranjang Kamu</span></a>
                                <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="#" class="nav-link px-0 text-bg-dark"> <span class="d-none d-sm-inline ">Item</span> 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0 text-bg-dark"> <span class="d-none d-sm-inline">Item</span> 2</a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if (Auth::user()->role == 'user')
                            <li>
                                <a href="{{url('/stall/'.Auth::user()->id)}}" class="nav-link px-0 align-middle text-bg-dark">
                                    <i class="fs-4 bi-shop"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Kios Kamu</span> </a>
                            </li>
                            @endif
                            
                            @if (Auth::user()->role == 'courier')
                            <li>
                                <a href="#" class="nav-link px-0 align-middle text-bg-dark">
                                    <i class="fs-4 bi bi-person"></i> <span class="ms-1 d-none d-sm-inline text-bg-dark">Customers</span> </a>
                            </li>
                            @endif
                            <hr>
                        </ul>
                        
                        <div class="dropdown pb-4">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{Auth::user()->photo != NULL ? Auth::user()->photo : 'https://github.com/kacanggelap.png'}}" alt="hugenerd" width="30" height="30" class="rounded-circle">
                                <span class="d-none d-sm-inline mx-1">{{Str::limit(Auth::user()->name, 13)}}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li class="d-flex justify-content-around">
                                     Wallet : {{__(Auth::user()->ewallet)}}
                                    <a class="text-bg-primary px-1" href="{{url('user/'.Auth::user()->id.'/wallet')}}"><i class="bi bi-plus"></i></a>
                                </li>
                                <li><a class="dropdown-item" href="{{url('profile/'.Auth::user()->id)}}">Profile</a></li>
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
    <div>
    @extends('layouts.footer')
    
    </div>
</body>
</html>
