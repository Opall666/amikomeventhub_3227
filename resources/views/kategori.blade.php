ini sudah benar penempatannya? di file kategori
@extends('layouts.app')

@section('title', 'Kategori Event - AmikomEventHub')

@section('content')
<!-- Header -->
<div class="bg-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-slate-800 mb-3">Kategori Event</h1>
        <p class="text-slate-600 text-lg">Temukan event sesuai minat Anda</p>
    </div>
</div>

<!-- Search -->
<div class="max-w-7xl mx-auto px-6 py-8">
    <form action="{{ route('kategori') }}" method="GET" class="max-w-xl mx-auto">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari kategori..."
                class="w-full pl-5 pr-12 py-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-indigo-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>
    </form>
    @if(request('search'))
        <p class="text-center text-slate-500 mt-3 text-sm">
            Hasil untuk: "{{ request('search') }}"
            <a href="{{ route('kategori') }}" class="text-red-500 hover:underline ml-2">✕</a>
        </p>
    @endif
</div>

<!-- Categories Grid -->
<div class="max-w-7xl mx-auto px-6 py-8 pb-16">
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->slug]) . '#events' }}" 
                    class="block p-6 bg-white border border-slate-200 rounded-xl hover:border-indigo-300 hover:shadow-lg transition group">
                    
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold text-xl">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </div>
                        @if($category->events_count > 0)
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                {{ $category->events_count }} event
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-xs">
                                Belum ada event
                            </span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-indigo-600 transition">
                        {{ $category->name }}
                    </h3>
                    <p class="text-sm text-slate-500 mb-4">
                        {{ $category->events_count }} event tersedia
                    </p>
                    
                    <div class="flex items-center text-indigo-600 text-sm font-semibold">
                        Lihat Event
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        @if($categories->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16">
            <p class="text-slate-500">
                @if(request('search'))
                    Tidak ada kategori yang cocok.
                @else
                    Belum ada kategori.
                @endif
            </p>
            @if(request('search'))
                <a href="{{ route('kategori') }}" class="text-indigo-600 hover:underline mt-2 inline-block">Lihat semua</a>
            @endif
        </div>
    @endif
</div>
@endsection