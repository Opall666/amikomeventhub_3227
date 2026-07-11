<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Auto cleanup expired reservations (quick fix)
        \App\Models\Transaction::cleanupExpiredReservations();
        
        $categories = Category::all();
        
        // Query dasar: hanya event masa depan
        $query = Event::with('category')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc');

        // 1. Filter berdasarkan Kategori
        if ($request->has('category') && $request->category !== '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // 2. Fitur Pencarian (Search by Nama Event atau Lokasi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // 3. Pagination: 6 event per halaman (appends untuk pertahankan filter & search di URL)
        $events = $query->paginate(6)->appends(request()->query());
        
        $activeCategory = $request->category;
        $partners = \App\Models\Partner::latest()->take(6)->get();

        return view('welcome', compact('events', 'categories', 'activeCategory', 'partners'));
    }

    /**
     * Halaman Kategori - Menampilkan semua kategori dengan jumlah event
     */
    public function kategori(Request $request)
    {
        $query = Category::withCount(['events' => function($q) {
            $q->where('date', '>=', now());
        }]);

        // Search kategori
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $categories = $query->latest()->paginate(12);
        
        // Hitung total semua kategori dan event
        $totalCategories = Category::count();
        $totalEvents = Event::where('date', '>=', now())->count();

        return view('kategori', compact('categories', 'totalCategories', 'totalEvents'));
    }

    /**
     * Halaman Tentang Kami
     */
    public function tentangKami()
    {
        $stats = [
            'events' => Event::where('date', '>=', now())->count(),
            'partners' => \App\Models\Partner::count(),
            'tickets' => \App\Models\Transaction::where('status', 'Success')->count(),
            'categories' => Category::count(),
        ];

        return view('tentang-kami', compact('stats'));
    }

    /**
     * Halaman Cara Kerja (Cara Pesan & Cara Bayar)
     */
    public function caraKerja()
    {
        return view('cara-kerja');
    }

    public function syaratKetentuan()
    {
        return view('syarat-ketentuan');
    }

    public function kebijakanPrivasi()
    {
        return view('kebijakan-privasi');
    }
}