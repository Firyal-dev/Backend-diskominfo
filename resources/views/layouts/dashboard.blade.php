<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Aset CSS Mazer --}}
    <link rel="shortcut icon" href="{{ asset('mazer/dist/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/dist/assets/compiled/css/iconly.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Script untuk mencegah flash saat pergantian tema --}}
    <script>
        // Cek local storage
        let darkMode = localStorage.getItem('dark');
        // Jika dark mode aktif, tambahkan class dark
        if (darkMode === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark')
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'light')
        }
    </script>
</head>

<body>
    {{-- Skrip inisialisasi tema untuk mencegah kedipan (flicker) --}}
    <script src="{{ asset('mazer/dist/assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo d-flex align-items-center gap-2">
                            <!-- <i class="bi bi-person-circle fs-4"></i> -->
                            <div class="d-flex flex-column">
                                <span class="fs-5 fw-semibold">{{ Auth::user()->name }}</span>
                                <span class="badge bg-primary align-self-start mt-1" style="font-size: 0.7rem;">
                                    {{ Auth::user()->level }}
                                </span>

                            </div>
                        </div>

                        <div class="gap-2 mt-2 theme-toggle d-flex align-items-center">
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg class="iconify iconify--mdi" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" role="img">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 2.11-2.5 6.87 1.03 10.39c3.45 3.46 8.21 3.75 10.32 1.04Z" />
                            </svg>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>

                {{-- ### AWAL DARI BAGIAN SIDEBAR MENU YANG DIPERBAIKI ### --}}
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu Utama</li>

                        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Manajemen Website</li>

                        {{-- Manajemen Agenda --}}
                        <li class="sidebar-item {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
                            <a href="{{ route('agenda.index') }}" class='sidebar-link'>
                                <i class="bi bi-calendar-event-fill"></i>
                                <span>Manajemen Agenda</span>
                            </a>
                        </li>

                        {{-- Manajemen Konten --}}
                        <li class="sidebar-item has-sub {{ request()->routeIs('galeri.*') || request()->routeIs('album.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>Manajemen Konten</span>
                            </a>

                            <ul class="submenu {{ request()->routeIs('galeri.*') || request()->routeIs('album.*') ? 'active' : '' }}">
                                <li class="submenu-item {{ request()->routeIs('galeri.*') ? 'active' : '' }}">
                                    <a href="{{ route('galeri.index') }}" class="submenu-link">Galeri</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('album.*') ? 'active' : '' }}">
                                    <a href="{{ route('album.index') }}" class="submenu-link">Album</a>
                                </li>
                            </ul>
                        </li>

                        {{-- [DISEMPURNAKAN] Manajemen Menu menjadi Dropdown --}}
                        <li class="sidebar-item has-sub {{ request()->routeIs('menu.*') || request()->routeIs('menu-data.*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-menu-button-wide-fill"></i>
                                <span>Manajemen Menu</span>
                            </a>

                            <ul class="submenu {{ request()->routeIs('menu.*') || request()->routeIs('menu-data.*') ? 'active' : '' }}">
                                {{-- Link ke CRUD Struktur Menu (tb_menu) --}}
                                <li class="submenu-item {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                                    <a href="{{ route('menu.index') }}" class="submenu-link">Struktur Menu</a>
                                </li>
                                {{-- Link ke CRUD Konten Menu (tb_menu_data) --}}
                                <li class="submenu-item {{ request()->routeIs('menu-data.*') ? 'active' : '' }}">
                                    <a href="{{ route('menu-data.index') }}" class="submenu-link">Konten Menu</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-title">Sistem</li>

                        {{-- Placeholder untuk manajemen user/admin --}}
                        @if (Auth::user() && Auth::user()->level == 'superadmin')
                        <li class="sidebar-item {{ request()->routeIs('manageAdmins.*') ? 'active' : '' }}">
                            <a href="{{ route('manageAdmins.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>Manajemen Admin</span>
                            </a>
                        </li>
                        @endif

                        <li class="sidebar-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-danger w-100" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                {{-- ### AKHIR DARI BAGIAN SIDEBAR MENU ### --}}

            </div>
        </div>
        <div id="main">
            {{-- Header untuk Tombol Burger di Mobile --}}
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('content')

            <footer>
                <div class="clearfix mb-0 footer text-muted">
                    <div class="float-start">
                        <p>{{ date('Y') }} &copy; Diskominfo</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- [DIPERBAIKI] Skrip dimuat di bagian akhir untuk fungsionalitas yang benar --}}
    <script src="{{ asset('mazer/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('mazer/dist/assets/compiled/js/app.js') }}"></script>

    {{-- Script tambahan dari halaman lain (jika ada) --}}
    @stack('scripts')

    {{-- Pindahkan script tema ke bagian bawah sebelum penutup body --}}
    <script>
        // Fungsi untuk toggle tema
        document.getElementById('toggle-dark').addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
                localStorage.setItem('dark', 'true')
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light')
                localStorage.setItem('dark', 'false')
            }
        });

        // Set checkbox sesuai tema saat ini
        document.addEventListener('DOMContentLoaded', function() {
            let darkMode = localStorage.getItem('dark');
            document.getElementById('toggle-dark').checked = darkMode === 'true';
        });
    </script>
</body>

</html>