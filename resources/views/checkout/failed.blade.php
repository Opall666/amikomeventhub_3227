@extends('layouts.app')

@section('title', 'Pembayaran Gagal - ' . $transaction->order_id)

@section('content')
<main class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-rose-50 py-12 px-4">
    <div class="max-w-xl mx-auto">
        
        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header dengan Gradient -->
            <div class="bg-gradient-to-r from-red-500 via-rose-500 to-pink-500 p-8 text-center text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-4 left-4 w-16 h-16 border-4 border-white rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-24 h-24 border-4 border-white rounded-full"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black mb-2">Pembayaran Gagal</h1>
                    <p class="text-white/90 text-sm">Transaksi tidak dapat diproses</p>
                </div>
            </div>

            <!-- Body -->
            <div class="p-8 space-y-6">
                
                <!-- Order Info -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Order ID</p>
                    <p class="font-mono font-bold text-slate-800">{{ $transaction->order_id }}</p>
                </div>

                <!-- Event Info -->
                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-2xl p-5 border border-slate-100">
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Event</p>
                    <h2 class="font-bold text-slate-800 text-lg">{{ $transaction->event->title }}</h2>
                </div>

                <!-- Warning Message -->
                <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold text-red-900 mb-1">Transaksi Gagal atau Kadaluarsa</h3>
                            <p class="text-sm text-red-800">
                                Pembayaran untuk pesanan ini tidak berhasil diproses. 
                                Stok tiket telah dikembalikan dan tersedia untuk pembeli lain.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('home') }}" 
                        class="block w-full py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white rounded-2xl font-bold shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-200 text-center">
                         Pesan Event Lain
                    </a>
                    
                    <a href="{{ route('tickets.index') }}" 
                        class="block w-full py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold text-center hover:bg-slate-200 transition">
                        ← Kembali ke Tiket Saya
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Text -->
        <div class="mt-6 text-center">
            <p class="text-slate-400 text-xs">
                Jika Anda mengalami masalah, silakan hubungi tim support kami.
            </p>
        </div>
    </div>
</main>
@endsection