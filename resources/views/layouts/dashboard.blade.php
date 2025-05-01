<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en" class="bg-gray-900 text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sentiment Analyzer</title>

    <!-- Tailwind & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font + Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons (Feather Icons) -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.2s ease;
        }
        .glow-positive {
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.4);
        }
        .glow-negative {
            box-shadow: 0 0 15px rgba(248, 113, 113, 0.4);
        }
        .glow-neutral {
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-indigo-900 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800/80 backdrop-blur-md shadow-lg hidden md:block">
            <div class="p-6 text-center">
                <h1 class="text-2xl font-bold text-white">SentimenKu</h1>
                <p class="text-sm text-gray-400 mt-1">Analisis Kepuasan Pelanggan</p>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('sentiments.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-indigo-600 transition-colors {{ request()->routeIs('sentiments.index') ? 'bg-indigo-500' : '' }}">
                    <svg data-feather="message-circle" class="w-5 h-5"></svg>
                    <span>Input Analisis</span>
                </a>
                <a href="{{ route('sentiments.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-blue-600 transition-colors {{ request()->routeIs('sentiments.dashboard') ? 'bg-blue-500' : '' }}">
                    <svg data-feather="bar-chart-2" class="w-5 h-5"></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('sentiments.history') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-purple-600 transition-colors {{ request()->routeIs('sentiments.history') ? 'bg-purple-500' : '' }}">
                    <svg data-feather="clock" class="w-5 h-5"></svg>
                    <span>Riwayat Analisis</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white/10 backdrop-blur-md border-b border-white/20 sticky top-0 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold">@yield('title')</h2>
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex items-center text-sm text-white/80">
                            Hai, {{ Auth::user()->name ?? 'User' }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-white/80 hover:text-white">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-6 max-w-7xl mx-auto">
                @yield('content')
            </main>

            <footer class="bg-gray-800/30 text-center text-white/50 py-4 text-sm mt-8">
                &copy; {{ date('Y') }} SentimenKu - All rights reserved.
            </footer>
        </div>
    </div>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

    <!-- Scripts Yield -->
    @stack('scripts')
</body>
</html>
