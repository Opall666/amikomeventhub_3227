@extends('layouts.app')

@section('title', 'Cara Kerja - AmikomEventHub')

@section('content')
<!-- Header -->
<div class="bg-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-slate-800 mb-3">Cara Pesan & Bayar</h1>
        <p class="text-slate-600 text-lg max-w-2xl mx-auto">
            Panduan lengkap memesan tiket event di AmikomEventHub
        </p>
    </div>
</div>

<!-- Steps -->
<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Step 1 -->
        <div class="relative p-8 bg-white border border-slate-200 rounded-2xl hover:shadow-lg transition">
            <div class="absolute -top-4 -left-4 w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg">
                1
            </div>
            <div class="pt-4">
                <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Jelajahi Event</h3>
                <p class="text-slate-600">
                    Browse berbagai event menarik berdasarkan kategori, tanggal, atau lokasi favorit Anda.
                </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="relative p-8 bg-white border border-slate-200 rounded-2xl hover:shadow-lg transition">
            <div class="absolute -top-4 -left-4 w-12 h-12 bg-purple-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg">
                2
            </div>
            <div class="pt-4">
                <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pilih & Checkout</h3>
                <p class="text-slate-600">
                    Klik "Lihat Detail" pada event pilihan, lalu isi data diri Anda di halaman checkout.
                </p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="relative p-8 bg-white border border-slate-200 rounded-2xl hover:shadow-lg transition">
            <div class="absolute -top-4 -left-4 w-12 h-12 bg-pink-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg">
                3
            </div>
            <div class="pt-4">
                <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pembayaran Aman</h3>
                <p class="text-slate-600">
                    Lakukan pembayaran melalui GoPay, QRIS, Virtual Account, atau Kartu Kredit/Debit.
                </p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="relative p-8 bg-white border border-slate-200 rounded-2xl hover:shadow-lg transition">
            <div class="absolute -top-4 -left-4 w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-lg">
                4
            </div>
            <div class="pt-4">
                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Terima E-Ticket</h3>
                <p class="text-slate-600">
                    E-Ticket akan dikirim ke email Anda. Tunjukkan QR Code saat check-in di lokasi event.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-20 max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-slate-800 text-center mb-10">Pertanyaan Umum</h2>
        <div class="space-y-4">
            <div class="p-6 bg-white border border-slate-200 rounded-xl">
                <h3 class="font-bold text-slate-800 mb-2">Metode pembayaran apa saja yang tersedia?</h3>
                <p class="text-slate-600">Kami menerima pembayaran via GoPay, QRIS, Virtual Account (BCA, BNI, BRI, Mandiri), dan Kartu Kredit/Debit.</p>
            </div>
            <div class="p-6 bg-white border border-slate-200 rounded-xl">
                <h3 class="font-bold text-slate-800 mb-2">Apakah tiket bisa direfund?</h3>
                <p class="text-slate-600">Tiket yang sudah dibeli tidak dapat direfund, namun dapat dipindahtangankan ke orang lain dengan menunjukkan E-Ticket.</p>
            </div>
            <div class="p-6 bg-white border border-slate-200 rounded-xl">
                <h3 class="font-bold text-slate-800 mb-2">Bagaimana jika saya tidak menerima E-Ticket?</h3>
                <p class="text-slate-600">Silakan cek folder Spam/Promotions di email Anda. Jika masih tidak ada, hubungi kami di support@amikom.ac.id.</p>
            </div>
            <div class="p-6 bg-white border border-slate-200 rounded-xl">
                <h3 class="font-bold text-slate-800 mb-2">Apakah perlu akun untuk membeli tiket?</h3>
                <p class="text-slate-600">Ya, Anda perlu login untuk melakukan checkout. Registrasi gratis dan cepat!</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="mt-16 text-center">
        <a href="{{ route('home') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg">
            🎯 Mulai Jelajahi Event
        </a>
    </div>
</div>
@endsection