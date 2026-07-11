@extends('layouts.app')

@section('title', 'Pembayaran - ' . $transaction->event->title)

@section('content')
<main class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        
        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header dengan Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 text-center text-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-4 left-4 w-20 h-20 border-4 border-white rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-32 h-32 border-4 border-white rounded-full"></div>
                    <div class="absolute top-1/2 right-10 w-12 h-12 border-2 border-white rounded-full"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black mb-2">Selesaikan Pembayaran</h1>
                    <p class="text-indigo-100 text-lg">{{ $transaction->event->title }}</p>
                </div>
            </div>

            <!-- Body -->
            <div class="p-8 space-y-6">
                
                <!-- Info Box -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold text-blue-900 mb-2">💡 Informasi Penting:</h3>
                            <ul class="space-y-1.5 text-sm text-blue-800">
                                <li class="flex items-start gap-2">
                                    <span class="text-green-600 font-bold">✓</span>
                                    <span>Klik tombol <strong>"Bayar Sekarang"</strong> untuk membuka popup pembayaran</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-600 font-bold">✓</span>
                                    <span>Pilih metode pembayaran (QRIS, VA, dll) dan selesaikan pembayaran</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-green-600 font-bold">✓</span>
                                    <span>Anda bisa menutup popup (tombol X) dan buka lagi selama <strong>15 menit</strong></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Countdown Timer -->
                @php
                    $reservedUntil = \Carbon\Carbon::parse($transaction->reserved_until);
                    $remainingSeconds = max(0, (int) now()->diffInSeconds($reservedUntil, false));
                    $remainingHours = (int) floor($remainingSeconds / 3600);
                    $remainingMinutes = (int) floor(($remainingSeconds % 3600) / 60);
                    $remainingSecs = (int) ($remainingSeconds % 60);
                @endphp
                
                @if($remainingSeconds > 0)
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-300 rounded-2xl p-6 text-center">
                        <div class="flex items-center justify-center gap-2 mb-3">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-amber-900 font-bold text-sm uppercase tracking-wide">Batas Waktu Pembayaran</p>
                        </div>
                        
                        <!-- Digital Countdown Display -->
                        <div class="flex items-center justify-center gap-3 mb-3" id="countdown-display">
                            @if($remainingHours > 0)
                                <div class="bg-white rounded-xl p-3 shadow-lg min-w-[70px]">
                                    <div class="text-3xl font-black text-amber-700 font-mono" id="hours">{{ str_pad($remainingHours, 2, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-xs font-bold text-amber-600 uppercase">Jam</div>
                                </div>
                                <span class="text-3xl font-black text-amber-400">:</span>
                            @endif
                            <div class="bg-white rounded-xl p-3 shadow-lg min-w-[70px]">
                                <div class="text-3xl font-black text-amber-700 font-mono" id="minutes">{{ str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs font-bold text-amber-600 uppercase">Menit</div>
                            </div>
                            <span class="text-3xl font-black text-amber-400">:</span>
                            <div class="bg-white rounded-xl p-3 shadow-lg min-w-[70px]">
                                <div class="text-3xl font-black text-amber-700 font-mono" id="seconds">{{ str_pad($remainingSecs, 2, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs font-bold text-amber-600 uppercase">Detik</div>
                            </div>
                        </div>
                        
                        <p class="text-xs text-amber-700 mt-3 font-medium">⏰ Setelah waktu habis, pesanan akan otomatis dibatalkan</p>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-300 rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-red-900 mb-2">⏰ Waktu Pembayaran Telah Habis</h3>
                        <p class="text-red-700 text-sm mb-4">Pesanan Anda telah dibatalkan secara otomatis.</p>
                        <a href="{{ route('tickets.index') }}" class="inline-block px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">
                            ← Kembali ke Tiket Saya
                        </a>
                    </div>
                @endif

                <!-- Total Tagihan -->
                <div class="bg-gradient-to-br from-slate-50 to-indigo-50 rounded-2xl p-6 border-2 border-indigo-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-slate-600 font-medium">Total Pembayaran</span>
                        <span class="text-3xl font-black text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-indigo-200 pt-3 text-sm">
                        <p class="text-slate-500 font-mono text-xs">Order ID: <span class="font-bold text-slate-700">{{ $transaction->order_id }}</span></p>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($remainingSeconds > 0)
                    <div class="space-y-3">
                        <button id="pay-button" class="w-full py-5 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:shadow-2xl hover:scale-[1.02] transition-all duration-200">
                            💳 Bayar Sekarang
                        </button>

                        <!-- Tombol Batalkan Pesanan -->
                        <form action="{{ route('checkout.cancel', $transaction->order_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?\n\nStok tiket akan dikembalikan dan pesanan tidak dapat dilanjutkan.');">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-red-50 text-red-600 border-2 border-red-200 rounded-xl font-bold hover:bg-red-100 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batalkan Pesanan
                            </button>
                        </form>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('tickets.index') }}" class="py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-center hover:bg-slate-200 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Tiket Saya
                            </a>
                            <a href="{{ route('home') }}" class="py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-center hover:bg-slate-200 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Beranda
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Security Badge -->
        <div class="mt-6 text-center">
            <div class="inline-flex items-center gap-2 text-slate-400 text-sm">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span>Pembayaran aman & terenkripsi dengan Midtrans</span>
            </div>
        </div>
    </div>
</main>

<!-- Script Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onPending: function(result){
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onError: function(result){
                alert("Pembayaran Gagal! Silakan coba lagi.");
            },
            onClose: function(){
                alert(
                    "Anda menutup jendela pembayaran.\n\n" +
                    "Pesanan Anda masih tersimpan. Silakan klik 'Bayar Sekarang' lagi untuk melanjutkan pembayaran."
                );
            }
        });
    };

    // Countdown Timer JavaScript
    @if($remainingSeconds > 0)
    (function() {
        let totalSeconds = {{ $remainingSeconds }};
        
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        
        const interval = setInterval(function() {
            totalSeconds--;
            
            if (totalSeconds <= 0) {
                clearInterval(interval);
                // Tampilkan pesan waktu habis
                document.getElementById('countdown-display').innerHTML = '<div class="text-2xl font-black text-red-600">Waktu Habis!</div>';
                // Redirect setelah 3 detik
                setTimeout(function() {
                    window.location.href = "{{ route('tickets.index') }}?expired=1";
                }, 3000);
                return;
            }
            
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            // Update display dengan padding 0
            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        }, 1000);
    })();
    @endif
</script>
@endsection