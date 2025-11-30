@extends('layouts.admin')

@section('title', 'Banner')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Banner</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola gambar banner dan informasi yang ditampilkan di semua slide</p>
            </div>
        </div>

        <!-- Card Gabungan: Gambar Banner & Pengaturan Informasi -->
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Gambar Banner</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Upload gambar untuk slide banner. Setiap gambar akan menjadi slide terpisah.</p>
            
            <!-- Form Upload dengan Drag & Drop -->
            <form action="{{ route('admin.banners.upload') }}" method="POST" enctype="multipart/form-data" class="mb-6" id="uploadForm" onsubmit="return validateFileSize(event)">
                @csrf
                <input type="file" name="gambar[]" id="gambar" accept="image/*" class="hidden" onchange="handleFileSelect(event)">
                
                <!-- Drag & Drop Area dengan Preview di Dalam -->
                <div id="upload-area" class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-0 min-h-[400px] cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors relative overflow-hidden" onclick="if(!event.target.closest('#preview-image')) document.getElementById('gambar').click()" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                    <!-- Default Content (saat belum ada gambar) -->
                    <div id="upload-default" class="absolute inset-0 flex items-center justify-center p-6">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Klik untuk Upload atau Drag & Drop</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Format: JPG atau PNG (Maksimal 5MB)</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Rekomendasi ukuran: 1920x680px</p>
                        </div>
                    </div>

                    <!-- Preview Image (muncul saat ada gambar, replace default content) -->
                    <div id="preview-image" class="hidden absolute inset-0 p-4">
                        <img id="preview-img" src="" alt="Preview" class="w-full h-full object-contain">
                    </div>
                </div>

                <!-- Tombol Aksi (muncul saat ada gambar, di luar card) -->
                <div id="upload-actions" class="hidden mt-4 flex justify-end gap-3">
                    <button type="button" onclick="resetImage()" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                        Upload Gambar
                    </button>
                </div>
            </form>

            <!-- Daftar Gambar Banner dengan Navigasi -->
            @if($banners->count() > 0)
                <div class="mb-8">
                    <!-- Info Total Banner (Debug) -->
                    <div class="mb-4 text-sm text-slate-500 dark:text-slate-400">
                        Total banner: <strong>{{ $banners->count() }}</strong> gambar
                    </div>
                    
                    <!-- Container untuk Banner Carousel -->
                    <div class="relative">
                        <!-- Banner List Container -->
                        <div id="banner-list" class="grid grid-cols-1 gap-4 overflow-hidden relative" data-total="{{ $banners->count() }}" style="min-height: 600px;">
                            @foreach($banners as $index => $banner)
                                <div class="banner-item border border-gray-200 dark:border-slate-700 rounded-lg overflow-hidden group relative cursor-move {{ $index >= 1 ? 'hidden' : '' }}" data-id="{{ $banner->id }}" data-urutan="{{ $banner->urutan }}" data-index="{{ $index }}" style="min-height: 600px;">
                                    <div class="cursor-pointer w-full h-full px-6 py-6" onclick="openImagePreview('{{ $banner->gambar ? asset('storage/' . $banner->gambar) : asset('img/default-backgrounds.png') }}', 'Banner {{ $banner->urutan }}')">
                                        <img src="{{ $banner->gambar ? asset('storage/' . $banner->gambar) : asset('img/default-backgrounds.png') }}?v={{ $banner->updated_at->timestamp ?? time() }}" alt="Banner" class="w-full h-full object-contain hover:opacity-90 transition-opacity pointer-events-none">
                                    </div>
                                    <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <!-- Toggle Aktif -->
                                        <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-10 h-10 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center {{ $banner->is_active ? 'bg-green-600 text-white hover:bg-green-700' : 'bg-gray-600 text-white hover:bg-gray-700' }}" title="{{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                {{ $banner->is_active ? '✓' : '○' }}
                                            </button>
                                        </form>
                                        <!-- Hapus -->
                                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar banner ini?');" class="inline" onclick="event.stopPropagation()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @if(!$banner->is_active)
                                        <div class="absolute top-4 left-4">
                                            <span class="px-2 py-1 text-xs font-semibold bg-red-600 text-white rounded">Tidak Aktif</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Tombol Navigasi (muncul jika lebih dari 1 banner) -->
                        @if($banners->count() > 1)
                            <div class="flex items-center justify-center gap-4 mt-6">
                                <button id="prev-banner" onclick="navigateBanners(-1)" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <span id="banner-page-info" class="text-sm text-slate-600 dark:text-slate-400 font-medium">
                                    <span id="current-page">1</span> / <span id="total-pages">{{ $banners->count() }}</span>
                                </span>
                                <button id="next-banner" onclick="navigateBanners(1)" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                    Selanjutnya
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-12 text-center mb-8">
                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Gambar Banner</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Upload gambar untuk membuat slide banner</p>
                </div>
            @endif

            <!-- Separator -->
            <div class="border-t border-gray-200 dark:border-slate-700 my-8"></div>

            <!-- Form Pengaturan Informasi Banner -->
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Pengaturan Informasi Banner</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Informasi ini akan digunakan untuk semua slide banner</p>
                
                <form action="{{ route('admin.banners.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    
                    <div class="space-y-6">
                        <!-- Tagline -->
                        <div>
                            <label for="tagline" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Tagline
                                <span class="text-xs font-normal text-slate-400">(opsional, teks kecil di atas judul)</span>
                            </label>
                            <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $settings->tagline ?? '') }}" maxlength="255" placeholder="Masukkan tagline" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('tagline', 255)">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                                <span id="tagline-count">{{ strlen(old('tagline', $settings->tagline ?? '')) }}</span>/255 karakter
                            </p>
                        </div>

                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Judul Banner
                                <span class="text-xs font-normal text-slate-400">(opsional, judul utama banner)</span>
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $settings->judul ?? '') }}" maxlength="255" placeholder="Masukkan judul banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('judul', 255)">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                                <span id="judul-count">{{ strlen(old('judul', $settings->judul ?? '')) }}</span>/255 karakter
                            </p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Deskripsi
                                <span class="text-xs font-normal text-slate-400">(opsional, usahakan singkat ±2 baris kalimat)</span>
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" maxlength="220" placeholder="Masukkan deskripsi banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('deskripsi', 220)">{{ old('deskripsi', $settings->deskripsi ?? '') }}</textarea>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                                <span id="deskripsi-count">{{ strlen(old('deskripsi', $settings->deskripsi ?? '')) }}</span>/220 karakter
                            </p>
                        </div>

                        <!-- Link -->
                        <div>
                            <label for="link" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Link
                                <span class="text-xs font-normal text-slate-400">(opsional, URL yang dibuka saat banner diklik)</span>
                            </label>
                            <input type="url" name="link" id="link" value="{{ old('link', $settings->link ?? '') }}" maxlength="500" placeholder="Masukkan URL (contoh: https://example.com)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('link', 500)">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                                <span id="link-count">{{ strlen(old('link', $settings->link ?? '')) }}</span>/500 karakter
                            </p>
                        </div>

                        <!-- Button Text -->
                        <div>
                            <label for="button_text" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Teks Tombol
                                <span class="text-xs font-normal text-slate-400">(opsional, teks pada tombol jika ada link)</span>
                            </label>
                            <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $settings->button_text ?? '') }}" maxlength="100" placeholder="Masukkan teks tombol" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCount('button_text', 100)">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                                <span id="button_text-count">{{ strlen(old('button_text', $settings->button_text ?? '')) }}</span>/100 karakter
                            </p>
                        </div>

                        <!-- Kontrol Tampilan Elemen -->
                        <div class="border-t border-gray-200 dark:border-slate-700 pt-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Kontrol Tampilan Elemen</h3>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="show_logo" value="1" {{ old('show_logo', $settings->show_logo ?? true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Tampilkan Logo</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="show_tagline" value="1" {{ old('show_tagline', $settings->show_tagline ?? true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Tampilkan Tagline</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="show_title" value="1" {{ old('show_title', $settings->show_title ?? true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Tampilkan Judul</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="show_description" value="1" {{ old('show_description', $settings->show_description ?? true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Tampilkan Deskripsi</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="show_button" value="1" {{ old('show_button', $settings->show_button ?? true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Tampilkan Tombol</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                                Simpan Informasi Banner
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview Gambar -->
    <div id="imagePreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-90" onclick="closeImagePreview()">
        <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation()">
            <button onclick="closeImagePreview()" class="absolute top-2 right-4 text-white bg-black bg-opacity-70 hover:bg-opacity-90 rounded-full p-3 transition-colors z-10 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-full w-auto h-auto object-contain">
        </div>
    </div>

    <script>
        function openImagePreview(imageSrc, imageAlt) {
            const modal = document.getElementById('imagePreviewModal');
            const img = document.getElementById('previewImage');
            img.src = imageSrc;
            img.alt = imageAlt;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImagePreview() {
            const modal = document.getElementById('imagePreviewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImagePreview();
            }
        });

        // Drag & Drop dan Preview Gambar (Single File)
        let selectedFile = null;

        // Validasi file size sebelum submit
        function validateFileSize(event) {
            const fileInput = document.getElementById('gambar');
            if (!fileInput.files || fileInput.files.length === 0) {
                alert('Silakan pilih file gambar terlebih dahulu.');
                event.preventDefault();
                return false;
            }
            
            const file = fileInput.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (file.size > maxSize) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                event.preventDefault();
                return false;
            }
            
            return true;
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Validasi tipe file
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                event.target.value = '';
                return;
            }
            
            // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
            const maxSize = 5 * 1024 * 1024; // 5MB dalam bytes
            if (file.size > maxSize) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                event.target.value = '';
                selectedFile = null;
                updatePreview();
                return;
            }
            
            selectedFile = file;
            updatePreview();
        }

        function handleDrop(event) {
            event.preventDefault();
            event.stopPropagation();
            const uploadArea = document.getElementById('upload-area');
            uploadArea.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
            
            const file = Array.from(event.dataTransfer.files).find(f => f.type.startsWith('image/'));
            if (!file) {
                alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                return;
            }
            
            // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
            const maxSize = 5 * 1024 * 1024; // 5MB dalam bytes
            if (file.size > maxSize) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                return;
            }
            
            const input = document.getElementById('gambar');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            selectedFile = file;
            updatePreview();
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.stopPropagation();
            const uploadArea = document.getElementById('upload-area');
            uploadArea.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }

        function handleDragLeave(event) {
            event.preventDefault();
            event.stopPropagation();
            const uploadArea = document.getElementById('upload-area');
            uploadArea.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }

        function updatePreview() {
            const uploadDefault = document.getElementById('upload-default');
            const previewImage = document.getElementById('preview-image');
            const previewImg = document.getElementById('preview-img');
            const uploadActions = document.getElementById('upload-actions');

            if (!selectedFile) {
                uploadDefault.classList.remove('hidden');
                previewImage.classList.add('hidden');
                uploadActions.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                
                uploadDefault.classList.add('hidden');
                previewImage.classList.remove('hidden');
                uploadActions.classList.remove('hidden');
            };
            reader.readAsDataURL(selectedFile);
        }

        function resetImage() {
            selectedFile = null;
            const input = document.getElementById('gambar');
            input.value = '';
            updatePreview();
        }

        // Navigasi Banner (Prev/Next) - 1 gambar per halaman
        let currentBannerPage = 1;
        const itemsPerPage = 1;

        function navigateBanners(direction) {
            const bannerList = document.getElementById('banner-list');
            if (!bannerList) return;

            const totalBanners = parseInt(bannerList.dataset.total) || 0;
            const totalPages = totalBanners; // Karena 1 gambar per halaman
            
            currentBannerPage += direction;
            
            if (currentBannerPage < 1) currentBannerPage = 1;
            if (currentBannerPage > totalPages) currentBannerPage = totalPages;

            // Update tampilan - hanya tampilkan 1 gambar sesuai halaman
            const bannerItems = bannerList.querySelectorAll('.banner-item');
            const targetIndex = currentBannerPage - 1; // Index dimulai dari 0

            bannerItems.forEach((item, index) => {
                if (index === targetIndex) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            // Update info halaman
            const currentPageEl = document.getElementById('current-page');
            const totalPagesEl = document.getElementById('total-pages');
            if (currentPageEl) currentPageEl.textContent = currentBannerPage;
            if (totalPagesEl) totalPagesEl.textContent = totalPages;

            // Update tombol
            const prevBtn = document.getElementById('prev-banner');
            const nextBtn = document.getElementById('next-banner');
            if (prevBtn) prevBtn.disabled = currentBannerPage === 1;
            if (nextBtn) nextBtn.disabled = currentBannerPage === totalPages;
        }

        // Inisialisasi navigasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const bannerList = document.getElementById('banner-list');
            if (!bannerList) return;

            const totalBanners = parseInt(bannerList.dataset.total) || 0;
            if (totalBanners > 1) {
                const prevBtn = document.getElementById('prev-banner');
                const nextBtn = document.getElementById('next-banner');
                if (prevBtn) prevBtn.disabled = true; // Halaman pertama, prev disabled
                if (nextBtn && totalBanners === 1) {
                    nextBtn.disabled = true; // Hanya 1 gambar, next disabled
                }
            }
        });

        // Drag and Drop untuk mengubah urutan banner
        document.addEventListener('DOMContentLoaded', function() {
            const bannerList = document.getElementById('banner-list');
            if (!bannerList) return;

            // Gunakan HTML5 drag and drop API
            let draggedElement = null;

            bannerList.querySelectorAll('.banner-item').forEach(item => {
                item.draggable = true;
                
                item.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                    e.dataTransfer.effectAllowed = 'move';
                });

                item.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                });

                item.addEventListener('dragover', function(e) {
                    if (e.preventDefault) {
                        e.preventDefault();
                    }
                    e.dataTransfer.dropEffect = 'move';
                    return false;
                });

                item.addEventListener('dragenter', function(e) {
                    if (this !== draggedElement) {
                        this.style.border = '2px dashed #10b981';
                    }
                });

                item.addEventListener('dragleave', function(e) {
                    this.style.border = '';
                });

                item.addEventListener('drop', function(e) {
                    if (e.stopPropagation) {
                        e.stopPropagation();
                    }
                    e.preventDefault();

                    if (draggedElement !== this) {
                        const allItems = Array.from(bannerList.querySelectorAll('.banner-item'));
                        const draggedIndex = allItems.indexOf(draggedElement);
                        const targetIndex = allItems.indexOf(this);

                        if (draggedIndex < targetIndex) {
                            bannerList.insertBefore(draggedElement, this.nextSibling);
                        } else {
                            bannerList.insertBefore(draggedElement, this);
                        }

                        // Update urutan di database
                        updateBannerOrder();
                    }

                    this.style.border = '';
                    return false;
                });
            });

            function updateBannerOrder() {
                const items = bannerList.querySelectorAll('.banner-item');
                const order = Array.from(items).map((item, index) => ({
                    id: item.dataset.id,
                    urutan: index + 1
                }));

                fetch('{{ route("admin.banners.update-order") }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update data-urutan attribute
                        items.forEach((item, index) => {
                            item.dataset.urutan = index + 1;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengupdate urutan banner');
                });
            }
        });
    </script>
@endsection

@push('styles')
<style>
    .banner-item {
        transition: transform 0.2s, opacity 0.2s;
    }
    .banner-item.dragging {
        opacity: 0.5;
    }
</style>
@endpush
