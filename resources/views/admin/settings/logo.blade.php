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

        @if(session('status'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/40 border border-green-200 dark:border-green-700 px-4 py-3 text-sm text-green-800 dark:text-green-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="file" name="logo" id="logo" accept="image/*" class="hidden" onchange="handleFileSelect(event)">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Area Upload Drag & Drop -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Pilih Logo Baru</label>
                        <div id="upload-area" class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-0 min-h-[300px] cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors relative overflow-hidden" onclick="if(!event.target.closest('#preview-image')) document.getElementById('logo').click()" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                            <!-- Default Content -->
                            <div id="upload-default" class="absolute inset-0 flex items-center justify-center p-6">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Klik untuk Upload atau Drag & Drop</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Format: PNG, JPG, atau SVG (Maksimal 5MB)</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Disarankan PNG transparan</p>
                                </div>
                            </div>

                            <!-- Preview Image -->
                            <div id="preview-image" class="hidden absolute inset-0 p-4">
                                <img id="preview-img" src="" alt="Preview" class="w-full h-full object-contain">
                            </div>
                        </div>
                        @error('logo') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror

                        <!-- Tombol Aksi -->
                        <div id="upload-actions" class="hidden mt-4 flex justify-end gap-3">
                            <button type="button" onclick="resetImage()" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                                Upload Logo
                            </button>
                        </div>
                    </div>

                    <!-- Preview Logo Saat Ini -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Pratinjau Logo yang Dipakai</label>
                        <div class="w-full aspect-square border border-gray-200 dark:border-slate-600 rounded-lg flex items-center justify-center bg-slate-50 dark:bg-slate-700 overflow-hidden">
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

        <script>
            // Drag & Drop dan Preview Logo
            let selectedFile = null;

            function handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                // Validasi tipe file
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar (PNG, JPG, atau SVG)');
                    event.target.value = '';
                    return;
                }
                
                // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
                const maxSize = 5 * 1024 * 1024;
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
                    alert('File harus berupa gambar (PNG, JPG, atau SVG)');
                    return;
                }
                
                // Validasi ukuran file
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
        </script>
    </div>
@endsection


