@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.banners.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Banner</h1>
                <p class="text-sm text-slate-500 mt-1">Ubah informasi banner</p>
            </div>
        </div>

        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Banner Upload -->
            <div class="border-2 border-gray-200 dark:border-slate-700 rounded-xl p-6">
                <div id="current-banner-container">
                    <div class="relative group">
                        <img id="current-banner-image" src="{{ $banner->gambar ? asset('storage/' . $banner->gambar) : asset('img/default-backgrounds.png') }}" alt="Banner Saat Ini" class="w-full rounded-lg border border-gray-200 dark:border-slate-700 cursor-pointer hover:opacity-90 transition-opacity" onclick="openImageZoom(this.src)">
                        <label for="gambar" class="absolute top-2 right-2 cursor-pointer">
                            <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <span class="inline-block px-4 py-2 text-sm font-semibold text-white bg-gray-600 dark:bg-slate-700 rounded-lg hover:bg-gray-700 dark:hover:bg-slate-600 transition-colors">
                                Ganti Banner
                            </span>
                        </label>
                    </div>
                </div>
                <div id="preview-container" class="hidden">
                    <div class="relative group">
                        <img id="preview-image" src="" alt="Preview" class="w-full rounded-lg border border-gray-200 dark:border-slate-700 cursor-pointer hover:opacity-90 transition-opacity" onclick="openImageZoom(this.src)">
                        <button type="button" onclick="resetImage()" class="absolute top-2 right-2 px-4 py-2 text-sm font-semibold text-white bg-gray-600 dark:bg-slate-700 rounded-lg hover:bg-gray-700 dark:hover:bg-slate-600 transition-colors">
                            Ganti Banner
                        </button>
                    </div>
                </div>
                @error('gambar')
                    <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informasi Banner -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-900">Informasi Banner</h3>

                <div>
                    <label for="tagline" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Tagline
                        <span class="text-xs font-normal text-slate-400">(opsional, teks kecil di atas judul)</span>
                    </label>
                    <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $banner->tagline) }}" maxlength="255" placeholder="Masukkan tagline" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('tagline', 255)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="tagline-count">0</span>/255 karakter
                    </p>
                    @error('tagline') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="judul" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Judul Banner
                        <span class="text-xs font-normal text-slate-400">(opsional, judul utama banner)</span>
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $banner->judul) }}" maxlength="255" placeholder="Masukkan judul banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('judul', 255)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="judul-count">0</span>/255 karakter
                    </p>
                    @error('judul') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Deskripsi
                        <span class="text-xs font-normal text-slate-400">(opsional, usahakan singkat ±2 baris kalimat)</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" maxlength="220" placeholder="Masukkan deskripsi banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('deskripsi', 220)">{{ old('deskripsi', $banner->deskripsi) }}</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="deskripsi-count">0</span>/220 karakter
                    </p>
                    @error('deskripsi') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="link" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Link
                        <span class="text-xs font-normal text-slate-400">(opsional, URL yang dibuka saat banner diklik)</span>
                    </label>
                    <input type="url" name="link" id="link" value="{{ old('link', $banner->link) }}" maxlength="500" placeholder="Masukkan URL (contoh: https://example.com)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('link', 500)">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="link-count">0</span>/500 karakter
                    </p>
                    @error('link') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="button_text" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Teks Tombol
                        <span class="text-xs font-normal text-slate-400">(opsional, teks pada tombol jika ada link)</span>
                    </label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $banner->button_text) }}" maxlength="100" placeholder="Masukkan teks tombol" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('button_text', 100)">
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
                            <label for="show_logo" class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_logo" id="show_logo" value="1" {{ old('show_logo', $banner->show_logo ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Logo</span>
                            </label>
                            <label for="show_tagline" class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_tagline" id="show_tagline" value="1" {{ old('show_tagline', $banner->show_tagline ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Tagline</span>
                            </label>
                            <label for="show_title" class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_title" id="show_title" value="1" {{ old('show_title', $banner->show_title ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Judul</span>
                            </label>
                            <label for="show_description" class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_description" id="show_description" value="1" {{ old('show_description', $banner->show_description ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Deskripsi</span>
                            </label>
                            <label for="show_button" class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="show_button" id="show_button" value="1" {{ old('show_button', $banner->show_button ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Tombol</span>
                            </label>
                            <label for="is_active" class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan di Website</span>
                            </label>
                        </div>
                        <div>
                            <label for="urutan" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Urutan Tampil</label>
                            <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $banner->urutan ?: 1) }}" min="1" placeholder="1" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Angka lebih kecil akan tampil lebih dulu (1 = pertama, 2 = kedua, dst)</p>
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const currentBannerContainer = document.getElementById('current-banner-container');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    currentBannerContainer.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetImage() {
            const currentBannerContainer = document.getElementById('current-banner-container');
            const previewContainer = document.getElementById('preview-container');
            const fileInput = document.getElementById('gambar');

            fileInput.value = '';
            currentBannerContainer.classList.remove('hidden');
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

        // Fungsi untuk zoom gambar
        function openImageZoom(imageSrc) {
            const modal = document.getElementById('imageZoomModal');
            const img = document.getElementById('zoomImage');
            if (modal && img && imageSrc) {
                img.src = imageSrc;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeImageZoom() {
            const modal = document.getElementById('imageZoomModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }

        // Close modal dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageZoom();
            }
        });
    </script>

    <!-- Modal Zoom Gambar -->
    <div id="imageZoomModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 dark:bg-black/50 backdrop-blur-md" onclick="closeImageZoom()">
        <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation()">
            <img id="zoomImage" src="" alt="Preview" class="max-w-full max-h-full object-contain pointer-events-none">
            <button type="button" onclick="closeImageZoom()" class="close-banner-modal-btn fixed top-4 right-4 w-10 h-10 flex items-center justify-center text-white hover:text-slate-200 transition-colors z-10">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endsection
