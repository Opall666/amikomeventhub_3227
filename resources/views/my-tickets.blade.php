@extends('layouts.app')

@section('title', 'Tiket Saya - AmikomEventHub')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-black text-slate-800 mb-2">Tiket Saya 🎫</h1>
        <p class="text-slate-500">Riwayat pembelian tiket event Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-2xl text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium mb-1">Tiket Aktif</p>
                    <p class="text-3xl font-black">{{ $activeTickets }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-2xl text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Berhasil</p>
                    <p class="text-3xl font-black">
                        {{ $successTickets }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-orange-600 p-6 rounded-2xl text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Pending</p>
                    <p class="text-3xl font-black">
                        {{ $pendingTickets }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets List -->
    @if($transactions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($transactions as $transaction)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Ticket Header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold uppercase tracking-wider text-indigo-100 mb-1">Order ID</p>
                            <p class="font-mono font-bold text-sm">{{ $transaction->order_id }}</p>
                        </div>
                    </div>

                    <!-- Ticket Body -->
                    <div class="p-6">
                        <h3 class="font-bold text-slate-800 text-lg mb-3 line-clamp-2">{{ $transaction->event->title }}</h3>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $transaction->event->date->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate">{{ $transaction->event->location }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-bold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="mb-4">
                            @php
                                $statusLower = strtolower($transaction->status);
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase 
                                @if(in_array($statusLower, ['success', 'settlement'])) bg-green-100 text-green-700
                                @elseif($statusLower === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                @if(in_array($statusLower, ['success', 'settlement']))
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Berhasil
                                @elseif($statusLower === 'pending')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Menunggu Pembayaran
                                @else
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Gagal
                                @endif
                            </span>
                        </div>

                        {{-- Countdown untuk Pending --}}
                        @if($statusLower === 'pending')
                            @php
                                $expiredAt = $transaction->created_at->copy()->addHours(24);
                                $remainingMinutes = now()->diffInMinutes($expiredAt, false);
                                
                                if ($remainingMinutes <= 0) {
                                    $remainingHours = 0;
                                    $remainingMins = 0;
                                    $isExpired = true;
                                } else {
                                    $remainingHours = floor($remainingMinutes / 60);
                                    $remainingMins = $remainingMinutes % 60;
                                    $isExpired = false;
                                }
                            @endphp
                            
                            @if(!$isExpired)
                                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                                    <p class="text-xs text-yellow-700 font-bold mb-1"> Batas Pembayaran:</p>
                                    <p class="text-sm font-bold text-yellow-800">
                                        @if($remainingHours > 0)
                                            {{ $remainingHours }} jam 
                                        @endif
                                        {{ $remainingMins }} menit lagi
                                    </p>
                                </div>
                            @else
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                                    <p class="text-xs text-red-700 font-bold">⚠️ Pembayaran Sudah Kadaluarsa</p>
                                </div>
                            @endif
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-2">
                            @if(in_array($statusLower, ['success', 'settlement']))
                                {{-- Tombol Lihat E-Ticket untuk Success --}}
                                <a href="{{ route('ticket', $transaction->order_id) }}" 
                                    class="block w-full py-3 bg-indigo-600 text-white text-center rounded-xl font-bold hover:bg-indigo-700 transition">
                                    Lihat E-Ticket
                                </a>
                            @elseif($statusLower === 'pending')
                                {{-- Cek apakah masih dalam batas waktu pembayaran --}}
                                @php
                                    $expiredAt = $transaction->created_at->copy()->addHours(24);
                                    $isExpired = now()->greaterThan($expiredAt);
                                @endphp
                                
                                @if(!$isExpired)
                                    {{-- Tombol untuk Pending yang BELUM expired --}}
                                    <a href="{{ route('checkout.payment', $transaction->order_id) }}" 
                                        class="block w-full py-3 bg-yellow-500 text-white text-center rounded-xl font-bold hover:bg-yellow-600 transition">
                                        💳 Bayar Sekarang
                                    </a>
                                    <a href="{{ route('ticket', $transaction->order_id) }}" 
                                        class="block w-full py-3 bg-slate-100 text-slate-700 text-center rounded-xl font-bold hover:bg-slate-200 transition">
                                        Detail Pesanan
                                    </a>
                                @else
                                    {{-- Tombol untuk Pending yang SUDAH expired --}}
                                    <div class="text-center py-3 text-red-600 font-bold text-sm">
                                        Pembayaran Kadaluarsa
                                    </div>
                                    <a href="{{ route('home') }}" 
                                        class="block w-full py-3 bg-slate-100 text-slate-700 text-center rounded-xl font-bold hover:bg-slate-200 transition">
                                        Pesan Event Lain
                                    </a>
                                @endif
                            @else
                                {{-- Tombol untuk Failed --}}
                                <a href="{{ route('home') }}" 
                                    class="block w-full py-3 bg-slate-100 text-slate-700 text-center rounded-xl font-bold hover:bg-slate-200 transition">
                                    Pesan Event Lain
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $transactions->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Tiket</h3>
            <p class="text-slate-500 mb-6">Anda belum membeli tiket event apapun.</p>
            <a href="{{ route('home') }}" 
                class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Jelajahi Event
            </a>
        </div>
    @endif
</div>
@endsection