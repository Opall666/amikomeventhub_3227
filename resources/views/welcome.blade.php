@extends('layouts.app')

@section('title', 'AmikomEventHub - Temukan Event Seru!')

@section('content')
<!-- Hero Section - Mobile Optimized -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16 md:py-20 flex flex-col md:flex-row items-center gap-8 md:gap-12">
    <div class="flex-1 space-y-6 sm:space-y-8 text-center md:text-left">
        <span class="inline-block px-3 sm:px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>
        <p class="text-base sm:text-lg text-slate-500 max-w-lg leading-relaxed mx-auto md:mx-0">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center md:justify-start">
            <button onclick="scrollToEvents()" class="px-6 sm:px-8 py-3 sm:py-4 bg-indigo-600 text-white rounded-2xl font-bold text-base sm:text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform cursor-pointer">
                Mulai Jelajah
            </button>
            <a href="{{ route('cara-kerja') }}" class="px-6 sm:px-8 py-3 sm:py-4 border-2 border-slate-200 rounded-2xl font-bold text-base sm:text-lg hover:border-indigo-600 hover:text-indigo-600 transition text-center">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative w-full max-w-md mx-auto">
        <div class="absolute -top-10 -left-10 w-48 sm:w-64 h-48 sm:h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute -bottom-10 -right-10 w-48 sm:w-64 h-48 sm:h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <img src="{{ asset('assets/concert.png') }}" alt="Concert"
            class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/3] sm:aspect-[4/5] object-center">

        <!-- Floating Card - Hidden di mobile kecil -->
        <div class="hidden sm:block absolute -bottom-6 -left-6 glass p-4 sm:p-6 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="text-sm sm:text-base font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section - Mobile Optimized -->
<section id="events" class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16 md:py-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 sm:mb-8 gap-4 sm:gap-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-sm sm:text-base text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>
        
        <!-- Search Form - Mobile Optimized -->
        <form action="{{ route('home') }}#events" method="GET" class="w-full md:w-96 relative">
            @if($activeCategory)
                <input type="hidden" name="category" value="{{ $activeCategory }}">
            @endif
            
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama event atau lokasi..." 
                class="w-full pl-10 sm:pl-11 pr-10 py-2.5 sm:py-3 bg-white border-2 border-slate-200 rounded-xl sm:rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-sm sm:text-base shadow-sm">
            
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            
            @if(request('search'))
                <a href="{{ route('home', ['category' => $activeCategory]) }}#events" 
                   class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition bg-white rounded-full p-1">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </form>
    </div>

    <!-- Filter Tabs Kategori - Mobile Optimized -->
    <div class="mb-6 sm:mb-10 flex flex-wrap gap-2 sm:gap-3 justify-center">
        <a href="{{ route('home') }}#events"
            class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm transition shadow-sm
            {{ !$activeCategory ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
            🎯 Semua Kategori
        </a>

        @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->slug]) }}#events"
                class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm transition shadow-sm
                {{ $activeCategory === $cat->slug ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Info Filter Aktif - Mobile Optimized -->
    @if($activeCategory || request('search'))
        <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-lg sm:rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-3">
            <div class="text-xs sm:text-sm text-slate-700">
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
            <a href="{{ route('home') }}#events" class="text-xs sm:text-sm font-bold text-indigo-600 hover:underline whitespace-nowrap">
                Reset Semua Filter ✕
            </a>
        </div>
    @endif

    <!-- Event Grid - Mobile Optimized -->
    @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @foreach($events as $event)
                <div class="group bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
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
                        <div class="absolute top-3 sm:top-4 left-3 sm:left-4 px-2 sm:px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                            {{ $event->category->name ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-xl font-bold mb-2 group-hover:text-indigo-600 transition line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm mb-2">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $event->date->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm mb-3 sm:mb-4">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="truncate">{{ $event->location }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 sm:pt-4 border-t">
                            <span class="text-lg sm:text-2xl font-black text-indigo-600">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('events.show', $event->id) }}"
                                class="px-3 sm:px-5 py-1.5 sm:py-2 bg-indigo-50 text-indigo-600 rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm hover:bg-indigo-600 hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Pagination -->
            @if($events->hasPages())
                <div class="col-span-full mt-8 sm:mt-10 flex justify-center">
                    {{ $events->fragment('events')->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State - Mobile Optimized -->
        <div class="text-center py-12 sm:py-20 bg-white rounded-2xl sm:rounded-3xl border border-slate-100">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            @if(request('search') || $activeCategory)
                <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-2">Event Tidak Ditemukan</h3>
                <p class="text-sm sm:text-base text-slate-500 mb-6 max-w-md mx-auto px-4">
                    Tidak ada event yang cocok dengan pencarian atau filter Anda. Coba ubah kata kunci atau reset filter.
                </p>
                <a href="{{ route('home') }}#events" class="px-5 sm:px-6 py-2.5 sm:py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm sm:text-base hover:bg-slate-200 transition">
                    Reset Semua Filter
                </a>
            @else
                <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-2">Belum Ada Event</h3>
                <p class="text-sm sm:text-base text-slate-500 mb-6">Belum ada event yang tersedia saat ini. Cek lagi nanti!</p>
            @endif
        </div>
    @endif
</section>

<!-- Partners Section - Mobile Optimized -->
@if($partners->count() > 0)
<section class="bg-white py-12 sm:py-16 md:py-20 mt-12 sm:mt-16 md:mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-12">
            <span class="inline-block px-3 sm:px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider mb-3 sm:mb-4">
                Our Partners
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-800 mb-2 sm:mb-3">
                Didukung Oleh Partner Terbaik
            </h2>
            <p class="text-sm sm:text-base text-slate-500 max-w-2xl mx-auto px-4">
                AmikomEventHub berkolaborasi dengan berbagai institusi dan perusahaan terkemuka 
                untuk menghadirkan pengalaman event terbaik.
            </p>
        </div>

        <!-- Partner Grid - Mobile Optimized -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-6">
            @foreach($partners as $partner)
                @if($partner->website_url)
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer"
                        class="group bg-slate-50 hover:bg-white border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:scale-105 rounded-xl sm:rounded-2xl p-3 sm:p-6 flex items-center justify-center transition-all duration-300 block"
                        title="Kunjungi {{ $partner->name }}">
                        @if($partner->logo_url)
                            <img src="{{ asset('storage/' . $partner->logo_url) }}" 
                                alt="{{ $partner->name }}" 
                                class="max-h-8 sm:max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300">
                        @else
                            <span class="text-xs sm:text-sm font-bold text-slate-600 text-center group-hover:text-indigo-600 transition">
                                {{ $partner->name }}
                            </span>
                        @endif
                    </a>
                @else
                    <div class="group bg-slate-50 hover:bg-white border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:scale-105 rounded-xl sm:rounded-2xl p-3 sm:p-6 flex items-center justify-center transition-all duration-300">
                        @if($partner->logo_url)
                            <img src="{{ asset('storage/' . $partner->logo_url) }}" 
                                alt="{{ $partner->name }}" 
                                class="max-h-8 sm:max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-300">
                        @else
                            <span class="text-xs sm:text-sm font-bold text-slate-600 text-center group-hover:text-indigo-600 transition">
                                {{ $partner->name }}
                            </span>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <!-- CTA - Mobile Optimized -->
        <div class="text-center mt-8 sm:mt-12">
            <p class="text-xs sm:text-sm text-slate-500 px-4">
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
    function scrollToEvents() {
        const eventsSection = document.getElementById('events');
        if (eventsSection) {
            // Navbar height berbeda untuk mobile vs desktop
            const navbarHeight = window.innerWidth < 768 ? 64 : 100;
            const elementPosition = eventsSection.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - navbarHeight;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            history.pushState(null, null, '#events');
            
            eventsSection.classList.add('ring-4', 'ring-indigo-300', 'rounded-2xl', 'transition-all', 'duration-500');
            setTimeout(() => {
                eventsSection.classList.remove('ring-4', 'ring-indigo-300', 'rounded-2xl');
            }, 2000);
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#events') {
            setTimeout(() => {
                scrollToEvents();
            }, 200);
        }
    });
</script>
@endsection