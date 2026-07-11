@php
    $statusLower = strtolower($transaction->status);
    $isExpired = $transaction->isExpired();
@endphp

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
        <h3 class="font-bold text-slate-800 text-lg mb-3 line-clamp-2">{{ $transaction->event->title ?? 'Event Tidak Ditemukan' }}</h3>
        
        @if($transaction->event)
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
        @endif

        <!-- Status Badge -->
        <div class="mb-4">
            @if($type === 'active')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-green-100 text-green-700">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Berhasil
                </span>
            @elseif($type === 'pending')
                @php
                    $remainingMinutes = now()->diffInMinutes($transaction->reserved_until, false);
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-amber-100 text-amber-700">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Menunggu Pembayaran
                </span>
                @if($remainingMinutes > 0)
                    <div class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-xs text-amber-700 font-bold">
                            ⏰ {{ (int)$remainingMinutes }} menit lagi
                        </p>
                    </div>
                @endif
            @elseif($type === 'expired')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-red-100 text-red-700">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Kadaluarsa
                </span>
            @elseif($type === 'cancelled')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-slate-200 text-slate-700">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    {{ ucfirst($statusLower) }}
                </span>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2">
            @if($type === 'active')
                <a href="{{ route('ticket', $transaction->order_id) }}" 
                    class="block w-full py-3 bg-indigo-600 text-white text-center rounded-xl font-bold hover:bg-indigo-700 transition">
                    Lihat E-Ticket
                </a>
            @elseif($type === 'pending')
                <a href="{{ route('checkout.payment', $transaction->order_id) }}" 
                    class="block w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-center rounded-xl font-bold hover:from-amber-600 hover:to-orange-600 transition shadow-lg">
                    💳 Lanjutkan Pembayaran
                </a>
                <form action="{{ route('checkout.cancel', $transaction->order_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?\n\nStok tiket akan dikembalikan.');">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-red-50 text-red-600 border-2 border-red-200 rounded-xl font-bold hover:bg-red-100 transition">
                        Batalkan Pesanan
                    </button>
                </form>
            @elseif($type === 'expired' || $type === 'cancelled')
                <a href="{{ route('home') }}" 
                    class="block w-full py-3 bg-slate-100 text-slate-700 text-center rounded-xl font-bold hover:bg-slate-200 transition">
                    Pesan Event Lain
                </a>
            @endif
        </div>
    </div>
</div>