@extends('layouts.app')

@section('title', 'Tentang Kami - AmikomEventHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl font-black text-white mb-4">Tentang Kami</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">
            Platform event terpercaya untuk mahasiswa dan profesional Indonesia
        </p>
    </div>
</section>

<!-- About Content -->
<section class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
        <div>
            <h2 class="text-4xl font-black text-slate-800 mb-6">
                Siapa Kami?
            </h2>
            <p class="text-lg text-slate-600 leading-relaxed mb-6">
                <strong class="text-indigo-600">AmikomEventHub</strong> adalah platform reservasi tiket event online yang dirancang khusus untuk memudahkan mahasiswa, profesional, dan penyelenggara event dalam mengelola dan mengikuti berbagai acara.
            </p>
            <p class="text-lg text-slate-600 leading-relaxed mb-6">
                Dari seminar, workshop, konser musik, hingga hackathon - kami menyediakan akses mudah ke berbagai event berkualitas yang dapat membantu pengembangan karir dan passion Anda.
            </p>
            <div class="flex gap-4">
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-slate-700">Aman & Terpercaya</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-slate-700">Proses Cepat</span>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-3xl p-12 flex items-center justify-center">
            <div class="w-32 h-32 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center text-white text-6xl font-black shadow-2xl">
                AH
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-20">
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:border-indigo-300 hover:shadow-xl transition">
            <p class="text-5xl font-black text-indigo-600 mb-2">{{ $stats['events'] }}</p>
            <p class="text-slate-600 font-bold">Event Tersedia</p>
        </div>
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:border-indigo-300 hover:shadow-xl transition">
            <p class="text-5xl font-black text-purple-600 mb-2">{{ $stats['tickets'] }}</p>
            <p class="text-slate-600 font-bold">Tiket Terjual</p>
        </div>
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:border-indigo-300 hover:shadow-xl transition">
            <p class="text-5xl font-black text-pink-600 mb-2">{{ $stats['categories'] }}</p>
            <p class="text-slate-600 font-bold">Kategori</p>
        </div>
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:border-indigo-300 hover:shadow-xl transition">
            <p class="text-5xl font-black text-orange-600 mb-2">{{ $stats['partners'] }}</p>
            <p class="text-slate-600 font-bold">Partner</p>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl p-10">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-4">Visi Kami</h3>
            <p class="text-slate-600 leading-relaxed">
                Menjadi platform event terdepan di Indonesia yang menghubungkan penyelenggara event berkualitas dengan peserta yang antusias, menciptakan ekosistem event yang saling menguntungkan.
            </p>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-10">
            <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-4">Misi Kami</h3>
            <ul class="space-y-3 text-slate-600">
                <li class="flex items-start gap-2">
                    <span class="text-purple-600 font-bold">✓</span>
                    <span>Menyediakan platform yang mudah dan aman untuk pemesanan tiket event</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-600 font-bold">✓</span>
                    <span>Membantu penyelenggara event menjangkau audiens yang lebih luas</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-600 font-bold">✓</span>
                    <span>Memberikan pengalaman terbaik dalam mengikuti berbagai event berkualitas</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-black text-slate-800 mb-4">Mengapa Memilih Kami?</h2>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Kami berkomitmen untuk memberikan layanan terbaik bagi para pengguna
        </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:shadow-xl transition">
            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Pembayaran Aman</h3>
            <p class="text-slate-600">Transaksi terjamin keamanannya dengan sistem pembayaran terpercaya</p>
        </div>
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:shadow-xl transition">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Proses Cepat</h3>
            <p class="text-slate-600">Pemesanan tiket yang mudah dan cepat dalam hitungan menit</p>
        </div>
        <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 text-center hover:shadow-xl transition">
            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Event Berkualitas</h3>
            <p class="text-slate-600">Hanya event-event terbaik yang kami tampilkan di platform</p>
        </div>
    </div>
</section>
@endsection