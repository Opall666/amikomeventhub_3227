<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ← Import Storage

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan eager loading
        $query = Event::with('category');

        // 1. SEARCH: Filter berdasarkan judul
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // 2. FILTER KATEGORI
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 3. FILTER STATUS (Upcoming / Past / All)
        if ($request->filled('status')) {
            if ($request->status === 'upcoming') {
                $query->where('date', '>=', now());
            } elseif ($request->status === 'past') {
                $query->where('date', '<', now());
            }
        }

        // Eksekusi query dengan pagination
        $events = $query->latest()->paginate(10)->withQueryString();

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('admin.events.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            $validated['slug'] = Str::slug($request->title);


        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
            $validated['poster_path'] = $posterPath;
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Data Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
            $validated['poster_path'] = $posterPath;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Rincian data event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // Hapus poster jika ada
        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        // Hapus event
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Data event berhasil dihapus secara permanen.');
    }
}