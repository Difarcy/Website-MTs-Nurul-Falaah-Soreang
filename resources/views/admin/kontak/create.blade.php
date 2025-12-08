@extends('layouts.admin')

@section('title', 'Tambah Kontak')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kontak.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Kontak</h1>
                <p class="text-sm text-slate-500 mt-1">Tambah informasi kontak sekolah baru</p>
            </div>
        </div>

        <form action="{{ route('admin.kontak.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="jenis" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Kontak *
                    </label>
                    <select name="jenis" id="jenis" required class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        <option value="">Pilih Jenis</option>
                        <option value="email" {{ old('jenis') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="telp" {{ old('jenis') == 'telp' ? 'selected' : '' }}>Telepon</option>
                        <option value="whatsapp" {{ old('jenis') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="alamat" {{ old('jenis') == 'alamat' ? 'selected' : '' }}>Alamat</option>
                        <option value="facebook" {{ old('jenis') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('jenis') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="youtube" {{ old('jenis') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="label" class="block text-sm font-semibold text-slate-700 mb-2">
                        Label <span class="text-red-600 dark:text-red-500">*</span>
                    </label>
                    <input type="text" name="label" id="label" value="{{ old('label') }}" required placeholder="Masukkan label kontak" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    @error('label') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nilai" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nilai/Konten *
                    </label>
                    <input type="text" name="nilai" id="nilai" value="{{ old('nilai') }}" required placeholder="Masukkan nilai kontak" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    @error('nilai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="icon" class="block text-sm font-semibold text-slate-700 mb-2">
                        Icon (Emoji)
                        <span class="text-xs font-normal text-slate-400">(opsional)</span>
                    </label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="Masukkan nama icon" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    <p class="text-xs text-slate-500 mt-1">Gunakan nama icon atau emoji, contoh: email, phone, atau 📧 untuk email</p>
                    @error('icon') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <details class="border border-gray-200 dark:border-slate-700 rounded-lg">
                <summary class="px-4 py-3 cursor-pointer text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                    Pengaturan Lanjutan (Opsional)
                </summary>
                <div class="px-4 pb-4 pt-2 space-y-4 border-t border-gray-200">
                    <div>
                        <label for="urutan" class="block text-sm font-semibold text-slate-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0" class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
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
                <a href="{{ route('admin.kontak.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                    Simpan Kontak
                </button>
            </div>
        </form>
    </div>
@endsection

