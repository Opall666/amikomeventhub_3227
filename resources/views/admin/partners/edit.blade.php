@extends('layouts.admin')

@section('title', 'Edit Partner - Admin')
@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Perbarui informasi partner.')

@section('content')
<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm max-w-2xl">
    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Partner -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Partner
            </label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" 
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" 
                required>
            @error('name') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Upload Logo -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Logo Partner
            </label>

            <!-- Logo Saat Ini -->
            @if($partner->logo_url)
                <div class="mb-4">
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wide mb-3">Logo Saat Ini</p>
                    <div class="inline-block bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6">
                        <img src="{{ asset('storage/' . $partner->logo_url) }}" 
                            alt="{{ $partner->name }}" 
                            class="h-16 object-contain">
                    </div>
                </div>
            @endif

            <!-- Upload Baru (Opsional) -->
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-indigo-400 transition">
                <input type="file" name="logo" id="logo-input" accept="image/*" 
                    class="hidden" onchange="previewLogo(event)">
                <label for="logo-input" class="cursor-pointer">
                    <div id="upload-placeholder">
                        <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700 mb-1">Upload Logo Baru (Opsional)</p>
                        <p class="text-xs text-slate-500">Kosongkan jika tidak ingin mengubah logo</p>
                    </div>
                    <div id="logo-preview" class="hidden">
                        <img id="preview-image" src="" alt="Preview" class="h-20 mx-auto mb-3 object-contain">
                        <p id="file-name" class="text-sm text-slate-600 font-medium mb-2"></p>
                        <button type="button" onclick="resetUpload(event)" class="text-xs text-red-600 hover:underline">
                            ✕ Hapus & Pilih File Lain
                        </button>
                    </div>
                </label>
            </div>
            @error('logo') 
                <span class="text-red-500 text-sm mt-2 block">⚠️ {{ $message }}</span> 
            @enderror
        </div>

        <!-- Website URL -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Website Partner (Opsional)
            </label>
            <input type="url" name="website_url" value="{{ old('website_url', $partner->website_url) }}" 
                placeholder="https://example.com"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
            @error('website_url') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Buttons -->
        <div class="pt-4 flex justify-end gap-4 border-t border-slate-100">
            <a href="{{ route('admin.partners.index') }}" 
                class="px-6 py-4 text-slate-500 font-bold hover:text-slate-800 transition">
                Batal
            </a>
            <button type="submit" 
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                resetUpload(event);
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('file-name').textContent = file.name;
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('logo-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function resetUpload(event) {
        event.preventDefault();
        event.stopPropagation();
        document.getElementById('logo-input').value = '';
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('logo-preview').classList.add('hidden');
    }
</script>
@endsection