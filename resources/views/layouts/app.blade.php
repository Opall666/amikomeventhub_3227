<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AmikomEventHub - Temukan Event Seru!')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <nav class="glass sticky top-4 z-50 mx-4 mt-4 px-4 md:px-6 py-3 md:py-4 rounded-2xl border border-white/20 shadow-lg">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 md:w-10 md:h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg md:text-xl">
                        AH
                    </div>
                    <span class="text-lg md:text-xl font-bold tracking-tight hidden sm:block">AmikomEventHub</span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex gap-8 font-medium">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-indigo-600' : 'hover:text-indigo-600' }} transition">
                    Jelajahi
                </a>
                <a href="{{ route('kategori') }}" class="{{ request()->routeIs('kategori') ? 'text-indigo-600' : 'hover:text-indigo-600' }} transition">
                    Kategori
                </a>
                <a href="{{ route('tentang-kami') }}" class="{{ request()->routeIs('tentang-kami') ? 'text-indigo-600' : 'hover:text-indigo-600' }} transition">
                    Tentang Kami
                </a>
                @auth
                    <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'text-indigo-600' : 'hover:text-indigo-600' }} transition">
                        Tiket Saya
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>
            
            <!-- Desktop Auth Buttons -->
            <div class="hidden md:flex gap-3">
                @auth
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">
                                {{ Auth::user()->isAdmin() ? 'Administrator' : 'Member' }}
                            </p>
                        </div>
                        <div class="relative group">
                            <button class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold hover:bg-indigo-700 transition">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 rounded-t-xl">
                                    ⚙️ Edit Profil
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                                        🎛️ Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('tickets.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                                    🎫 Tiket Saya
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-700 hover:text-indigo-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pt-4 border-t border-slate-200 space-y-3">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
                🏠 Jelajahi
            </a>
            <a href="{{ route('kategori') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
                🏷️ Kategori
            </a>
            <a href="{{ route('tentang-kami') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
                ℹ️ Tentang Kami
            </a>
            
            @auth
                <a href="{{ route('tickets.index') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
                    🎫 Tiket Saya
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
                    ⚙️ Edit Profil
                </a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
                        ️ Admin Panel
                    </a>
                @endif
                <div class="pt-3 border-t border-slate-200">
                    <p class="px-4 text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="px-4 text-xs text-slate-500 mb-3">
                        {{ Auth::user()->isAdmin() ? 'Administrator' : 'Member' }}
                    </p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-slate-200 space-y-2">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Script untuk Toggle Mobile Menu -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl">
                <p class="font-bold text-sm">✅ {{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl">
                <p class="font-bold text-sm">❌ {{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                        AH</div>
                    <span class="text-2xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300">Platform reservasi tiket event online terbaik untuk mahasiswa dan
                    penyelenggara profesional.</p>
            </div>
            <div>
            <h4 class="text-white font-bold mb-6">Navigasi</h4>
            <ul class="space-y-4">
                <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                <li><a href="{{ route('home') }}#events" class="hover:text-white transition">Semua Event</a></li>
                <li><a href="{{ route('cara-kerja') }}" class="hover:text-white transition">Cara Bayar</a></li>
                <li><a href="{{ route('tentang-kami') }}" class="hover:text-white transition">Tentang Kami</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
            <ul class="space-y-4">
                <li>
                    <a href="mailto:support@amikom.ac.id" class="hover:text-white transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        support@amikom.ac.id
                    </a>
                </li>
                <li>
                    <a href="tel:+6281234567890" class="hover:text-white transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        +62 812 3456 7890
                    </a>
                </li>
            </ul>
        </div>
        <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm">
            &copy; 2024 AmikomEventHub. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

    @stack('scripts')

</body>

</html>