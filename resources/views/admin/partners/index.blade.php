@extends('layouts.admin')

@section('title', 'Kelola Partner - Admin')
@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Daftar mitra yang mendukung AmikomEventHub.')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <!-- Search Form -->
    <form action="{{ route('admin.partners.index') }}" method="GET" class="w-full md:w-96">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama partner..."
                class="w-full pl-12 pr-4 py-3 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </form>

    <a href="{{ route('admin.partners.create') }}" 
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition whitespace-nowrap">
        + Tambah Partner
    </a>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[500px]">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-4 md:px-8 py-4 w-16">ID</th>
                    <th class="px-4 md:px-8 py-4">Logo</th>
                    <th class="px-4 md:px-8 py-4">Nama Partner</th>
                    <th class="px-4 md:px-8 py-4">Dibuat</th>
                    <th class="px-4 md:px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $partner)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 md:px-8 py-6 font-bold text-slate-400">{{ $partner->id }}</td>
                        <td class="px-4 md:px-8 py-6">
                            @if($partner->logo_url)
                                <img src="{{ asset('storage/' . $partner->logo_url) }}" 
                                    alt="{{ $partner->name }}" 
                                    class="h-12 w-auto max-w-24 object-contain rounded-lg bg-slate-50 p-1">
                            @else
                                <div class="w-20 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-xs text-slate-400">
                                    No Logo
                                </div>
                            @endif
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <p class="font-black text-slate-800">{{ $partner->name }}</p>
                        </td>
                        <td class="px-4 md:px-8 py-6 text-sm text-slate-500">
                            {{ $partner->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.partners.edit', $partner->id) }}" 
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.partners.destroy', $partner->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Yakin ingin menghapus partner &quot;{{ $partner->name }}&quot;?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 md:px-8 py-10 text-center text-slate-500">
                            @if(request('search'))
                                Tidak ada partner yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>"
                            @else
                                Belum ada partner yang ditambahkan.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($partners->hasPages())
        <div class="px-4 md:px-8 py-6 bg-slate-50/50 border-t flex justify-center">
            {{ $partners->links() }}
        </div>
    @endif
</div>
@endsection