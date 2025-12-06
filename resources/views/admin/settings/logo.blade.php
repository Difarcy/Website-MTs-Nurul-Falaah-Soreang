@extends('layouts.admin')

@section('title', 'Logo')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Logo</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Unggah logo baru untuk dipakai di seluruh website (header, banner, favicon/tab).</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data" id="uploadForm" data-form-type="logo">
                @csrf
                <input type="file" name="logo" id="logo" accept="image/*" class="hidden" onchange="handleFileSelect(event)" aria-label="Upload Logo">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Area Upload Drag & Drop -->
                    <div>
                        <label for="logo" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Pilih Logo Baru</label>
                        
                        <!-- Drag & Drop Card dengan Tombol Upload -->
                        <div id="upload-card" class="border-2 border-dashed border-gray-300 dark:border-slate-600 text-center cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors relative aspect-square" style="border-radius: 0;" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" onclick="if(!event.target.closest('#preview-container') && !event.target.closest('button')) document.getElementById('logo').click()">
                            <!-- Default Content -->
                            <div id="upload-default" class="absolute inset-0 flex items-center justify-center p-8">
                                <div class="space-y-3">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <div>
                                        <button type="button" onclick="event.stopPropagation(); document.getElementById('logo').click();" class="px-4 py-2.5 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2 mx-auto" style="border-radius: 0;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Upload Logo
                                        </button>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Atau seret dan lepas logo ke area ini</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center">Format yang didukung: PNG, JPG, SVG (Maks. 5MB). Disarankan PNG transparan</p>
                                </div>
                            </div>

                            <!-- Preview Image (muncul saat ada gambar) -->
                            <div id="preview-container" class="hidden absolute inset-0 w-full h-full flex items-center justify-center bg-slate-50 dark:bg-slate-700">
                                <div class="relative w-full h-full flex items-center justify-center p-4 group aspect-square">
                                    <img id="preview-img" src="" alt="Preview" class="w-full h-full max-w-[80%] max-h-[80%] object-contain">
                                    <button type="button" onclick="event.stopPropagation(); resetImage();" class="absolute top-2 right-2 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @error('logo') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror

                        <!-- Tombol Aksi -->
                        <div id="upload-actions" class="hidden mt-4 flex justify-end gap-3">
                            <button type="button" onclick="resetImage()" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors" style="border-radius: 0;">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors" style="border-radius: 0;">
                                Upload Logo
                            </button>
                        </div>
                    </div>

                    <!-- Preview Logo Saat Ini -->
                    <div>
                        <div class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Pratinjau Logo yang Dipakai</div>
                        <div class="w-full aspect-square border border-gray-200 dark:border-slate-600 rounded-lg flex items-center justify-center bg-slate-50 dark:bg-slate-700 overflow-hidden" style="border-radius: 0;">
                            @php
                                $logoPath = optional($settings)->logo_path
                                    ? 'storage/' . $settings->logo_path
                                    : 'img/logo.png';
                                // Cache busting: untuk storage gunakan updated_at, untuk file default gunakan filemtime
                                if ($settings && $settings->logo_path) {
                                    $logoVersion = $settings->updated_at ? $settings->updated_at->timestamp : time();
                                } else {
                                    $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
                                }
                                $logoSrc = asset($logoPath) . ($logoVersion ? '?v=' . $logoVersion : '');
                            @endphp
                            <img src="{{ $logoSrc }}" alt="Logo saat ini" class="max-w-[80%] max-h-[80%] object-contain">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Konfirmasi Perubahan -->
        <div id="confirm-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Ada Perubahan yang Belum Disimpan</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Anda memiliki perubahan yang belum disimpan. Apakah Anda ingin menyimpan perubahan ini?</p>
                    <div class="flex items-center justify-end gap-3">
                        <div id="modal-sidebar-buttons" class="flex items-center justify-end gap-3">
                            <button type="button" id="modal-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Tutup</button>
                            <button type="button" id="modal-discard-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                            <button type="button" id="modal-save-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px]">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Drag & Drop dan Preview Logo
            let selectedFile = null;

            function handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;
                processLogoFile(file);
            }

            function handleDrop(event) {
                event.preventDefault();
                event.stopPropagation();
                const uploadCard = document.getElementById('upload-card');
                uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
                
                const file = Array.from(event.dataTransfer.files).find(f => f.type.startsWith('image/'));
                if (!file) {
                    alert('File harus berupa gambar (PNG, JPG, atau SVG)');
                    return;
                }
                
                processLogoFile(file);
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

            function processLogoFile(file) {
                // Validasi tipe file
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar (PNG, JPG, atau SVG)');
                    return;
                }
                
                // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                    return;
                }
                
                const input = document.getElementById('logo');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                selectedFile = file;
                updatePreview();
            }

            function updatePreview() {
                const uploadDefault = document.getElementById('upload-default');
                const previewContainer = document.getElementById('preview-container');
                const previewImg = document.getElementById('preview-img');
                const uploadActions = document.getElementById('upload-actions');

                if (!selectedFile) {
                    if (uploadDefault) uploadDefault.classList.remove('hidden');
                    if (previewContainer) previewContainer.classList.add('hidden');
                    if (uploadActions) uploadActions.classList.add('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    if (uploadDefault) uploadDefault.classList.add('hidden');
                    if (previewContainer) previewContainer.classList.remove('hidden');
                    if (uploadActions) uploadActions.classList.remove('hidden');
                };
                reader.readAsDataURL(selectedFile);
            }

            function resetImage() {
                selectedFile = null;
                const input = document.getElementById('logo');
                input.value = '';
                updatePreview();
            }

            // Validasi sebelum submit
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                const fileInput = document.getElementById('logo');
                if (!fileInput.files || fileInput.files.length === 0) {
                    alert('Silakan pilih file logo terlebih dahulu.');
                    e.preventDefault();
                    return false;
                }
                
                const file = fileInput.files[0];
                const maxSize = 5 * 1024 * 1024;
                
                if (file.size > maxSize) {
                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });

            // Auto reload setelah berhasil upload logo - hanya jika masih di halaman yang sama
            @if(session('status') && str_contains(session('status'), 'Logo berhasil diperbarui'))
                // Hanya reload jika tidak ada navigasi yang sedang terjadi
                if (!document.querySelector('aside nav a[href="' + window.location.pathname + '"]')?.classList.contains('active')) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                }
            @endif

            // Modal konfirmasi perubahan
            let isSubmitting = false;
            let pendingNavigationUrl = null;
            let initialFileSelected = false;
            const uploadForm = document.getElementById('uploadForm');
            const modal = document.getElementById('confirm-modal');
            const modalCancelBtn = document.getElementById('modal-cancel-btn');
            const modalDiscardBtn = document.getElementById('modal-discard-btn');
            const modalSaveBtn = document.getElementById('modal-save-btn');

            // Check if form has changed (file selected)
            function hasFormChanged() {
                const fileInput = document.getElementById('logo');
                return fileInput && fileInput.files && fileInput.files.length > 0;
            }

            function showModal(url = null) {
                pendingNavigationUrl = url;
                modal.classList.remove('hidden');
            }

            function hideModal() {
                modal.classList.add('hidden');
                pendingNavigationUrl = null;
            }

            // Form submit
            if (uploadForm) {
                uploadForm.addEventListener('submit', () => {
                    isSubmitting = true;
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
                    // Reset file input
                    const fileInput = document.getElementById('logo');
                    if (fileInput) {
                        fileInput.value = '';
                        updatePreview();
                    }
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
                    
                    if (uploadForm) {
                        if (url) {
                            const existingInput = uploadForm.querySelector('input[name="_redirect_after_save"]');
                            if (existingInput) {
                                existingInput.remove();
                            }
                            const redirectInput = document.createElement('input');
                            redirectInput.type = 'hidden';
                            redirectInput.name = '_redirect_after_save';
                            redirectInput.value = url;
                            uploadForm.appendChild(redirectInput);
                        }
                        uploadForm.submit();
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
        </script>
    </div>
@endsection


