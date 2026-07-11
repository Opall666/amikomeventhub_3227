@extends('layouts.app')

@section('title', 'E-Ticket - ' . $transaction->order_id)

@section('content')
<!-- CSS Khusus untuk Print/PDF -->
<style>
    @media print {
        nav, footer, .no-print {
            display: none !important;
        }
        body {
            background: white !important;
            margin: 0;
            padding: 0;
        }
        .bg-gradient-to-br {
            background: white !important;
            padding: 20px 0 !important;
            min-height: auto !important;
        }
        .bg-white.rounded-3xl {
            box-shadow: none !important;
            border: 2px dashed #cbd5e1 !important;
            margin: 0 auto !important;
            max-width: 600px !important;
            page-break-inside: avoid;
        }
        * {
            transform: none !important;
        }
    }
</style>

@php
    $statusLower = strtolower($transaction->status);
    $isExpired = $transaction->isExpired();
@endphp

<div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        
        <!-- Dynamic Header -->
        <div class="text-center mb-8">
            @if(in_array($statusLower, ['success', 'settlement']))
                {{-- Header Sukses --}}
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full mb-6 border-4 border-white/30 shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-white mb-2">Pembayaran Berhasil! 🎉</h1>
                <p class="text-indigo-100 text-lg">Tiket Anda telah terbit dan siap digunakan.</p>
            @elseif(in_array($statusLower, ['reserved', 'pending']) && !$isExpired)
                {{-- Header Reserved/Pending (Belum Bayar) --}}
                <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-400/30 backdrop-blur-sm rounded-full mb-6 border-4 border-yellow-300/50 shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-white mb-2">Menunggu Pembayaran ⏳</h1>
                <p class="text-indigo-100 text-lg">Silakan selesaikan pembayaran untuk mendapatkan E-Ticket Anda.</p>
            @elseif(in_array($statusLower, ['reserved', 'pending']) && $isExpired)
                {{-- Header Expired --}}
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-400/30 backdrop-blur-sm rounded-full mb-6 border-4 border-red-300/50 shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-white mb-2">Pembayaran Kadaluarsa ⏰</h1>
                <p class="text-indigo-100 text-lg">Waktu pembayaran telah habis. Silakan lakukan checkout ulang.</p>
            @else
                {{-- Header Gagal --}}
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-400/30 backdrop-blur-sm rounded-full mb-6 border-4 border-red-300/50 shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-white mb-2">Pembayaran Gagal ❌</h1>
                <p class="text-indigo-100 text-lg">Maaf, transaksi Anda tidak berhasil diproses.</p>
            @endif
        </div>

        <!-- E-Ticket Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-6">
            <!-- Ticket Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-center relative overflow-hidden">
                <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest mb-2 relative z-10">E-Ticket Resmi</p>
                <h2 class="text-2xl font-black text-white leading-tight relative z-10">{{ $transaction->event->title }}</h2>
                <div class="absolute -left-6 bottom-0 w-12 h-12 bg-white rounded-full"></div>
                <div class="absolute -right-6 bottom-0 w-12 h-12 bg-white rounded-full"></div>
            </div>

            <!-- Ticket Body -->
            <div class="p-8 space-y-6">
                <!-- Event Info Grid -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Nama Pembeli</p>
                        <p class="font-bold text-slate-800 text-lg">{{ $transaction->customer_name }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Tanggal & Waktu</p>
                        <p class="font-bold text-slate-800 text-lg">{{ $transaction->event->date->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Order ID</p>
                        <p class="font-bold text-indigo-600 font-mono text-lg">{{ $transaction->order_id }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Lokasi</p>
                        <p class="font-bold text-slate-800 text-lg">{{ $transaction->event->location }}</p>
                    </div>
                </div>

                <!-- QR Code Section -->
                @if(in_array($statusLower, ['success', 'settlement']))
                    <!-- QR Code HANYA muncul jika status SUCCESS -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-8 rounded-2xl border-2 border-dashed border-slate-300 flex flex-col items-center">
                        <p class="text-slate-500 text-xs font-bold uppercase mb-4 tracking-wider">Scan QR untuk Check-in</p>
                        <div class="w-48 h-48 bg-white p-4 rounded-xl shadow-inner mb-4">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($transaction->order_id) }}" 
                                alt="QR Code" width="150" height="150" class="w-full h-full">
                        </div>
                        <p class="font-mono font-bold text-slate-700 text-sm">{{ $transaction->order_id }}</p>
                    </div>
                @else
                    <!-- Pesan untuk yang BELUM BAYAR -->
                    <div class="bg-yellow-50 border-2 border-yellow-200 p-8 rounded-2xl text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-yellow-800 mb-2">Pembayaran Belum Selesai</h3>
                        <p class="text-yellow-700 text-sm mb-4">Silakan selesaikan pembayaran untuk mendapatkan E-Ticket dan QR Code.</p>
                        
                        @if(in_array($statusLower, ['reserved', 'pending']) && !$isExpired)
                            <a href="{{ route('checkout.payment', $transaction->order_id) }}" 
                            class="inline-block px-6 py-3 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition">
                                💳 Lanjutkan Pembayaran
                            </a>
                        @elseif($isExpired)
                            <a href="{{ route('home') }}" 
                            class="inline-block px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition">
                                Pesan Event Lain
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Status Badge -->
                <div class="text-center">
                    @if(in_array($statusLower, ['success', 'settlement']))
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-green-100 text-green-700 border-2 border-green-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Status: Berhasil
                        </span>
                    @elseif(in_array($statusLower, ['reserved', 'pending']) && !$isExpired)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700 border-2 border-yellow-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Status: Menunggu Pembayaran
                        </span>
                    @elseif(in_array($statusLower, ['reserved', 'pending']) && $isExpired)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-700 border-2 border-red-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Status: Kadaluarsa
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-700 border-2 border-red-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Status: {{ ucfirst($statusLower) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Ticket Footer -->
            <div class="px-8 pb-8 space-y-3 no-print">
                @if(in_array($statusLower, ['success', 'settlement']))
                    <button onclick="window.print()" 
                        class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak / Simpan PDF
                    </button>
                @elseif(in_array($statusLower, ['reserved', 'pending']) && !$isExpired)
                    <a href="{{ route('checkout.payment', $transaction->order_id) }}" 
                        class="block w-full py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-center rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all">
                        💳 Lanjutkan Pembayaran
                    </a>
                @endif
                
                <a href="{{ route('tickets.index') }}" 
                    class="block text-center py-3 text-slate-500 font-bold hover:text-indigo-600 transition">
                    ← Kembali ke Tiket Saya
                </a>
            </div>
        </div>

        <!-- Info Card (hanya untuk yang sudah bayar) -->
        @if(in_array($statusLower, ['success', 'settlement']))
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center no-print">
                <p class="text-indigo-100 text-sm mb-2">✅ E-Ticket telah dikirim ke email Anda</p>
                <p class="text-indigo-200 text-xs">{{ $transaction->customer_email }}</p>
            </div>
        @endif

    </div>
</div>
@endsection