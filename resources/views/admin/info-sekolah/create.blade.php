@extends('layouts.admin')

@section('title', 'Tambah Info Sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.info-sekolah.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Info Sekolah</h1>
                <p class="text-sm text-slate-500 mt-1">Tambah informasi umum sekolah baru</p>
            </div>
        </div>

        <form action="{{ route('admin.info-sekolah.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Key (Identifikasi) *
                    </label>
                    <input type="text" name="key" value="{{ old('key') }}" required placeholder="Masukkan key (contoh: nama_sekolah)" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    <p class="text-xs text-slate-500 mt-1">Gunakan huruf kecil dan underscore, contoh: nama_sekolah</p>
                    @error('key') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Label *
                    </label>
                    <input type="text" name="label" value="{{ old('label') }}" required placeholder="Masukkan label" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    @error('label') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tipe *
                    </label>
                    <select name="type" required class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text (Satu Baris)</option>
                        <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea (Banyak Baris)</option>
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image (Gambar)</option>
                    </select>
                    @error('type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Value (Isi) *
                    </label>
                    <textarea name="value" rows="4" required placeholder="Masukkan isi informasi..." class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('value') }}</textarea>
                    @error('value') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <details class="border border-gray-200 dark:border-slate-700 rounded-lg">
                <summary class="px-4 py-3 cursor-pointer text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                    Pengaturan Lanjutan (Opsional)
                </summary>
                <div class="px-4 pb-4 pt-2 space-y-4 border-t border-gray-200">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0" class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        <p class="text-xs text-slate-500 mt-1">Angka lebih kecil akan tampil lebih dulu</p>
                        @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </details>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.info-sekolah.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                    Simpan Info
                </button>
            </div>
        </form>
    </div>
@endsection

