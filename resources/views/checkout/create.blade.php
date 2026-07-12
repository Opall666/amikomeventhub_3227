@extends('layouts.app')

@section('title', 'Checkout - ' . $event->title)

@section('content')
<main class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-8 md:py-12">
    
    <!-- Header -->
    <div class="mb-6 sm:mb-8 md:mb-12">
        <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-4 sm:mb-6 text-sm sm:text-base hover:text-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Event
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold">Checkout</h1>
        <p class="text-sm sm:text-base text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    <!-- Flash Message Error -->
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-xl mb-4 sm:mb-6 shadow-sm">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="font-bold text-xs sm:text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-4 sm:space-y-6 md:space-y-8">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        <!-- Summary Card -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-4 sm:p-6 md:p-8 shadow-sm">
            <h3 class="text-base sm:text-lg md:text-xl font-bold mb-4 sm:mb-6 border-b border-slate-100 pb-3 sm:pb-4">Pesanan Anda</h3>
            
            <!-- Event Info -->
            <div class="flex gap-3 sm:gap-4 md:gap-6 items-start">
                @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="Event" 
                        class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-xl sm:rounded-2xl object-cover flex-shrink-0">
                @else
                    <img src="{{ asset('assets/concert.png') }}" alt="Event" 
                        class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-xl sm:rounded-2xl object-cover flex-shrink-0">
                @endif
                <div class="flex-1 min-w-0">
                    <h4 class="font-extrabold text-sm sm:text-base md:text-lg line-clamp-2">{{ $event->title }}</h4>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 truncate">
                        {{ $event->date->format('d M Y') }} • {{ $event->location }}
                    </p>
                    <p class="text-indigo-600 font-bold text-sm sm:text-base mt-2">
                        1 x Rp {{ number_format($event->price, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            
            <!-- Price Breakdown -->
            <div class="mt-4 sm:mt-6 md:mt-8 pt-4 sm:pt-6 border-t border-slate-100 space-y-2 sm:space-y-3">
                <div class="flex justify-between text-xs sm:text-sm text-slate-500">
                    <span>Harga Tiket</span>
                    <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs sm:text-sm text-slate-500">
                    <span>Biaya Layanan</span>
                    <span>Rp 5.000</span>
                </div>
                <div class="flex justify-between items-center text-base sm:text-lg md:text-2xl font-black mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-slate-100">
                    <span>Total Bayar</span>
                    <span class="text-indigo-600">Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-4 sm:p-6 md:p-8 shadow-sm">
            <h3 class="text-base sm:text-lg md:text-xl font-bold mb-4 sm:mb-6 italic text-indigo-600 underline underline-offset-4 sm:underline-offset-8">
                📦 Data Pemesan
            </h3>
            
            <div class="space-y-4 sm:space-y-5 md:space-y-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                        Nama Lengkap
                    </label>
                    <input type="text" 
                        name="customer_name" 
                        value="{{ old('customer_name', Auth::user()->name ?? '') }}" 
                        autocomplete="name"
                        class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-sm sm:text-base @error('customer_name') border-red-300 bg-red-50 @enderror" 
                        placeholder="Masukkan nama lengkap"
                        required>
                    @error('customer_name') 
                        <div class="flex items-center gap-1 mt-2">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-500 text-xs sm:text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                
                <!-- Email & WhatsApp -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                    <!-- Email -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Email Aktif
                        </label>
                        <input type="email" 
                            name="customer_email" 
                            value="{{ old('customer_email', Auth::user()->email ?? '') }}" 
                            autocomplete="email"
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-sm sm:text-base @error('customer_email') border-red-300 bg-red-50 @enderror" 
                            placeholder="email@contoh.com"
                            required>
                        @error('customer_email') 
                            <div class="flex items-center gap-1 mt-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-500 text-xs sm:text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                        <p class="text-[10px] sm:text-xs text-slate-400 mt-2 font-bold uppercase tracking-tighter">
                            *E-Ticket akan dikirim ke email ini
                        </p>
                    </div>
                    
                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            No. WhatsApp
                        </label>
                        <input type="tel" 
                            name="customer_phone" 
                            value="{{ old('customer_phone') }}" 
                            autocomplete="tel"
                            class="w-full px-4 sm:px-5 py-3 sm:py-4 bg-slate-50 border-2 border-slate-100 rounded-xl sm:rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-sm sm:text-base @error('customer_phone') border-red-300 bg-red-50 @enderror" 
                            placeholder="08123456789"
                            required>
                        @error('customer_phone') 
                            <div class="flex items-center gap-1 mt-2">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-500 text-xs sm:text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-3.5 sm:py-4 md:py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl sm:rounded-2xl font-bold sm:font-black text-base sm:text-lg md:text-xl shadow-xl shadow-indigo-200 hover:shadow-2xl hover:scale-[1.02] active:scale-95 transition-all mt-2 sm:mt-4">
                    💳 Lanjutkan Pembayaran
                </button>
                
                <!-- Terms -->
                <p class="text-center text-[10px] sm:text-xs text-slate-400 leading-relaxed px-2">
                    Dengan menekan tombol di atas, Anda menyetujui 
                    <a href="{{ route('syarat-ketentuan') }}" target="_blank" class="text-indigo-600 hover:underline font-bold">Syarat & Ketentuan</a> 
                    serta 
                    <a href="{{ route('kebijakan-privasi') }}" target="_blank" class="text-indigo-600 hover:underline font-bold">Kebijakan Privasi</a> 
                    kami.
                </p>
            </div>
        </div>
    </form>
</main>
@endsection