<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
    @if(session()->has('impersonator_id'))
        <div class="bg-warning text-dark py-2 px-3 text-center fw-bold border-bottom shadow-sm">
            <i class="fa-solid fa-user-secret me-1"></i> IMPERSONATION MODE: Viewing system as <u>{{ Auth::user()->name }}</u> ({{ Auth::user()->email }}).
            <form action="{{ route('users.leave_impersonation') }}" method="POST" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Exit Impersonation (Return to {{ session('impersonator_name', 'Admin') }})
                </button>
            </form>
        </div>
    @endif

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                    <i class="fa-solid fa-shield-halved text-warning me-1"></i> Laravel 12 RBAC Studio
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
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li>
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
                        <li>
                            <a class="nav-link" href="{{ route('roles.index') }}">
                                Manage Roles
                            </a>
                        </li>

                        <li>
                            <a class="nav-link fw-bold text-primary" href="{{ route('rbac.matrix') }}">
                                🛡️ Matrix Studio
                            </a>
                        </li>
                        <li><a class="nav-link" href="{{ route('products.index') }}">Manage Products</a></li>
                        <li><a class="nav-link text-secondary" href="{{ route('rbac.audit_logs') }}">📜 Security Audit Logs</a></li>
                        <li><a class="nav-link text-danger fw-bold" href="{{ route('rbac.access_violations') }}">🚨 Access Radar</a></li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle font-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-power-off me-1"></i> {{ __('Logout') }}
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

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4">
                                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4">
                                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>