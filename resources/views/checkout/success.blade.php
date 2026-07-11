@extends('layouts.app')

@section('title', 'Status Pembayaran - ' . $transaction->order_id)

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        
        {{-- KONDISI 1: PEMBAYARAN SUKSES --}}
        @if($transaction->status === 'success')
            <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-4 text-green-600">Pembayaran Berhasil!</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Terima kasih! Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong> telah terkonfirmasi.
                E-Ticket Anda akan segera dikirim ke <strong>{{ $transaction->customer_email }}</strong>.
            </p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('ticket', $transaction->order_id) }}" class="w-full px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Lihat E-Ticket Saya
                </a>
                <a href="{{ route('home') }}" class="w-full px-8 py-4 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition">
                    Kembali ke Beranda
                </a>
            </div>

        {{-- KONDISI 2: PEMBAYARAN PENDING (Belum Dibayar / Menunggu) --}}
        @elseif($transaction->status === 'pending')
            <div class="w-24 h-24 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-4 text-yellow-600">Menunggu Pembayaran</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Pesanan <strong>{{ $transaction->order_id }}</strong> Anda sedang menunggu pembayaran. 
                Silakan selesaikan pembayaran sebelum batas waktu habis agar tiket tidak dibatalkan.
            </p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('tickets.index') }}" class="w-full px-8 py-4 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition">
                    Cek Tiket Saya
                </a>
                <a href="{{ route('home') }}" class="w-full px-8 py-4 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition">
                    Kembali ke Beranda
                </a>
            </div>

        {{-- KONDISI 3: PEMBAYARAN GAGAL / EXPIRED --}}
        @else
            <div class="w-24 h-24 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black mb-4 text-red-600">Pembayaran Gagal</h2>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Maaf, pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong> gagal atau kedaluwarsa. 
                Silakan lakukan pemesanan ulang.
            </p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="w-full px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Pesan Event Lain
                </a>
            </div>
        @endif

    </div>
</main>
@endsection