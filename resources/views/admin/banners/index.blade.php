<div class="space-y-6">

        <!-- Pengaturan Banner -->
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-1">Gambar Banner</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Upload gambar untuk slide banner. Setiap gambar akan menjadi slide terpisah.</p>

            <!-- Form Upload dengan Drag & Drop Card -->
            <form action="{{ route('admin.banners.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="file" name="gambar[]" id="gambar" accept="image/*" class="hidden" onchange="handleFileSelect(event)">

                <!-- Drag & Drop Card dengan Tombol Upload -->
                <div id="upload-card" class="border-2 border-dashed border-gray-300 dark:border-slate-600 p-8 text-center cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors relative" style="border-radius: 0;" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" onclick="if(!event.target.closest('#preview-container') && !event.target.closest('button')) document.getElementById('gambar').click()">
                    <!-- Default Content -->
                    <div id="upload-default" class="space-y-3">
                        <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <div>
                            <button type="button" onclick="event.stopPropagation(); document.getElementById('gambar').click();" class="px-4 py-2.5 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2 mx-auto" style="border-radius: 0;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Upload Gambar
                            </button>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Atau seret dan lepas gambar ke area ini</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 text-center">Format yang didukung: JPG, PNG (Maks. 5MB). Rekomendasi ukuran: 1920x680px</p>
                    </div>

                    <!-- Preview Image (muncul saat ada gambar) -->
                    <div id="preview-container" class="hidden">
                        <div class="relative border border-gray-200 dark:border-slate-700 overflow-hidden group cursor-pointer hover:opacity-90 transition-opacity" style="border-radius: 0;" onclick="if(!event.target.closest('button')) { const img = document.getElementById('preview-img'); if(img && img.src) openImagePreview(img.src, 'Preview Banner'); }">
                            <img id="preview-img" src="" alt="Preview" class="w-full h-auto max-h-[400px] object-contain pointer-events-none">
                            <button type="button" onclick="event.stopPropagation(); resetImage();" class="absolute top-2 right-2 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2" style="border-radius: 0;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Daftar Gambar Banner (Grid View) -->
            @if($banners->count() > 0)
                <div class="mt-6">
                    <!-- Banner List Container (Grid) -->
                    <div id="banner-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-total="{{ $banners->count() }}">
                        @foreach($banners as $banner)
                            <div class="banner-item bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 overflow-hidden group relative cursor-move hover:shadow-lg transition-shadow" data-id="{{ $banner->id }}" data-urutan="{{ $banner->urutan }}" style="border-radius: 0;">
                                <div class="w-full aspect-video overflow-hidden cursor-pointer" onclick="openImagePreview('{{ $banner->gambar ? asset('storage/' . $banner->gambar) : asset('img/default-backgrounds.png') }}', 'Banner {{ $banner->urutan }}')">
                                    <img src="{{ $banner->gambar ? asset('storage/' . $banner->gambar) : asset('img/default-backgrounds.png') }}?v={{ $banner->updated_at->timestamp ?? time() }}" alt="Banner" class="w-full h-full object-cover hover:opacity-90 transition-opacity">
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold px-2 py-1 {{ $banner->is_active ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}" style="border-radius: 0;">
                                            {{ $banner->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">Posisi: {{ $banner->urutan }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Toggle Aktif -->
                                        <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" class="flex-1" onclick="event.stopPropagation()">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full text-center px-3 py-1.5 text-xs font-bold {{ $banner->is_active ? 'bg-green-700 text-white hover:bg-green-800' : 'text-gray-700 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/30 hover:bg-gray-100 dark:hover:bg-gray-900/50' }}" style="border-radius: 0;">
                                                {{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        <!-- Hapus -->
                                        <button type="button" onclick="event.stopPropagation(); showDeleteBannerModal('{{ route('admin.banners.destroy', $banner) }}', '{{ $banner->id }}');" class="w-full text-center px-3 py-1.5 text-xs font-bold bg-red-700 text-white hover:bg-red-800" style="border-radius: 0;">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 p-12 text-center" style="border-radius: 0;">
                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Gambar Banner</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Upload gambar untuk membuat slide banner</p>
                </div>
            @endif

            <!-- Banner Promosi -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Banner Promosi</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Upload banner promosi yang akan ditampilkan di beranda antara berita dan artikel.</p>
                <p class="text-xs text-green-600 dark:text-green-400 font-medium mb-4">Ukuran yang disarankan: 1920 × 600 px</p>

                <form action="{{ route('admin.banners.upload-promosi') }}" method="POST" enctype="multipart/form-data" id="promosiForm" @if($settings && $settings->promosi_banner_path) style="display: none;" @endif>
                    @csrf
                    <input type="file" name="promosi_banner" id="promosi_banner" accept="image/*" class="hidden" onchange="handlePromosiFileSelect(event)">

                    <!-- Drag & Drop Card untuk Banner Promosi -->
                    <div id="promosi-upload-card" class="border-2 border-dashed border-gray-300 dark:border-slate-600 p-8 text-center cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors relative" style="border-radius: 0;" ondrop="handlePromosiDrop(event)" ondragover="handlePromosiDragOver(event)" ondragleave="handlePromosiDragLeave(event)" onclick="if(!event.target.closest('#promosi-preview-container') && !event.target.closest('button')) document.getElementById('promosi_banner').click()">
                        <!-- Default Content -->
                        <div id="promosi-upload-default" class="space-y-3">
                            <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <div>
                                <button type="button" onclick="event.stopPropagation(); document.getElementById('promosi_banner').click();" class="px-4 py-2.5 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2 mx-auto" style="border-radius: 0;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Pilih Gambar
                                </button>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Atau seret dan lepas gambar ke area ini</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 text-center">Format yang didukung: JPG, PNG (Maks. 5MB per gambar)</p>
                        </div>

                        <!-- Preview Image -->
                        <div id="promosi-preview-container" class="hidden">
                            <div class="relative border border-gray-200 dark:border-slate-700 overflow-hidden group" style="border-radius: 0; aspect-ratio: 1920/600;">
                                <img id="promosi-preview-img" src="" alt="Preview" class="w-full h-full object-cover">
                                <button type="button" onclick="event.stopPropagation(); resetPromosiImage();" class="absolute top-2 right-2 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2" style="border-radius: 0;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Banner Promosi yang Sudah Ada -->
                @if($settings && $settings->promosi_banner_path)
                    <div class="mt-6">
                        <div class="bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 overflow-hidden group relative" style="border-radius: 0;">
                            <div class="w-full overflow-hidden cursor-pointer" onclick="openImagePreview('{{ asset('storage/' . $settings->promosi_banner_path) }}', 'Banner Promosi')" style="aspect-ratio: 1920/600; height: auto;">
                                <img src="{{ asset('storage/' . $settings->promosi_banner_path) }}?v={{ $settings->updated_at->timestamp ?? time() }}" alt="Banner Promosi" class="w-full h-full object-cover hover:opacity-90 transition-opacity" style="object-fit: cover;">
                            </div>
                            <div class="p-4">
                                <div class="flex items-center gap-2">
                                    <!-- Hapus -->
                                    <button type="button" onclick="showDeletePromosiModal();" class="w-full text-center px-3 py-1.5 text-xs font-bold bg-red-700 text-white hover:bg-red-800" style="border-radius: 0;">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Garis Batas -->
            <div class="border-t border-gray-200 dark:border-slate-700 mt-6 mb-4"></div>

            <!-- Form Pengaturan Informasi Banner -->
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-1">Pengaturan Informasi Banner</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Informasi ini akan digunakan untuk semua slide banner</p>

                <form action="{{ route('admin.banners.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
                    @csrf
                    @method('POST')

                    <div class="space-y-4">
                        <!-- Tagline -->
                        <div>
                            <label for="tagline" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Tagline
                                <span class="text-xs font-normal text-slate-400">(opsional, teks kecil di atas judul)</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $settings->tagline ?? '') }}" maxlength="150" placeholder="Masukkan tagline" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" style="border-radius: 0;" oninput="updateCharCount('tagline', 150)">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                    <span id="tagline-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('tagline', $settings->tagline ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                </span>
                            </div>
                        </div>

                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Judul Banner
                                <span class="text-xs font-normal text-slate-400">(opsional, judul utama banner)</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="judul" id="judul" value="{{ old('judul', $settings->judul ?? '') }}" maxlength="150" placeholder="Masukkan judul banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" style="border-radius: 0;" oninput="updateCharCount('judul', 150)">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                    <span id="judul-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('judul', $settings->judul ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                </span>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Deskripsi
                                <span class="text-xs font-normal text-slate-400">(opsional, usahakan singkat ±2 baris kalimat)</span>
                            </label>
                            <div class="relative">
                                <textarea name="deskripsi" id="deskripsi" rows="3" maxlength="200" placeholder="Masukkan deskripsi banner" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pb-8 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" style="border-radius: 0;" oninput="updateCharCount('deskripsi', 200)">{{ old('deskripsi', $settings->deskripsi ?? '') }}</textarea>
                                <span class="absolute bottom-2 right-3 text-xs pointer-events-none">
                                    <span id="deskripsi-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('deskripsi', $settings->deskripsi ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/200</span>
                                </span>
                            </div>
                        </div>

                        <!-- Link -->
                        <div>
                            <label for="link" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Link
                                <span class="text-xs font-normal text-slate-400">(opsional, URL yang dibuka saat banner diklik)</span>
                            </label>
                            <div class="relative">
                                <input type="url" name="link" id="link" value="{{ old('link', $settings->link ?? '') }}" maxlength="150" placeholder="Masukkan URL (contoh: https://example.com)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" style="border-radius: 0;" oninput="updateCharCount('link', 150); toggleButtonTextInput();">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                    <span id="link-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('link', $settings->link ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                </span>
                            </div>
                        </div>

                        <!-- Button Text -->
                        <div>
                            <label for="button_text" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Teks Tombol
                                <span class="text-xs font-normal text-slate-400">(opsional, teks pada tombol jika ada link)</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $settings->button_text ?? '') }}" maxlength="150" placeholder="Masukkan teks tombol" class="w-full bg-gray-100 dark:bg-slate-600 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-500 dark:text-slate-400 focus:ring-2 focus:ring-green-600 focus:border-green-600" style="border-radius: 0;" oninput="updateCharCount('button_text', 150)" disabled>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                    <span id="button_text-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('button_text', $settings->button_text ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                </span>
                            </div>
                        </div>

                        <!-- Kontrol Tampilan Elemen -->
                        <div class="pt-0">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2 mt-4">Kontrol Tampilan Elemen</h3>
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

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700 mt-6">
                            <button type="submit" id="save-settings-btn" disabled class="px-4 py-2 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" style="border-radius: 0;">
                                Simpan Informasi Banner
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Perubahan -->
    <div id="confirm-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Ada Perubahan yang Belum Disimpan</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Anda memiliki perubahan yang belum disimpan. Apakah Anda ingin menyimpan perubahan ini?</p>
                <div class="flex items-center justify-end gap-3">
                    <div id="modal-sidebar-buttons" class="hidden items-center justify-end gap-3">
                        <button type="button" id="modal-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Tutup</button>
                        <button type="button" id="modal-discard-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                        <button type="button" id="modal-save-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px]">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Banner -->
    <div id="deleteBannerModal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4" style="border-radius: 0;">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Konfirmasi Hapus Banner</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Yakin ingin menghapus gambar banner ini?</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="deleteBannerCancelBtn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]" style="border-radius: 0;">
                        Batal
                    </button>
                    <form id="deleteBannerForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors min-w-[100px]" style="border-radius: 0;">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Banner Promosi -->
    <div id="deletePromosiModal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4" style="border-radius: 0;">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Konfirmasi Hapus Banner Promosi</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Yakin ingin menghapus banner promosi ini?</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="deletePromosiCancelBtn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]" style="border-radius: 0;">
                        Batal
                    </button>
                    <form id="deletePromosiForm" action="{{ route('admin.banners.delete-promosi') }}" method="POST" style="display: inline;" onsubmit="handlePromosiDelete(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors min-w-[100px]" style="border-radius: 0;">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Hapus Banner
        function showDeleteBannerModal(actionUrl, bannerId) {
            const modal = document.getElementById('deleteBannerModal');
            const form = document.getElementById('deleteBannerForm');
            form.action = actionUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function hideDeleteBannerModal() {
            const modal = document.getElementById('deleteBannerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Modal Hapus Banner Promosi
        function showDeletePromosiModal() {
            const modal = document.getElementById('deletePromosiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function hideDeletePromosiModal() {
            const modal = document.getElementById('deletePromosiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Fungsi untuk menampilkan kembali form upload setelah banner dihapus
        function showPromosiUploadForm() {
            const uploadForm = document.getElementById('promosiForm');
            if (uploadForm) {
                uploadForm.style.display = '';
            }
        }

        // Handle delete banner promosi
        function handlePromosiDelete(event) {
            // Form akan submit dan setelah reload (karena auto-reload), form upload akan muncul lagi
            // Tapi kita juga bisa langsung tampilkan form upload untuk UX yang lebih baik
            setTimeout(function() {
                showPromosiUploadForm();
            }, 100);
        }

        // Fungsi openImagePreview dan closeImagePreview sudah didefinisikan secara global di layouts/admin.blade.php
        // Tidak perlu didefinisikan ulang di sini

        // Fungsi untuk toggle input Teks Tombol berdasarkan input Link
        function toggleButtonTextInput() {
            const linkInput = document.getElementById('link');
            const buttonTextInput = document.getElementById('button_text');

            if (!linkInput || !buttonTextInput) return;

            const linkValue = linkInput.value.trim();

            // Validasi URL - cek apakah tidak kosong dan format URL valid
            let isValidUrl = false;
            if (linkValue.length > 0) {
                try {
                    // Coba buat URL object untuk validasi
                    const url = new URL(linkValue);
                    isValidUrl = url.protocol === 'http:' || url.protocol === 'https:';
                } catch (e) {
                    // Jika gagal, cek apakah dimulai dengan http:// atau https://
                    isValidUrl = linkValue.startsWith('http://') || linkValue.startsWith('https://');
                }
            }

            if (isValidUrl) {
                // Enable input Teks Tombol
                buttonTextInput.disabled = false;
                buttonTextInput.classList.remove('bg-gray-100', 'dark:bg-slate-600', 'text-slate-500', 'dark:text-slate-400', 'cursor-not-allowed');
                buttonTextInput.classList.add('bg-white', 'dark:bg-slate-700', 'text-slate-900', 'dark:text-slate-100', 'cursor-text');
                buttonTextInput.placeholder = 'Masukkan teks tombol';
            } else {
                // Disable input Teks Tombol
                buttonTextInput.disabled = true;
                buttonTextInput.classList.remove('bg-white', 'dark:bg-slate-700', 'text-slate-900', 'dark:text-slate-100', 'cursor-text');
                buttonTextInput.classList.add('bg-gray-100', 'dark:bg-slate-600', 'text-slate-500', 'dark:text-slate-400', 'cursor-not-allowed');
                buttonTextInput.placeholder = 'Masukkan link terlebih dahulu';
            }
        }

        // Setup event listeners untuk modal
        document.addEventListener('DOMContentLoaded', function() {
            // Cek status input Link saat halaman dimuat
            toggleButtonTextInput();

            // Modal Hapus Banner
            const deleteBannerModal = document.getElementById('deleteBannerModal');
            const deleteBannerCancelBtn = document.getElementById('deleteBannerCancelBtn');

            if (deleteBannerCancelBtn) {
                deleteBannerCancelBtn.addEventListener('click', hideDeleteBannerModal);
            }

            if (deleteBannerModal) {
                deleteBannerModal.addEventListener('click', function(e) {
                    if (e.target === deleteBannerModal) {
                        hideDeleteBannerModal();
                    }
                });
            }

            // Modal Hapus Banner Promosi
            const deletePromosiModal = document.getElementById('deletePromosiModal');
            const deletePromosiCancelBtn = document.getElementById('deletePromosiCancelBtn');

            if (deletePromosiCancelBtn) {
                deletePromosiCancelBtn.addEventListener('click', hideDeletePromosiModal);
            }

            if (deletePromosiModal) {
                deletePromosiModal.addEventListener('click', function(e) {
                    if (e.target === deletePromosiModal) {
                        hideDeletePromosiModal();
                    }
                });
            }
        });

        // Preview Gambar (Single File) dengan Drag & Drop
        let selectedFile = null;

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            processFile(file);
        }

        function processFile(file) {
            // Validasi tipe file
            if (!file.type.startsWith('image/')) {
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

            selectedFile = file;
            updatePreview();
        }

        function handleDrop(event) {
            event.preventDefault();
            event.stopPropagation();
            const uploadCard = document.getElementById('upload-card');
            uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');

            const file = Array.from(event.dataTransfer.files).find(f => f.type.startsWith('image/'));
            if (!file) {
                alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                return;
            }

            const input = document.getElementById('gambar');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            processFile(file);
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.stopPropagation();
            const uploadCard = document.getElementById('upload-card');
            uploadCard.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }

        function handleDragLeave(event) {
            event.preventDefault();
            event.stopPropagation();
            const uploadCard = document.getElementById('upload-card');
            uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }

        function updatePreview() {
            const uploadDefault = document.getElementById('upload-default');
            const previewContainer = document.getElementById('preview-container');
            const previewImg = document.getElementById('preview-img');

            if (!selectedFile) {
                if (uploadDefault) uploadDefault.classList.remove('hidden');
                if (previewContainer) previewContainer.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                if (uploadDefault) uploadDefault.classList.add('hidden');
                if (previewContainer) previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(selectedFile);
        }

        function resetImage() {
            selectedFile = null;
            const input = document.getElementById('gambar');
            input.value = '';
            updatePreview();
        }

        // Fungsi untuk Banner Promosi
        function handlePromosiFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                // Validasi ukuran file
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                    document.getElementById('promosi_banner').value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('promosi-preview-img').src = e.target.result;
                    document.getElementById('promosi-preview-container').classList.remove('hidden');
                    document.getElementById('promosi-upload-default').classList.add('hidden');
                    document.getElementById('promosi-upload-card').classList.add('border-green-500', 'dark:border-green-600');
                };
                reader.readAsDataURL(file);
            }
        }

        function handlePromosiDragOver(event) {
            event.preventDefault();
            event.stopPropagation();
            event.currentTarget.classList.add('border-green-500', 'dark:border-green-600');
        }

        function handlePromosiDragLeave(event) {
            event.preventDefault();
            event.stopPropagation();
            event.currentTarget.classList.remove('border-green-500', 'dark:border-green-600');
        }

        function handlePromosiDrop(event) {
            event.preventDefault();
            event.stopPropagation();
            event.currentTarget.classList.remove('border-green-500', 'dark:border-green-600');

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('promosi_banner').files = dataTransfer.files;
                    handlePromosiFileSelect({ target: { files: [file] } });
                }
            }
        }

        function resetPromosiImage() {
            document.getElementById('promosi_banner').value = '';
            document.getElementById('promosi-preview-img').src = '';
            document.getElementById('promosi-preview-container').classList.add('hidden');
            document.getElementById('promosi-upload-default').classList.remove('hidden');
            document.getElementById('promosi-upload-card').classList.remove('border-green-500', 'dark:border-green-600');
        }

        // Validasi form sebelum submit
        document.getElementById('uploadForm')?.addEventListener('submit', function(event) {
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
        });

        // Validasi form banner promosi sebelum submit
        document.getElementById('promosiForm')?.addEventListener('submit', function(event) {
            const fileInput = document.getElementById('promosi_banner');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                alert('Silakan pilih file gambar terlebih dahulu.');
                event.preventDefault();
                return false;
            }

            const file = fileInput.files[0];
            if (!file) {
                alert('Silakan pilih file gambar terlebih dahulu.');
                event.preventDefault();
                return false;
            }

            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file.size > maxSize) {
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                event.preventDefault();
                return false;
            }

            // Pastikan form submit dengan benar
            return true;
        });

        // Update character count
        function updateCharCount(fieldId, maxLength) {
            const input = document.getElementById(fieldId);
            const countElement = document.getElementById(fieldId + '-count');
            if (input && countElement) {
                const length = input.value.length;
                countElement.textContent = length;
                // Pastikan class warna selalu tetap (tidak berubah menjadi merah)
                // Hapus semua kemungkinan class warna merah
                const redClasses = ['text-red-600', 'dark:text-red-400', 'text-red-700', 'dark:text-red-300', 'text-red-500', 'dark:text-red-500', 'text-red-800', 'dark:text-red-600', 'text-red-400', 'dark:text-red-300'];
                redClasses.forEach(cls => countElement.classList.remove(cls));
                // Pastikan class warna default selalu ada - paksa dengan remove dan add
                countElement.classList.remove('text-slate-400', 'dark:text-slate-500');
                countElement.classList.add('text-slate-400', 'dark:text-slate-500');
                // Pastikan tidak ada style inline yang mengubah warna
                countElement.style.color = '';
                countElement.style.removeProperty('color');
            }
        }


        // Modal konfirmasi perubahan
        let isSubmitting = false;
        let pendingNavigationUrl = null;
        const settingsForm = document.getElementById('settings-form');
        const modal = document.getElementById('confirm-modal');
        const modalCancelBtn = document.getElementById('modal-cancel-btn');
        const modalDiscardBtn = document.getElementById('modal-discard-btn');
        const modalSaveBtn = document.getElementById('modal-save-btn');
        const modalSidebarButtons = document.getElementById('modal-sidebar-buttons');

        // Get initial form snapshot
        function getFormSnapshot() {
            const snapshot = {
                inputs: {},
                checkboxes: {}
            };

            if (settingsForm) {
                // Get all text inputs, textareas, selects
                const inputs = settingsForm.querySelectorAll('input[type="text"], input[type="url"], textarea');
                inputs.forEach(input => {
                    if (input.name && input.id) {
                        snapshot.inputs[input.name] = input.value.trim();
                    }
                });

                // Get checkboxes
                const checkboxes = settingsForm.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    if (checkbox.name) {
                        snapshot.checkboxes[checkbox.name] = checkbox.checked;
                    }
                });
            }

            return snapshot;
        }

        let initialSnapshot = getFormSnapshot();
        setTimeout(() => {
            initialSnapshot = getFormSnapshot();
        }, 500);

        // Fungsi untuk update status tombol Simpan berdasarkan perubahan form
        function updateSaveButtonState() {
            const saveBtn = document.getElementById('save-settings-btn');
            if (!saveBtn) return;

            const hasFormChanges = hasFormChanged();

            if (hasFormChanges) {
                // Ada perubahan → enable tombol
                saveBtn.disabled = false;
                saveBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                saveBtn.removeAttribute('disabled');
            } else {
                // Tidak ada perubahan → disable tombol
                saveBtn.disabled = true;
                saveBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
                saveBtn.setAttribute('disabled', 'disabled');
            }
        }

        // Event listeners untuk semua input di form settings
        document.addEventListener('DOMContentLoaded', function() {
            const settingsForm = document.getElementById('settings-form');
            if (!settingsForm) return;

            // Simpan snapshot awal setelah delay untuk memastikan semua data ter-load
            setTimeout(() => {
                initialSnapshot = getFormSnapshot();
                // Set tombol disabled secara default
                updateSaveButtonState();
            }, 500);

            // Listen untuk semua perubahan input
            const inputs = settingsForm.querySelectorAll('input[type="text"], input[type="url"], textarea, input[type="checkbox"]');
            inputs.forEach(input => {
                input.addEventListener('input', updateSaveButtonState);
                input.addEventListener('change', updateSaveButtonState);
            });
        });

        // Check if form has changed
        function hasFormChanged() {
            const currentSnapshot = getFormSnapshot();

            // Compare inputs
            for (const key in initialSnapshot.inputs) {
                if (initialSnapshot.inputs[key] !== currentSnapshot.inputs[key]) {
                    return true;
                }
            }
            for (const key in currentSnapshot.inputs) {
                if (!(key in initialSnapshot.inputs)) {
                    return true;
                }
            }

            // Compare checkboxes
            for (const key in initialSnapshot.checkboxes) {
                if (initialSnapshot.checkboxes[key] !== currentSnapshot.checkboxes[key]) {
                    return true;
                }
            }
            for (const key in currentSnapshot.checkboxes) {
                if (!(key in initialSnapshot.checkboxes)) {
                    return true;
                }
            }

            return false;
        }

        function showModal(url = null) {
            pendingNavigationUrl = url;
            if (modalSidebarButtons) {
                if (url) {
                    modalSidebarButtons.classList.remove('hidden');
                    modalSidebarButtons.classList.add('flex');
                } else {
                    modalSidebarButtons.classList.add('hidden');
                    modalSidebarButtons.classList.remove('flex');
                }
            }
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function hideModal() {
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            if (modalSidebarButtons) {
                modalSidebarButtons.classList.add('hidden');
                modalSidebarButtons.classList.remove('flex');
            }
            pendingNavigationUrl = null;
        }

        // Form submit
        if (settingsForm) {
            settingsForm.addEventListener('submit', () => {
                isSubmitting = true;
                // Reset snapshot setelah submit untuk mencegah modal muncul dan disable tombol
                setTimeout(() => {
                    initialSnapshot = getFormSnapshot();
                    updateSaveButtonState();
                }, 100);
            });
        }

        // Modal buttons
        if (modalCancelBtn) {
            modalCancelBtn.addEventListener('click', () => {
                hideModal();
            });
        }

        if (modalDiscardBtn) {
            modalDiscardBtn.addEventListener('click', () => {
                const url = pendingNavigationUrl;
                hideModal();
                isSubmitting = false;
                if (url) {
                    window.location.replace(url);
                }
            });
        }

        if (modalSaveBtn) {
            modalSaveBtn.addEventListener('click', () => {
                const url = pendingNavigationUrl;
                hideModal();
                isSubmitting = true;

                if (settingsForm) {
                    if (url) {
                        const existingInput = settingsForm.querySelector('input[name="_redirect_after_save"]');
                        if (existingInput) {
                            existingInput.remove();
                        }
                        const redirectInput = document.createElement('input');
                        redirectInput.type = 'hidden';
                        redirectInput.name = '_redirect_after_save';
                        redirectInput.value = url;
                        settingsForm.appendChild(redirectInput);
                    }
                    settingsForm.submit();
                }
            });
        }

        // Close modal on outside click
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    hideModal();
                }
            });
        }

        // Detect sidebar menu clicks
        if (document.querySelector('aside nav')) {
            document.querySelectorAll('aside nav a').forEach(link => {
                link.addEventListener('click', (e) => {
                    if (!isSubmitting && hasFormChanged()) {
                        e.preventDefault();
                        const url = link.getAttribute('href');
                        showModal(url);
                    }
                });
            });
        }

        // Drag and Drop untuk mengubah urutan banner (Grid)
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
                        this.style.border = '2px solid #10b981';
                        this.style.borderRadius = '0';
                    }
                });

                item.addEventListener('dragleave', function(e) {
                    if (this !== draggedElement) {
                        this.style.border = '';
                    }
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
                        // Update data-urutan attribute dan posisi text
                        items.forEach((item, index) => {
                            item.dataset.urutan = index + 1;
                            const posisiText = item.querySelector('.text-xs.text-slate-500');
                            if (posisiText) {
                                posisiText.textContent = 'Posisi: ' + (index + 1);
                            }
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

</div>
</div>

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
