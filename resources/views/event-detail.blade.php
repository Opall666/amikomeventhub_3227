@extends('layouts.app')

@section('title', $event->title . ' - AmikomEventHub')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 md:py-12 pb-24 sm:pb-12">
    
    <!-- Mobile: Poster di atas (Full Width) -->
    <div class="lg:hidden mb-6">
        @if($event->poster_path)
            <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                class="w-full aspect-[4/3] object-cover rounded-2xl shadow-lg">
        @else
            <img src="{{ asset('assets/concert.png') }}" alt="{{ $event->title }}"
                class="w-full aspect-[4/3] object-cover rounded-2xl shadow-lg">
        @endif
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-12">
        
        <!-- Left: Poster (Desktop Only - Sticky) -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="sticky top-24">
                @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                        class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">
                @else
                    <img src="{{ asset('assets/concert.png') }}" alt="{{ $event->title }}"
                        class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">
                @endif
                
                <!-- Organizer Card -->
                <div class="mt-6 p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold text-sm text-slate-700 mb-3">Penyelenggara</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                            AB
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">AmikomEventHub</p>
                            <p class="text-xs text-slate-500">Verified Organizer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Details -->
        <div class="lg:col-span-2 space-y-6 sm:space-y-8 md:space-y-12">
            
            <!-- Header Info -->
            <div class="space-y-3 sm:space-y-4">
                <span class="inline-block px-3 sm:px-4 py-1 sm:py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wider">
                    {{ $event->category->name ?? 'Event' }}
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight">{{ $event->title }}</h1>
                
                <!-- Info Grid (Tanggal & Lokasi) -->
                <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:gap-6 text-slate-500 font-medium text-sm sm:text-base">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $event->date->format('l, d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="truncate">{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="prose prose-slate prose-sm sm:prose-base max-w-none">
                <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4">Deskripsi Event</h3>
                <p class="text-sm sm:text-base md:text-lg text-slate-600 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
            </div>

            <!-- Price Card - Desktop Only (Mobile pakai sticky bottom) -->
            <div class="hidden lg:block bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6 md:gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-xs md:text-sm mb-2">Harga Tiket</p>
                        @if($event->price == 0)
                            <h2 class="text-3xl md:text-5xl font-black">
                                GRATIS
                                <span class="text-sm md:text-lg font-medium text-indigo-200">/ orang</span>
                            </h2>
                        @else
                            <h2 class="text-3xl md:text-5xl font-black">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                                <span class="text-sm md:text-lg font-medium text-indigo-200">/ orang</span>
                            </h2>
                        @endif
                        <p class="mt-3 md:mt-4 text-indigo-100 flex items-center gap-2 text-sm md:text-base">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('checkout', $event->id) }}"
                            class="inline-block px-8 md:px-10 py-4 md:py-5 bg-white text-indigo-600 rounded-2xl font-black text-lg md:text-xl hover:scale-105 transition-transform shadow-xl">
                            @if($event->price == 0)
                                🎉 Daftar Gratis
                            @else
                                Pesan Sekarang
                            @endif
                        </a>
                    </div>
                </div>
                <div class="absolute -right-20 -bottom-20 w-48 md:w-64 h-48 md:h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-24 md:w-32 h-24 md:h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <!-- Kebijakan Tiket -->
            <div class="space-y-3 sm:space-y-4">
                <h3 class="text-lg sm:text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-2 sm:space-y-3 text-sm sm:text-base text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Tiket dapat discan di pintu masuk (Check-in).</span>
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Tiket yang sudah dibeli tidak dapat direfund.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>

<!-- Mobile: Sticky Bottom Bar (E-commerce Style) -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 shadow-2xl z-40 safe-bottom">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-3">
        <!-- Info Harga (Kiri) -->
        <div class="flex-1 min-w-0">
            <p class="text-xs text-slate-500 font-medium">Harga Tiket</p>
            @if($event->price == 0)
                <p class="text-lg sm:text-xl font-black text-green-600 truncate">
                    GRATIS
                </p>
            @else
                <p class="text-lg sm:text-xl font-black text-indigo-600 truncate">
                    Rp {{ number_format($event->price, 0, ',', '.') }}
                </p>
            @endif
            <p class="text-xs text-slate-400 truncate">
                Stok: {{ $event->stock }} tersedia
            </p>
        </div>
        
        <!-- Tombol Pesan (Kanan) -->
        <a href="{{ route('checkout', $event->id) }}"
            class="flex-shrink-0 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
            @if($event->price == 0)
                🎉 Daftar
            @else
                Pesan
            @endif
        </a>
    </div>
</div>
@endsection