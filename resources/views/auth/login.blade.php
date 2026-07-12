<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Premium background - FIXED: allow scrolling */
        .premium-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e0e7ff 100%);
            min-height: 100vh;
            position: relative;
        }

        .premium-bg::before {
            content: '';
            position: fixed; /* FIXED: Changed from absolute to fixed */
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        .premium-bg::after {
            content: '';
            position: fixed; /* FIXED: Changed from absolute to fixed */
            bottom: -30%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 25s ease-in-out infinite reverse;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
        }

        /* Premium card effect */
        .premium-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 
                0 1px 2px rgba(15, 23, 42, 0.03),
                0 4px 8px rgba(15, 23, 42, 0.04),
                0 16px 32px rgba(15, 23, 42, 0.06),
                0 0 0 1px rgba(15, 23, 42, 0.04);
        }

        /* Premium input focus */
        .premium-input:focus {
            box-shadow: 
                0 0 0 3px rgba(99, 102, 241, 0.1),
                0 1px 2px rgba(15, 23, 42, 0.05);
        }

        /* Premium button */
        .premium-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            box-shadow: 
                0 1px 2px rgba(79, 70, 229, 0.2),
                0 4px 12px rgba(79, 70, 229, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-btn:hover {
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
            box-shadow: 
                0 2px 4px rgba(79, 70, 229, 0.25),
                0 8px 20px rgba(79, 70, 229, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .premium-btn:active {
            transform: translateY(0);
            box-shadow: 
                0 1px 2px rgba(79, 70, 229, 0.2),
                inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Google button premium */
        .google-btn {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        .google-btn:hover {
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
            border-color: #cbd5e1;
        }

        .google-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        /* Logo premium */
        .premium-logo {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            box-shadow: 
                0 4px 12px rgba(79, 70, 229, 0.25),
                0 1px 3px rgba(79, 70, 229, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
</head>
<body class="premium-bg relative">

    <!-- Main Container - FIXED: Proper scrolling layout -->
    <div class="relative z-10 min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Logo Section -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="inline-flex items-center justify-center mb-4 sm:mb-6">
                    <div class="premium-logo w-14 h-14 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl sm:text-3xl tracking-tight">AH</span>
                    </div>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">AmikomEventHub</h1>
                <p class="mt-2 text-xs sm:text-sm text-slate-500 font-medium">
                    Platform reservasi event profesional
                </p>
            </div>

            <!-- Login Card - FIXED: Responsive padding -->
            <div class="premium-card rounded-2xl sm:rounded-3xl py-8 sm:py-10 px-5 sm:px-10">
                
                <!-- Header -->
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Flash Messages -->
                @if(session('error'))
                    <div class="mb-4 sm:mb-6 bg-red-50 border border-red-100 text-red-700 px-3 sm:px-4 py-3 rounded-xl text-xs sm:text-sm">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 sm:mb-6 bg-red-50 border border-red-100 text-red-700 px-3 sm:px-4 py-3 rounded-xl text-xs sm:text-sm">
                        <ul class="space-y-1.5">
                            @foreach($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2.5 mt-1.5 flex-shrink-0"></span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}" 
                   class="google-btn w-full flex items-center justify-center gap-3 px-4 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl font-medium text-slate-700 text-sm sm:text-base mb-5 sm:mb-6">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="truncate">Lanjutkan dengan Google</span>
                </a>

                <!-- Divider -->
                <div class="relative my-6 sm:my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-transparent text-slate-400 font-medium uppercase tracking-wider">atau dengan email</span>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5 sm:mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   value="{{ old('email') }}" 
                                   autocomplete="email"
                                   required 
                                   autofocus
                                   placeholder="nama@email.com"
                                   class="premium-input block w-full pl-10 sm:pl-11 pr-4 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-indigo-500 transition-all duration-200 text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                            <label for="password" class="block text-xs sm:text-sm font-semibold text-slate-700">
                                Password
                            </label>
                            <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                                Lupa password?
                            </a>
                        </div>
                        <div class="relative">
                            <input id="password" 
                                   name="password" 
                                   type="password" 
                                   autocomplete="current-password"
                                   required 
                                   placeholder="••••••••"
                                   class="premium-input block w-full pl-10 sm:pl-11 pr-12 py-2.5 sm:py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-indigo-500 transition-all duration-200 text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <button type="button" 
                                    onclick="togglePassword('password', this)" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 eye-off-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-0.5 sm:pt-1">
                        <input id="remember" 
                               name="remember" 
                               type="checkbox" 
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 border-slate-300 rounded transition-colors cursor-pointer">
                        <label for="remember" class="ml-2.5 block text-xs sm:text-sm text-slate-600 cursor-pointer select-none">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="premium-btn w-full flex justify-center items-center py-2.5 sm:py-3 px-4 border border-transparent rounded-xl text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mt-2">
                        Masuk ke Akun
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>

                <!-- Register Link -->
                <p class="mt-6 sm:mt-8 text-center text-xs sm:text-sm text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 sm:mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke beranda
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-6 sm:mt-8 text-center">
                <p class="text-xs text-slate-400">
                    © {{ date('Y') }} AmikomEventHub. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>