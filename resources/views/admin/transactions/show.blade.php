@extends('layouts.admin')

@section('title', 'Detail Transaksi - Admin')
@section('page_title', 'Detail Transaksi')
@section('page_subtitle', 'Order ID: ' . $transaction->order_id)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold mb-6 hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Transaksi
    </a>

    <!-- Transaction Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <!-- Header dengan Gradient -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider mb-2">Order ID</p>
                    <h2 class="text-2xl font-black font-mono">{{ $transaction->order_id }}</h2>
                    <p class="text-indigo-100 text-sm mt-2">
                        Dibuat: {{ $transaction->created_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-bold uppercase
                    @if($transaction->status === 'Success') bg-green-500
                    @elseif($transaction->status === 'Pending') bg-yellow-500
                    @elseif($transaction->status === 'Failed') bg-red-500
                    @else bg-slate-500 @endif">
                    {{ $transaction->status }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-8">
            
            <!-- Event Info -->
            <div>
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                    Informasi Event
                </h3>
                <div class="bg-slate-50 rounded-2xl p-6">
                    @if($transaction->event)
                        <h4 class="font-bold text-slate-800 text-xl mb-4">{{ $transaction->event->title }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="text-slate-500 mb-1">📅 Tanggal</p>
                                <p class="font-bold text-slate-800">{{ $transaction->event->date->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 mb-1">📍 Lokasi</p>
                                <p class="font-bold text-slate-800">{{ $transaction->event->location }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 mb-1">🏷️ Kategori</p>
                                <p class="font-bold text-slate-800">{{ $transaction->event->category->name ?? '-' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-slate-500 italic">Event sudah dihapus</p>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <div>
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </span>
                    Informasi Pembeli
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-slate-500 text-xs font-bold uppercase mb-1">Nama</p>
                        <p class="font-bold text-slate-800">{{ $transaction->customer_name }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-slate-500 text-xs font-bold uppercase mb-1">Email</p>
                        <p class="font-bold text-slate-800 break-all">{{ $transaction->customer_email }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <p class="text-slate-500 text-xs font-bold uppercase mb-1">No. Telepon</p>
                        <p class="font-bold text-slate-800">{{ $transaction->customer_phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div>
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    Informasi Pembayaran
                </h3>
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-slate-600 font-medium">Total Pembayaran</span>
                        <span class="text-3xl font-black text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-indigo-200 pt-4 text-sm text-slate-500 space-y-1">
                        <p>🕐 Transaksi dibuat: <span class="font-bold text-slate-700">{{ $transaction->created_at->format('d M Y, H:i') }}</span></p>
                        <p>🔄 Terakhir diupdate: <span class="font-bold text-slate-700">{{ $transaction->updated_at->format('d M Y, H:i') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Status Information (Read-Only) -->
            <div>
                <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    Status Transaksi
                </h3>
                
                @php
                    $statusLower = strtolower($transaction->status);
                @endphp
                
                <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-6 border-2 border-slate-200">
                    <!-- Status Badge -->
                    <div class="flex items-center gap-3 mb-4">
                        @if(in_array($statusLower, ['success', 'settlement']))
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-bold uppercase mb-1">Status Pembayaran</p>
                                <p class="text-2xl font-black text-green-600">✅ Berhasil</p>
                            </div>
                        @elseif($statusLower === 'pending')
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-bold uppercase mb-1">Status Pembayaran</p>
                                <p class="text-2xl font-black text-yellow-600">⏳ Menunggu Pembayaran</p>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-bold uppercase mb-1">Status Pembayaran</p>
                                <p class="text-2xl font-black text-red-600">❌ {{ ucfirst($statusLower) }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Info Box -->
                    <div class="bg-white rounded-xl p-4 border border-slate-200">
                        <p class="text-sm text-slate-600 mb-2">
                            <strong>ℹ️ Informasi:</strong>
                        </p>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Status transaksi diperbarui secara otomatis oleh sistem pembayaran Midtrans melalui webhook. 
                            Admin tidak dapat mengubah status secara manual untuk menjaga integritas data pembayaran.
                        </p>
                    </div>
                    
                    @if(in_array($statusLower, ['success', 'settlement']))
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-xs text-green-700">
                                ✅ Pembayaran telah diverifikasi otomatis oleh Midtrans pada {{ $transaction->updated_at->format('d M Y, H:i') }} WIB
                            </p>
                        </div>
                    @elseif($statusLower === 'pending')
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <p class="text-xs text-yellow-700">
                                Menunggu konfirmasi pembayaran dari Midtrans. Batas waktu: {{ $transaction->created_at->addHours(24)->format('d M Y, H:i') }} WIB
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection