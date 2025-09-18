<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Konten</title>
    <link rel="shortcut icon" href="data:image/png;base64,..." type="image/png">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/compiled/css/iconly.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <script>
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
    </script>

    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            {{-- Ubah route ke route dashboard utama Anda --}}
                            <a href="{{ route('dashboard') }}"><img
                                    src="{{ asset('mazer/dist/assets/compiled/svg/logo.svg') }}" alt="Logo"
                                    srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    {{-- AWAL DARI PERUBAHAN MENU SIDEBAR --}}
                    {{-- AWAL DARI PERUBAHAN MENU SIDEBAR --}}
                    <ul class="menu">
                        <li class="sidebar-title">Menu Utama</li>

                        {{-- Tambahkan kondisi active menggunakan request()->routeIs() --}}
                        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }} ">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        {{-- Gunakan wildcard (*) agar active saat berada di route agenda.index, agenda.create, agenda.edit, dll. --}}
                        <li class="sidebar-item {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                            <a href="{{ route('agenda.index') }}" class='sidebar-link'>
                                <i class="bi bi-calendar-event-fill"></i>
                                <span>Manajemen Agenda</span>
                            </a>
                        </li>

                        {{-- Ganti 'konten.*' dengan nama route Anda --}}
                        <li class="sidebar-item {{ request()->routeIs('content.*') ? 'active' : '' }} ">
                            <a href="{{ route('content.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-richtext-fill"></i>
                                <span>Manajemen Konten</span>
                            </a>
                        </li>

                        {{-- Untuk menu dengan submenu (has-sub) --}}
                        <li class="sidebar-item has-sub {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-menu-button-wide-fill"></i>
                                <span>Manajemen Menu</span>
                            </a>
                            {{-- Pastikan nama route untuk submenu juga sesuai --}}
                            <ul class="submenu ">
                                <li class="submenu-item {{ request()->routeIs('menu.utama.*') ? 'active' : '' }} ">
                                    <a href="#" class="submenu-link">Menu Utama</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('menu.data.*') ? 'active' : '' }} ">
                                    <a href="#" class="submenu-link">Data Menu</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Sistem</li>

                        {{-- Ganti 'admin.*' dengan nama route Anda --}}
                        <li class="sidebar-item {{ request()->routeIs('admin.*') ? 'active' : '' }} ">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-person-fill-gear"></i>
                                <span>Manajemen Admin</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class='sidebar-link' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                            {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            </form> --}}
                        </li>
                    </ul>
                    {{-- AKHIR DARI PERUBAHAN MENU SIDEBAR --}}
                </div>
            </div>
            <div id="main">

                @yield('content')
            </div>
        </div>
        <script src="{{ asset('mazer/dist/assets/static/js/components/dark.js') }}"></script>
        <script src="{{ asset('mazer/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('mazer/dist/assets/compiled/js/app.js') }}"></script>

        <script src="{{ asset('mazer/dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
        {{-- Pastikan file dashboard.js juga disesuaikan untuk menampilkan data yang relevan di grafik --}}
        <script src="{{ asset('mazer/dist/assets/static/js/pages/dashboard.js') }}"></script>

        <script>
            document.getElementById('toggle-dark').addEventListener('change', function() {
                if (this.checked) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                }
            });
        </script>
</body>

</html>