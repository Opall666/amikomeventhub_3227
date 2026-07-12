<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <!-- Viewport optimal untuk PWA & Mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, maximum-scale=5.0">
    <title>@yield('title', 'AmikomEventHub - Temukan Event Seru!')</title>
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4f46e5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Safe Area untuk PWA (Notch & Home Indicator) */
        .safe-top {
            padding-top: env(safe-area-inset-top);
        }
        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }
        .safe-left {
            padding-left: env(safe-area-inset-left);
        }
        .safe-right {
            padding-right: env(safe-area-inset-right);
        }

        /* Mobile Optimization */
        @media (max-width: 640px) {
            /* Perkecil font heading di mobile */
            h1 { font-size: 1.875rem !important; line-height: 1.2 !important; }
            h2 { font-size: 1.5rem !important; }
            h3 { font-size: 1.25rem !important; }
            
            /* Kurangi padding container di mobile */
            .mobile-container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }

        /* Smooth scrolling untuk seluruh halaman */
        html {
            scroll-behavior: smooth;
        }

        /* Hide scrollbar tapi tetap bisa scroll (untuk tampilan app-like) */
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        /* Prevent text selection pada tombol (app-like) */
        button, a {
            -webkit-tap-highlight-color: transparent;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 safe-top safe-bottom safe-left safe-right">

    <!-- Navigation - Mobile Optimized -->
    <nav class="glass sticky top-0 z-50 border-b border-white/20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-base">
                        AH
                    </div>
                    <span class="text-base sm:text-lg font-bold tracking-tight hidden sm:block">AmikomEventHub</span>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center gap-6 font-medium text-sm">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} transition">
                        Jelajahi
                    </a>
                    <a href="{{ route('kategori') }}" class="{{ request()->routeIs('kategori') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} transition">
                        Kategori
                    </a>
                    <a href="{{ route('tentang-kami') }}" class="{{ request()->routeIs('tentang-kami') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} transition">
                        Tentang Kami
                    </a>
                    @auth
                        <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} transition">
                            Tiket Saya
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-indigo-600 transition">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>
                
                <!-- Desktop Auth Buttons -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 transition">
                                <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                <div class="p-3 border-b border-slate-100">
                                    <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                                    ⚙️ Edit Profil
                                </a>
                                <a href="{{ route('tickets.index') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                                    🎫 Tiket Saya
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                                        🎛️ Admin Panel
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition border-t border-slate-100">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl font-semibold text-sm text-slate-700 hover:bg-slate-100 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold text-sm shadow-md shadow-indigo-200 hover:bg-indigo-700 transition">
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 text-slate-700 hover:text-indigo-600 transition rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition font-medium">
                    🏠 Jelajahi
                </a>
                <a href="{{ route('kategori') }}" class="block px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition font-medium">
                    🏷️ Kategori
                </a>
                <a href="{{ route('tentang-kami') }}" class="block px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition font-medium">
                    ℹ️ Tentang Kami
                </a>
                
                @auth
                    <div class="pt-3 mt-3 border-t border-slate-200">
                        <div class="px-4 py-2 mb-2">
                            <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('tickets.index') }}" class="block px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition font-medium">
                            🎫 Tiket Saya
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition font-medium">
                            ⚙️ Edit Profil
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition font-medium">
                                🎛️ Admin Panel
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t border-slate-200">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition font-medium">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="pt-3 mt-3 border-t border-slate-200 space-y-2">
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-xl font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-200 hover:bg-indigo-700 transition">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Script untuk Toggle Mobile Menu dengan animasi -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            
            // Smooth scroll ke atas saat buka menu
            if (!menu.classList.contains('hidden')) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Tutup menu mobile saat klik link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
    </script>

    <!-- Flash Messages - Mobile Optimized -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-xl shadow-sm">
                <p class="font-bold text-xs sm:text-sm">✅ {{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-xl shadow-sm">
                <p class="font-bold text-xs sm:text-sm">❌ {{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer - Mobile Optimized -->
    <footer class="bg-slate-900 text-slate-300 mt-12 sm:mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="sm:col-span-2 lg:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold">
                            AH
                        </div>
                        <span class="text-lg font-bold text-white">AmikomEventHub</span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-xs leading-relaxed">
                        Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('kategori') }}" class="hover:text-white transition">Kategori</a></li>
                        <li><a href="{{ route('tentang-kami') }}" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('cara-kerja') }}" class="hover:text-white transition">Cara Bayar</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-white font-bold text-sm mb-4 uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li>
                            <a href="mailto:support@amikom.ac.id" class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="break-all">support@amikom.ac.id</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+6281234567890" class="hover:text-white transition flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                +62 812 3456 7890
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="pt-6 border-t border-slate-800 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} AmikomEventHub. Built with Laravel & Tailwind CSS.
            </div>
        </div>
    </footer>

    @stack('scripts')
    
    <!-- Register Service Worker untuk PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(reg => console.log('PWA Service Worker registered!', reg))
                    .catch(err => console.log('PWA Service Worker registration failed', err));
            });
        }
    </script>
</body>

</html>