<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="{{ asset('assets/cdn/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/cdn/bootstrap.min.js') }}"></script>
</head>

<body>
    <main class="vh-100">
        <div class="container">
            <nav class="navbar navbar-expand-lg mb-5">
                <div class="container-fluid">
                    <div class="d-flex flex-column">
                        <span class="fs-4 fw-bold">Dashboard</span>
                        <span>Selamat Datang
                            <span class="fw-bold text-decoration-underline ">{{ $user->name }}</span>
                            Di Dashboard!
                        </span>
                    </div>
                    <div>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('dashboard') ? 'active text-decoration-underline' : '' }}"
                                        aria-current="page" href="{{ route('dashboard') }}">Dasbor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard.user') ? 'active text-decoration-underline' : '' }}"
                                        href="{{ route('dashboard.user') }}">User</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard.mesin') ? 'active text-decoration-underline' : '' }}"
                                        href="{{ route('dashboard.mesin') }}">Mesin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard.produk') ? 'active text-decoration-underline' : '' }}"
                                        href="{{ route('dashboard.produk') }}">Produk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard.bahan') ? 'active text-decoration-underline' : '' }}"
                                        href="{{ route('dashboard.bahan') }}">Bahan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard.order') ? 'active text-decoration-underline' : '' }}"
                                        href="{{ route('dashboard.order') }}">Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('dashboard.produksi') ? 'active text-decoration-underline' : '' }}"
                                        href="{{ route('dashboard.produksi') }}">Produksi</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-danger" href="{{ url('/logout') }}">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    </main>
</body>

</html>
