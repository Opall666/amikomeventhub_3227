@extends('layouts.app')

@section('title', 'Tiket Saya - AmikomEventHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 md:py-12">
    
    <!-- Header & Search Bar -->
    <div class="flex flex-col gap-4 mb-6 sm:mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-800 mb-1">Tiket Saya 🎫</h1>
            <p class="text-sm sm:text-base text-slate-500">Kelola dan pantau semua riwayat tiket event Anda</p>
        </div>
        
        <!-- Search Form -->
        <form action="{{ route('tickets.index') }}" method="GET" class="w-full relative">
            <input type="text" name="search" value="{{ $search }}" 
                placeholder="Cari Order ID atau Nama Event..." 
                class="w-full pl-10 sm:pl-11 pr-10 py-2.5 sm:py-3 bg-white border-2 border-slate-200 rounded-xl sm:rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium text-sm sm:text-base shadow-sm">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400 absolute left-3 sm:left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            @if($search)
                <a href="{{ route('tickets.index', ['filter' => $filter]) }}" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
    </div>

    <!-- 5 Clickable Stats Cards (Filters) - Mobile Optimized -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-4 mb-6 sm:mb-8">
        @php
            $filters = [
                'all' => ['label' => 'Semua', 'count' => array_sum($stats), 'color' => 'slate', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                'active' => ['label' => 'Aktif', 'count' => $stats['active'], 'color' => 'indigo', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                'success' => ['label' => 'Berhasil', 'count' => $stats['success'], 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                'pending' => ['label' => 'Menunggu', 'count' => $stats['pending'], 'color' => 'amber', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                'expired' => ['label' => 'Kadaluarsa', 'count' => $stats['expired'], 'color' => 'red', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp

        @foreach($filters as $key => $data)
            @php
                $isActive = $filter === $key;
                $bgClass = $isActive ? "bg-{$data['color']}-600 text-white shadow-lg shadow-{$data['color']}-500/30" : "bg-white text-slate-700 border-2 border-slate-100 hover:border-{$data['color']}-200 hover:shadow-md";
                $iconBgClass = $isActive ? "bg-white/20" : "bg-{$data['color']}-50 text-{$data['color']}-600";
            @endphp
            <a href="{{ route('tickets.index', array_merge(request()->query(), ['filter' => $key])) }}" 
               class="block p-3 sm:p-4 lg:p-5 rounded-xl sm:rounded-2xl transition-all duration-200 transform hover:-translate-y-1 {{ $bgClass }}">
                <div class="flex items-center justify-between mb-2 sm:mb-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl flex items-center justify-center {{ $iconBgClass }}">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}"></path>
                        </svg>
                    </div>
                    <span class="text-2xl sm:text-3xl font-black">{{ $data['count'] }}</span>
                </div>
                <p class="text-xs sm:text-sm font-bold {{ $isActive ? 'text-white' : 'text-slate-500' }} truncate">{{ $data['label'] }}</p>
            </a>
        @endforeach
    </div>

    <!-- Active Filter Indicator -->
    @if($filter !== 'all' || $search)
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-4 sm:mb-6 p-3 sm:p-4 bg-indigo-50 border border-indigo-100 rounded-lg sm:rounded-xl">
            <div class="flex items-center gap-2 flex-1 min-w-0">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <p class="text-xs sm:text-sm text-indigo-800 font-medium truncate">
                    Menampilkan: 
                    <span class="font-bold uppercase">{{ $filters[$filter]['label'] ?? 'Semua' }}</span>
                    @if($search) <span class="mx-1 sm:mx-2">•</span> Pencarian: <span class="font-bold">"{{ $search }}"</span> @endif
                </p>
            </div>
            <a href="{{ route('tickets.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 underline whitespace-nowrap">Reset Filter</a>
        </div>
    @endif

    <!-- Tickets Grid -->
    @if($transactions->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($transactions as $transaction)
                @php
                    $statusLower = strtolower($transaction->status);
                    if (in_array($statusLower, ['success', 'settlement'])) $type = 'active';
                    elseif (in_array($statusLower, ['reserved', 'pending']) && $transaction->reserved_until && $transaction->reserved_until->isFuture()) $type = 'pending';
                    else $type = 'expired';
                @endphp
                @include('partials.ticket-card', ['transaction' => $transaction, 'type' => $type])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 sm:mt-12">
            {{ $transactions->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-slate-100 p-8 sm:p-12 md:p-16 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl md:text-2xl font-black text-slate-800 mb-2">Tidak Ada Tiket Ditemukan</h3>
            <p class="text-sm sm:text-base text-slate-500 mb-6 sm:mb-8 max-w-md mx-auto px-4">
                @if($search || $filter !== 'all')
                    Tidak ada tiket yang cocok dengan filter atau pencarian Anda. Coba ubah kata kunci atau reset filter.
                @else
                    Anda belum memiliki tiket event. Jelajahi event menarik dan dapatkan tiket Anda sekarang!
                @endif
            </p>
            @if($search || $filter !== 'all')
                <a href="{{ route('tickets.index') }}" class="inline-block px-6 sm:px-8 py-2.5 sm:py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm sm:text-base hover:bg-slate-200 transition">
                    Reset Filter & Pencarian
                </a>
            @else
                <a href="{{ route('home') }}" class="inline-block px-6 sm:px-8 py-2.5 sm:py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm sm:text-base hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                    Jelajahi Event
                </a>
            @endif
        </div>
    @endif
</div>
@endsection