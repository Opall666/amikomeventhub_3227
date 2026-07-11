@extends('layouts.app')

@section('title', 'AmikomEventHub - Temukan Event Seru!')

@section('content')
<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>
        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
        </p>
        <div class="flex gap-4">
            <button onclick="scrollToEvents()" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform cursor-pointer">
                Mulai Jelajah
            </button>
            <a href="{{ route('cara-kerja') }}" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <img src="{{ asset('assets/concert.png') }}" alt="Concert"
            class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-6">
        <div>
            <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>
        
        <!-- Search Form -->
        <form action="{{ route('home') }}#events" method="GET" class="w-full md:w-96 relative">
            <!-- Pertahankan filter kategori saat search -->
            @if($activeCategory)
                <input type="hidden" name="category" value="{{ $activeCategory }}">
            @endif
            
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama event atau lokasi..." 
                class="w-full pl-11 pr-10 py-3 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium shadow-sm">
            
            <!-- Icon Search -->
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            
            <!-- Tombol Clear Search -->
            @if(request('search'))
                <a href="{{ route('home', ['category' => $activeCategory]) }}#events" 
                   class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition bg-white rounded-full p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </form>
    </div>

    <!-- Filter Tabs Kategori -->
    <div class="mb-10 flex flex-wrap gap-3 justify-center">
        <!-- Tombol "Semua Kategori" -->
        <a href="{{ route('home') }}#events"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition shadow-sm
            {{ !$activeCategory ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            🎯 Semua Kategori
        </a>

        <!-- Looping untuk setiap kategori dari database -->
        @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->slug]) }}#events"
                class="px-5 py-2.5 rounded-xl font-bold text-sm transition shadow-sm
                {{ $activeCategory === $cat->slug ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Info Filter Aktif -->
    @if($activeCategory || request('search'))
        <div class="mb-6 p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="text-sm text-slate-700">
                <p>
                    Menampilkan <span class="font-bold text-indigo-600">{{ $events->total() }}</span> event
                    @if($activeCategory)
                        untuk kategori 
                        <span class="font-bold text-indigo-600">{{ $categories->firstWhere('slug', $activeCategory)?->name }}</span>
                    @endif
                    @if(request('search'))
                        dengan pencarian <span class="font-bold text-indigo-600">"{{ request('search') }}"</span>
                    @endif
                </p>
            </div>
            <a href="{{ route('home') }}#events" class="text-sm font-bold text-indigo-600 hover:underline whitespace-nowrap">
                Reset Semua Filter ✕
            </a>
        </div>
    @endif

    <!-- Event Grid -->
    @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">            @foreach($events as $event)
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="relative overflow-hidden aspect-[3/4]">
                        @if($event->poster_path)
                            <img src="{{ asset('storage/' . $event->poster_path) }}"
                                alt="{{ $event->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="{{ asset('assets/concert.png') }}"
                                alt="{{ $event->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                            {{ $event->category->name ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $event->date->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="truncate">{{ $event->location }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t">
                            <span class="text-2xl font-black text-indigo-600">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('events.show', $event->id) }}"
                                class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Pagination -->
            @if($events->hasPages())
                <div class="col-span-full mt-10 flex justify-center">
                    {{ $events->fragment('events')->links() }}
                </div>
            @endif
        </div>
    @else
    
    <!-- Empty State -->
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            @if(request('search') || $activeCategory)
                <h3 class="text-xl font-bold text-slate-800 mb-2">Event Tidak Ditemukan</h3>
                <p class="text-slate-500 mb-6 max-w-md mx-auto">
                    Tidak ada event yang cocok dengan pencarian atau filter Anda. Coba ubah kata kunci atau reset filter.
                </p>
                <a href="{{ route('home') }}#events" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition">
                    Reset Semua Filter
                </a>
            @else
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Event</h3>
                <p class="text-slate-500 mb-6">Belum ada event yang tersedia saat ini. Cek lagi nanti!</p>
            @endif
        </div>
    @endif
</section>

<!-- Partners Section -->
@if($partners->count() > 0)
<section class="bg-white py-20 mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
                Our Partners
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-3">
                Didukung Oleh Partner Terbaik
            </h2>
            <p class="text-slate-500 max-w-2xl mx-auto">
                AmikomEventHub berkolaborasi dengan berbagai institusi dan perusahaan terkemuka 
                untuk menghadirkan pengalaman event terbaik.
            </p>
        </div>

        <!-- Partner Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        @foreach($partners as $partner)
            @if($partner->website_url)
                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer"
                    class="group bg-slate-50 hover:bg-white border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:scale-105 rounded-2xl p-6 flex items-center justify-center transition-all duration-300 block"
                    title="Kunjungi {{ $partner->name }}">
                    @if($partner->logo_url)
                        <img src="{{ asset('storage/' . $partner->logo_url) }}" 
                            alt="{{ $partner->name }}" 
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300">
                    @else
                        <span class="text-sm font-bold text-slate-600 text-center group-hover:text-indigo-600 transition">
                            {{ $partner->name }}
                        </span>
                    @endif
                </a>
            @else
                <div class="group bg-slate-50 hover:bg-white border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:scale-105 rounded-2xl p-6 flex items-center justify-center transition-all duration-300">
                    @if($partner->logo_url)
                        <img src="{{ asset('storage/' . $partner->logo_url) }}" 
                            alt="{{ $partner->name }}" 
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300">
                    @else
                        <span class="text-sm font-bold text-slate-600 text-center group-hover:text-indigo-600 transition">
                            {{ $partner->name }}
                        </span>
                    @endif
                </div>
            @endif
        @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <p class="text-sm text-slate-500">
                Tertarik menjadi partner kami? 
                <a href="mailto:partnership@amikom.ac.id?subject=Proposal%20Kerjasama%20Partner%20-%20AmikomEventHub" 
                class="text-indigo-600 font-bold hover:underline">
                    Hubungi kami →
                </a>
            </p>
        </div>
    </div>
</section>
@endif

<!-- Smooth Scroll Script -->
<script>
    // Fungsi untuk scroll ke section events
    function scrollToEvents() {
        const eventsSection = document.getElementById('events');
        if (eventsSection) {
            // Hitung offset untuk navbar (navbar height + margin)
            const navbarHeight = 100;
            const elementPosition = eventsSection.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - navbarHeight;
            
            // Smooth scroll
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            // Update URL tanpa reload
            history.pushState(null, null, '#events');
            
            // Highlight effect
            eventsSection.classList.add('ring-4', 'ring-indigo-300', 'rounded-2xl', 'transition-all', 'duration-500');
            setTimeout(() => {
                eventsSection.classList.remove('ring-4', 'ring-indigo-300', 'rounded-2xl');
            }, 2000);
        }
    }
    
    // Auto-scroll jika URL mengandung #events (dari link kategori)
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#events') {
            setTimeout(() => {
                scrollToEvents();
            }, 200);
        }
    });
</script>
@endsection