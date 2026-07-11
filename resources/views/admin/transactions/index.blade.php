@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
<!-- Filter & Search -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 md:p-6 mb-6">
    <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari Order ID, Nama, atau Email..."
                class="w-full px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition">
        </div>
        
        <!-- Status Filter -->
        <select name="status" class="px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition">
            <option value="">Semua Status</option>
            <option value="Success" {{ request('status') === 'Success' ? 'selected' : '' }}>Success</option>
            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Failed" {{ request('status') === 'Failed' ? 'selected' : '' }}>Failed</option>
            <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        
        <!-- Submit -->
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
            Filter
        </button>
        
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.transactions.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-4 md:px-8 py-4">Order ID</th>
                    <th class="px-4 md:px-8 py-4">Pembeli</th>
                    <th class="px-4 md:px-8 py-4">Event</th>
                    <th class="px-4 md:px-8 py-4">Total</th>
                    <th class="px-4 md:px-8 py-4">Status</th>
                    <th class="px-4 md:px-8 py-4">Tanggal</th>
                    <th class="px-4 md:px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 md:px-8 py-6">
                            <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-sm">
                                {{ $transaction->order_id }}
                            </span>
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <p class="font-bold text-slate-800">{{ $transaction->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $transaction->customer_email }}</p>
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <p class="font-medium text-slate-700">{{ $transaction->event->title ?? 'Event Deleted' }}</p>
                        </td>
                        <td class="px-4 md:px-8 py-6 font-black text-slate-900">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase
                                @if($transaction->status === 'Success') bg-green-100 text-green-700
                                @elseif($transaction->status === 'Pending') bg-yellow-100 text-yellow-700
                                @elseif($transaction->status === 'Failed') bg-red-100 text-red-700
                                @else bg-slate-100 text-slate-700 @endif">
                                {{ $transaction->status }}
                            </span>
                        </td>
                        <td class="px-4 md:px-8 py-6 text-sm text-slate-500">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 md:px-8 py-6 text-center">
                            <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                                class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 md:px-8 py-12 text-center text-slate-500">
                            @if(request()->hasAny(['search', 'status']))
                                Tidak ada transaksi yang cocok dengan filter Anda.
                            @else
                                Belum ada transaksi.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
        <div class="px-4 md:px-8 py-6 bg-slate-50/50 border-t flex justify-center">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection