@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - AmikomEventHub')

@section('content')
<!-- Header -->
<div class="bg-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-slate-800 mb-3">Syarat & Ketentuan</h1>
        <p class="text-slate-600 text-lg">Berlaku efektif sejak 1 Juni 2026</p>
    </div>
</div>

<!-- Content -->
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white border border-slate-200 rounded-2xl p-8 md:p-12 space-y-8 text-slate-700 leading-relaxed">
        
        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">1. Pemesanan Tiket</h2>
            <p>Dengan melakukan pemesanan tiket melalui AmikomEventHub, Anda menyetujui untuk terikat dengan syarat dan ketentuan berikut. Harap membaca dengan teliti sebelum melakukan transaksi.</p>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">2. Pembayaran & Konfirmasi</h2>
            <p>Pembayaran harus diselesaikan dalam waktu yang ditentukan. E-Ticket akan dikirimkan ke alamat email yang Anda daftarkan segera setelah pembayaran berhasil dikonfirmasi oleh sistem.</p>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">3. Kebijakan Refund</h2>
            <p class="text-red-600 font-medium">Tiket yang telah dibeli tidak dapat dikembalikan (non-refundable) dan tidak dapat ditukar dengan uang tunai.</p>
            <p class="mt-2">Namun, tiket dapat dipindahtangankan kepada orang lain dengan menunjukkan E-Ticket asli saat check-in di lokasi acara.</p>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">4. Check-in di Lokasi</h2>
            <p>Peserta wajib menunjukkan E-Ticket (cetak atau digital) beserta identitas diri yang valid saat melakukan registrasi ulang di lokasi acara. Panitia berhak menolak masuk jika identitas tidak sesuai.</p>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">5. Perubahan Acara</h2>
            <p>Penyelenggara berhak mengubah jadwal, lokasi, atau pembicara acara sewaktu-waktu karena alasan yang tidak dapat dihindari. Informasi perubahan akan diumumkan melalui email dan website resmi.</p>
        </div>

    </div>
</div>
@endsection