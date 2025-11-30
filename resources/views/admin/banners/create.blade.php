@extends('layouts.admin')

@section('title', 'Tambah Banner')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.banners.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Banner</h1>
                <p class="text-sm text-slate-500 mt-1">Tambah banner slider baru untuk halaman utama</p>
            </div>
        </div>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf

            <!-- Langkah 1: Upload Gambar -->
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-500 transition">
                <div id="upload-area" class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <label for="gambar" class="cursor-pointer">
                        <span class="block text-lg font-semibold text-slate-700 mb-2">Klik untuk Upload Gambar Banner</span>
                        <span class="block text-sm text-slate-500 mb-4">Format: JPG atau PNG (Maksimal 5MB)<br>Rekomendasi ukuran: 1920x680px</span>
                        <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <span class="inline-block px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                            Pilih File
                        </span>
                    </label>
                </div>
                <div id="preview-container" class="hidden">
                    <div class="relative">
                        <img id="preview-image" src="" alt="Preview" class="w-full rounded-lg border border-gray-200">
                        <button type="button" onclick="resetImage()" class="absolute top-2 right-2 px-3 py-1.5 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                            Ganti Foto
                        </button>
                    </div>
                </div>
                @error('gambar') 
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Informasi Banner -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                    Informasi Banner (Opsional)
                </h3>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Tagline
                        <span class="text-xs font-normal text-slate-400">(opsional, teks kecil di atas judul)</span>
                    </label>
                    <input type="text" name="tagline" id="tagline" value="{{ old('tagline') }}" maxlength="255" placeholder="Masukkan tagline" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('tagline', 255)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="tagline-count">0</span>/255 karakter
                    </p>
                    @error('tagline') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Judul Banner
                        <span class="text-xs font-normal text-slate-400">(opsional, judul utama banner)</span>
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" maxlength="255" placeholder="Masukkan judul banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('judul', 255)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="judul-count">0</span>/255 karakter
                    </p>
                    @error('judul') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Deskripsi
                        <span class="text-xs font-normal text-slate-400">(opsional, usahakan singkat ±2 baris kalimat)</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" maxlength="220" placeholder="Masukkan deskripsi banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('deskripsi', 220)">{{ old('deskripsi') }}</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="deskripsi-count">0</span>/220 karakter
                    </p>
                    @error('deskripsi') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Link
                        <span class="text-xs font-normal text-slate-400">(opsional, URL yang dibuka saat banner diklik)</span>
                    </label>
                    <input type="url" name="link" id="link" value="{{ old('link') }}" maxlength="500" placeholder="Masukkan URL (contoh: https://example.com)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('link', 500)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="link-count">0</span>/500 karakter
                    </p>
                    @error('link') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Teks Tombol
                        <span class="text-xs font-normal text-slate-400">(opsional, teks pada tombol jika ada link)</span>
                    </label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}" maxlength="100" placeholder="Masukkan teks tombol" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('button_text', 100)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="button_text-count">0</span>/100 karakter
                    </p>
                    @error('button_text') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Kontrol Tampilan Elemen Banner -->
                <div class="border-t border-gray-200 dark:border-slate-700 pt-4 mt-4">
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Kontrol Tampilan Elemen</h4>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_logo" value="1" {{ old('show_logo', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Logo</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_tagline" value="1" {{ old('show_tagline', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Tagline</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_title" value="1" {{ old('show_title', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Judul</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_description" value="1" {{ old('show_description', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Deskripsi</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_button" value="1" {{ old('show_button', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Tombol</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan di Website</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Urutan Tampil</label>
                            <input type="number" name="urutan" value="{{ old('urutan') }}" min="1" placeholder="{{ $nextUrutan }} (kosongkan untuk urutan terakhir)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kosongkan untuk menambahkan di urutan terakhir, atau isi angka untuk menentukan posisi (1 = pertama, 2 = kedua, dst)</p>
                            @error('urutan') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.banners.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                    Simpan Banner
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const uploadArea = document.getElementById('upload-area');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    uploadArea.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetImage() {
            const uploadArea = document.getElementById('upload-area');
            const previewContainer = document.getElementById('preview-container');
            const fileInput = document.getElementById('gambar');
            
            fileInput.value = '';
            uploadArea.classList.remove('hidden');
            previewContainer.classList.add('hidden');
        }

        function updateCharCount(fieldId, maxLength) {
            const field = document.getElementById(fieldId);
            const countElement = document.getElementById(fieldId + '-count');
            const currentLength = field.value.length;
            const remaining = maxLength - currentLength;
            
            countElement.textContent = currentLength;
            
            // Update warna berdasarkan sisa karakter
            if (remaining < 20) {
                countElement.className = 'text-red-600 font-semibold';
            } else if (remaining < 50) {
                countElement.className = 'text-amber-600 font-semibold';
            } else {
                countElement.className = 'text-slate-500';
            }
        }

        // Inisialisasi counter saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateCharCount('tagline', 255);
            updateCharCount('judul', 255);
            updateCharCount('deskripsi', 220);
            updateCharCount('link', 500);
            updateCharCount('button_text', 100);
        });
    </script>
@endsection
