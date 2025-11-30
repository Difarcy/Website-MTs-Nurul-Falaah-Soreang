@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pengumuman.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Pengumuman</h1>
                <p class="text-sm text-slate-500 mt-1">Buat pengumuman baru yang akan ditampilkan di website</p>
            </div>
        </div>

        <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Pengumuman *
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" maxlength="255" required placeholder="Masukkan judul pengumuman" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('judul', 255)">
                    <p class="text-xs text-slate-500 mt-1 text-right">
                        <span id="judul-count">0</span>/255 karakter
                    </p>
                    @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Isi Pengumuman *
                    </label>
                    <textarea name="isi" id="isi" rows="6" maxlength="2000" required placeholder="Masukkan isi pengumuman" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('isi', 2000)">{{ old('isi') }}</textarea>
                    <p class="text-xs text-slate-500 mt-1 text-right">
                        <span id="isi-count">0</span>/2000 karakter
                    </p>
                    @error('isi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Pengumuman *
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    @error('tanggal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
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

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                            <span class="text-sm font-semibold text-slate-700">Tampilkan di Website</span>
                        </label>
                    </div>
                </div>
            </details>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.pengumuman.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>
@endsection

