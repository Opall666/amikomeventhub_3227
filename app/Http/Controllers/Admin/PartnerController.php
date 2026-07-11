<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $partners = $query->latest()->paginate(10)->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:partners,name',
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'website_url' => 'nullable|url|max:500',
        ], [
            'logo.required' => 'Logo wajib diupload.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format logo harus PNG, JPG, JPEG, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'website_url.url' => 'Format URL website tidak valid.',
        ]);

        // Upload logo
        $logoPath = $request->file('logo')->store('partners', 'public');

        Partner::create([
            'name' => $validated['name'],
            'logo_url' => $logoPath, // Simpan path file
            'website_url' => $validated['website_url'] ?? null, 

        ]);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:partners,name,' . $partner->id,
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'website_url' => 'nullable|url|max:500',
        ]);

        // Jika ada upload logo baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }

            // Upload logo baru
            $validated['logo_url'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        $name = $partner->name;

        // Hapus file logo
        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }

        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Partner "' . $name . '" berhasil dihapus.');
    }
}