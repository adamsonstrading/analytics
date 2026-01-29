<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Analytics') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v={{ time() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        .animate-bounce-subtle {
            animation: bounce-subtle 2s infinite;
        }
    </style>

    <!-- Flatpickr (Calendar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 transition-all duration-300 w-full">
            <!-- Topbar -->
            @include('layouts.topbar')

            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto relative">
                 @if(session('status'))
                    <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('status') == 'profile-updated' ? 'Profile details updated!' : (session('status') == 'password-updated' ? 'Security settings saved!' : session('status')) }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
