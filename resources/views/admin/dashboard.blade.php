@extends('layouts.admin')

@section('title', 'Dashboard - Admin')
@section('page_title', 'Dashboard Ringkasan')
@section('page_subtitle', 'Selamat datang kembali, Admin!')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-3xl text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-2 py-1 rounded-lg">Total</span>
        </div>
        <p class="text-indigo-100 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-3xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        <p class="text-indigo-200 text-xs mt-2">Dari transaksi berhasil</p>
    </div>

    <!-- Tickets Sold -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-3xl text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                    </path>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-2 py-1 rounded-lg">Sold</span>
        </div>
        <p class="text-green-100 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-3xl font-black">{{ number_format($totalTicketsSold) }}</h3>
        <p class="text-green-200 text-xs mt-2">Transaksi berhasil</p>
    </div>

    <!-- Active Events -->
    <div class="bg-gradient-to-br from-orange-500 to-red-600 p-6 rounded-3xl text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-2 py-1 rounded-lg">Active</span>
        </div>
        <p class="text-orange-100 text-sm font-bold uppercase mb-1">Event Aktif</p>
        <h3 class="text-3xl font-black">{{ $activeEvents }}</h3>
        <p class="text-orange-200 text-xs mt-2">Event yang akan datang</p>
    </div>

    <!-- Pending Orders -->
    <div class="bg-gradient-to-br from-yellow-500 to-amber-600 p-6 rounded-3xl text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-2 py-1 rounded-lg">Pending</span>
        </div>
        <p class="text-yellow-100 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
        <h3 class="text-3xl font-black">{{ $pendingOrders }}</h3>
        <p class="text-yellow-200 text-xs mt-2">Menunggu pembayaran</p>
    </div>
</div>

<!-- Grid 2 Kolom -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <!-- Recent Transactions -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h3 class="font-black text-xl text-slate-800">Transaksi Terbaru</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline text-sm">
                Lihat Semua →
            </a>
        </div>
        <div class="divide-y">
            @forelse($recentTransactions as $transaction)
                <div class="p-6 hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-lg">
                                    {{ strtoupper(substr($transaction->customer_name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $transaction->customer_name }}</p>
                                <p class="text-xs text-slate-500">{{ $transaction->event->title ?? 'Event Deleted' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                            @php
                                $statusLower = strtolower($transaction->status);
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-lg text-xs font-bold uppercase
                                @if(in_array($statusLower, ['success', 'settlement'])) bg-green-100 text-green-700
                                @elseif($statusLower === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ $transaction->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-slate-500">
                    Belum ada transaksi
                </div>
            @endforelse
        </div>
    </div>

    <!-- Top Events -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="font-black text-xl text-slate-800">Event Terlaris</h3>
            <p class="text-sm text-slate-500 mt-1">Berdasarkan pendapatan</p>
        </div>
        <div class="divide-y">
            @forelse($topEvents as $index => $event)
                <div class="p-6 hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                #{{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $event->title }}</p>
                                <p class="text-xs text-slate-500">{{ $event->total_sold }} tiket terjual</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-indigo-600">Rp {{ number_format($event->total_revenue ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-slate-500">
                    Belum ada data
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
    <h3 class="font-black text-xl text-slate-800 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.events.create') }}" class="p-4 bg-indigo-50 rounded-2xl hover:bg-indigo-100 transition text-center">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <p class="font-bold text-slate-800 text-sm">Tambah Event</p>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="p-4 bg-purple-50 rounded-2xl hover:bg-purple-100 transition text-center">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <p class="font-bold text-slate-800 text-sm">Kelola Kategori</p>
        </a>
        <a href="{{ route('admin.partners.index') }}" class="p-4 bg-green-50 rounded-2xl hover:bg-green-100 transition text-center">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="font-bold text-slate-800 text-sm">Kelola Partner</p>
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="p-4 bg-orange-50 rounded-2xl hover:bg-orange-100 transition text-center">
            <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <p class="font-bold text-slate-800 text-sm">Lihat Transaksi</p>
        </a>
    </div>
</div>
@endsection