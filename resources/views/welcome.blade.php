<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Admin Diskominfo') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        /* Animasi */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-down {
            animation: fadeInDown 1s ease forwards;
        }

        .fade-up {
            animation: fadeInUp 1s ease forwards;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen flex flex-col">
    <main class="flex-1">
        <!-- Hero Section -->
        <section class="relative flex items-center justify-center text-center min-h-screen overflow-hidden">
            <!-- Dekorasi lingkaran -->
            <div
                class="absolute -top-32 -right-32 w-72 h-72 bg-blue-200 rounded-full opacity-30 blur-3xl">
            </div>
            <div
                class="absolute -bottom-32 -left-32 w-64 h-64 bg-pink-200 rounded-full opacity-30 blur-3xl">
            </div>

            <div class="relative z-10 container mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 fade-down">Welcome Admin!</h1>

                @if (Route::has('login'))
                @auth
                <p class="mt-4 text-lg text-gray-600 fade-up">Sudah login, bisa kelola konten</p>
                <a href="{{ url('/dashboard') }}"
                    class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-full shadow hover:bg-blue-700 transition fade-up">
                    Dashboard
                </a>
                @else
                <p class="mt-4 text-lg text-gray-600 fade-up">Login dulu untuk mengelola konten</p>
                <a href="{{ route('login') }}"
                    class="mt-6 inline-block px-6 py-3 border border-blue-600 text-blue-600 rounded-full shadow hover:bg-blue-600 hover:text-white transition fade-up">
                    Log in
                </a>
                @endauth
                @endif
            </div>
        </section>
    </main>
</body>

</html>