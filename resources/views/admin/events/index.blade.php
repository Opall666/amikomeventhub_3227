@extends('layouts.admin')

@section('title', 'Kelola Event - Admin')
@section('page_title', 'Kelola Event')
@section('page_subtitle', 'Buat dan atur acara seru Anda di sini.')

@section('content')
<!-- Action Bar: Search + Filter + Add Button -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 md:p-6 mb-6">
    <form action="{{ route('admin.events.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center">
        
        <!-- Search Input -->
        <div class="flex-1 min-w-0">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="🔍 Cari judul event..."
                    class="w-full pl-4 pr-10 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition">
                @if(request('search'))
                    <a href="{{ route('admin.events.index', array_filter(request()->except('search'))) }}" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <!-- Filter Kategori -->
        <select name="category" class="px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium min-w-[180px]">
            <option value="">🏷️ Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- Filter Status -->
        <select name="status" class="px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium min-w-[180px]">
            <option value=""> Semua Waktu</option>
            <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}> Upcoming</option>
            <option value="past" {{ request('status') === 'past' ? 'selected' : '' }}>⏰ Past Events</option>
        </select>

        <!-- Submit Button -->
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition whitespace-nowrap">
            Terapkan
        </button>

        <!-- Reset Button -->
        @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('admin.events.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition whitespace-nowrap">
                Reset
            </a>
        @endif

        <!-- Add Event Button -->
        <a href="{{ route('admin.events.create') }}" 
            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:shadow-xl hover:scale-[1.02] transition whitespace-nowrap">
            + Tambah Event
        </a>
    </form>
</div>

<!-- Active Filters Info -->
@if(request()->hasAny(['search', 'category', 'status']))
    <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-xl p-4 mb-6 flex flex-wrap items-center gap-3">
        <span class="text-sm font-bold text-indigo-700">🎯 Filter Aktif:</span>
        
        @if(request('search'))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full text-xs font-bold text-indigo-700 border border-indigo-200">
                🔍 "{{ request('search') }}"
                <a href="{{ route('admin.events.index', array_filter(request()->except('search'))) }}" class="hover:text-red-500 ml-1">✕</a>
            </span>
        @endif

        @if(request('category'))
            @php $cat = $categories->firstWhere('id', request('category')) @endphp
            @if($cat)
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full text-xs font-bold text-indigo-700 border border-indigo-200">
                    🏷️ {{ $cat->name }}
                    <a href="{{ route('admin.events.index', array_filter(request()->except('category'))) }}" class="hover:text-red-500 ml-1">✕</a>
                </span>
            @endif
        @endif

        @if(request('status'))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full text-xs font-bold text-indigo-700 border border-indigo-200">
                📅 {{ ucfirst(request('status')) }}
                <a href="{{ route('admin.events.index', array_filter(request()->except('status'))) }}" class="hover:text-red-500 ml-1"></a>
            </span>
        @endif

        <span class="text-xs text-indigo-600 ml-auto">
            Menampilkan <strong>{{ $events->total() }}</strong> event
        </span>
    </div>
@endif

<!-- Events Table -->
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-4 md:px-8 py-4 w-16">No</th>
                    <th class="px-4 md:px-8 py-4">Poster</th>
                    <th class="px-4 md:px-8 py-4">Event</th>
                    <th class="px-4 md:px-8 py-4">Kategori</th>
                    <th class="px-4 md:px-8 py-4">Tanggal</th>
                    <th class="px-4 md:px-8 py-4">Harga / Stok</th>
                    <th class="px-4 md:px-8 py-4">Status</th>
                    <th class="px-4 md:px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($events as $index => $event)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 md:px-8 py-6 font-bold text-slate-400">
                            {{ $events->firstItem() + $index }}
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            @if($event->poster_path)
                                <img src="{{ asset('storage/' . $event->poster_path) }}" 
                                    class="w-16 h-20 rounded-xl object-cover shadow-sm">
                            @else
                                <div class="w-16 h-20 rounded-xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <p class="font-black text-slate-800 line-clamp-1">{{ $event->title }}</p>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ Str::limit($event->description, 50) }}</p>
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            @if($event->category)
                                <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold">
                                    {{ $event->category->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-8 py-6 text-sm text-slate-600">
                            {{ $event->date->format('d M Y') }}
                            <br>
                            <span class="text-xs text-slate-400">{{ $event->date->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <p class="font-bold text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-400">Stok: {{ $event->stock }}</p>
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            @if($event->date >= now())
                                @if($event->stock > 0)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">
                                        🔥 Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase">
                                        Sold Out
                                    </span>
                                @endif
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold uppercase">
                                     Past
                                </span>
                            @endif
                        </td>
                        <td class="px-4 md:px-8 py-6">
                            <div class="flex gap-2 justify-center">
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.events.edit', $event->id) }}" 
                                    class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                <!-- Tombol Delete -->
                                <form action="{{ route('admin.events.destroy', $event->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus &quot;{{ $event->title }}&quot;?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 md:px-8 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                @if(request()->hasAny(['search', 'category', 'status']))
                                    <p class="text-slate-500 font-bold mb-1">Tidak Ada Hasil</p>
                                    <p class="text-sm text-slate-400">Coba ubah filter atau kata kunci pencarian Anda.</p>
                                @else
                                    <p class="text-slate-500 font-bold mb-1">Belum Ada Event</p>
                                    <p class="text-sm text-slate-400 mb-4">Mulai dengan menambahkan event pertama Anda.</p>
                                    <a href="{{ route('admin.events.create') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition text-sm">
                                        + Tambah Event
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="px-4 md:px-8 py-6 bg-slate-50/50 border-t flex justify-center">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection