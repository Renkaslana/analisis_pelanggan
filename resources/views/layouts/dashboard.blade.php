<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Sistem Prediksi Kepuasan Pelanggan')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        dark: '#1F2937',
                        light: '#F3F4F6'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Sidebar & Navbar -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md hidden md:block">
            <div class="p-6 text-center border-b border-gray-200">
                <h2 class="text-xl font-bold text-primary">SuaraPelanggan</h2>
                <p class="text-sm text-gray-500">Sistem Prediksi Kepuasan Pelanggan</p>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('sentiments.index') }}" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition @if(request()->routeIs('sentiments.index')) bg-primary text-white @endif">
                    Beranda
                </a>
                <a href="{{ route('sentiments.dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition @if(request()->routeIs('sentiments.dashboard')) bg-primary text-white @endif">
                    Dashboard
                </a>
                <a href="{{ route('sentiments.history') }}" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition @if(request()->routeIs('sentiments.history')) bg-primary text-white @endif">
                    Riwayat Analisis
                </a>
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Profil</a>
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Pengaturan</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-md hover:bg-red-500 hover:text-white text-sm text-gray-600 transition">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex justify-between items-center p-4 bg-white shadow-sm md:hidden">
                <h1 class="text-lg font-semibold">Dashboard</h1>
                <button id="menuButton" class="text-gray-600 focus:outline-none">
                    <!-- Hamburger Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </header>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden bg-white shadow-md p-4 space-y-2">
                <a href="{{ route('sentiments.index') }}" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Beranda</a>
                <a href="{{ route('sentiments.dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Dashboard</a>
                <a href="{{ route('sentiments.history') }}" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Riwayat</a>
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Profil</a>
                <a href="#" class="block px-4 py-2 rounded-md hover:bg-primary hover:text-white transition">Pengaturan</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-md hover:bg-red-500 hover:text-white text-sm text-gray-600 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Page Content -->
            <main class="p-4 overflow-auto flex-1 bg-gray-100">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="p-4 text-center text-sm text-gray-500 bg-white border-t">
                &copy; {{ date('Y') }} SuaraPelanggan. Hak Cipta Dilindungi.
            </footer>
        </div>
    </div>

    <!-- JS for Mobile Menu -->
    <script>
        const menuButton = document.getElementById('menuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
