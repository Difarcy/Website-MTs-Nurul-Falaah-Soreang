@extends('layouts.admin')

@section('title', 'Tampilan Web')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Tampilan Web</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola banner, logo, dan pengaturan top bar</p>
        </div>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700">
        <!-- Tabs -->
        <div class="border-b border-gray-200 dark:border-slate-700">
            <div class="flex overflow-x-auto">
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border-b-2 border-green-700 bg-green-50 dark:bg-green-900/20" data-tab="banner">
                    Banner
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="logo">
                    Logo
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="top-bar">
                    Top Bar
                </button>
            </div>
        </div>

        <!-- Tab Content: Banner -->
        <div id="tab-banner" class="tab-content p-6">
            @include('admin.banners.index', ['inline' => true, 'banners' => $banners, 'settings' => $bannerSettings])
        </div>

        <!-- Tab Content: Logo -->
        <div id="tab-logo" class="tab-content hidden p-6 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-1">Logo</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Unggah logo baru untuk dipakai di seluruh website</p>
            </div>

            <form action="{{ route('admin.tampilan-web.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Upload Logo Baru</label>

                        <!-- Drag & Drop Card untuk Logo -->
                        <input type="file" name="logo" id="logo-upload" accept="image/*" class="hidden" onchange="handleLogoFileSelect(event)">

                        <div id="logo-upload-card" class="w-full aspect-square border-2 border-dashed border-gray-300 dark:border-slate-600 p-6 text-center cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors relative flex flex-col items-center justify-center rounded-lg" ondrop="handleLogoDrop(event)" ondragover="handleLogoDragOver(event)" ondragleave="handleLogoDragLeave(event)" onclick="if(!event.target.closest('#logo-preview-container') && !event.target.closest('button')) document.getElementById('logo-upload').click()">
                            <!-- Default Content -->
                            <div id="logo-upload-default" class="space-y-3">
                                <svg class="w-12 h-12 text-gray-400 dark:text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <div>
                                    <button type="button" onclick="event.stopPropagation(); document.getElementById('logo-upload').click();" class="px-4 py-2.5 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2 mx-auto" style="border-radius: 0;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Upload Logo
                                    </button>
                                </div>
                                <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Atau seret dan lepas logo ke area ini</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 text-center">Format: PNG, JPG, SVG (Maks. 5MB)</p>
                            </div>

                            <!-- Preview Image -->
                            <div id="logo-preview-container" class="hidden w-full h-full items-center justify-center">
                                <div class="relative w-full h-full flex items-center justify-center group">
                                    <div class="relative max-w-[90%] max-h-[90%]">
                                        <img id="logo-preview-img" src="" alt="Preview Logo" class="w-full h-full object-contain pointer-events-none">
                                        <button type="button" onclick="event.stopPropagation(); resetLogoImage();" class="absolute top-0 right-0 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10 -mt-1 -mr-1">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Logo Saat Ini</label>
                        <div class="w-full aspect-square border border-gray-200 dark:border-slate-600 rounded-lg flex items-center justify-center bg-slate-50 dark:bg-slate-700 overflow-hidden">
                            @php
                                $logoPath = optional($siteSettings)->logo_path ? 'storage/' . $siteSettings->logo_path : 'img/logo.png';
                                $logoVersion = $siteSettings && $siteSettings->logo_path ? ($siteSettings->updated_at ? $siteSettings->updated_at->timestamp : time()) : (file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null);
                                $logoSrc = asset($logoPath) . ($logoVersion ? '?v=' . $logoVersion : '');
                            @endphp
                            <img src="{{ $logoSrc }}" alt="Logo saat ini" class="max-w-[80%] max-h-[80%] object-contain">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="submit" id="logo-submit-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Simpan Logo
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab Content: Top Bar -->
        <div id="tab-top-bar" class="tab-content hidden p-6 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-1">Top Bar</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Kelola informasi kontak dan link sosial media di top bar</p>
            </div>

            <form action="{{ route('admin.tampilan-web.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="top_bar_phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nomor Telepon</label>
                        <input type="tel" name="top_bar[phone]" id="top_bar_phone" value="{{ old('top_bar.phone', $topBarSettings->phone ?? '') }}" maxlength="20" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="top_bar_email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                        <input type="email" name="top_bar[email]" id="top_bar_email" value="{{ old('top_bar.email', $topBarSettings->email ?? '') }}" maxlength="50" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="top_bar_facebook_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Facebook URL</label>
                        <input type="url" name="top_bar[facebook_url]" id="top_bar_facebook_url" value="{{ old('top_bar.facebook_url', $topBarSettings->facebook_url ?? '') }}" maxlength="150" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="top_bar_instagram_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Instagram URL</label>
                        <input type="url" name="top_bar[instagram_url]" id="top_bar_instagram_url" value="{{ old('top_bar.instagram_url', $topBarSettings->instagram_url ?? '') }}" maxlength="150" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="top_bar_youtube_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">YouTube URL</label>
                        <input type="url" name="top_bar[youtube_url]" id="top_bar_youtube_url" value="{{ old('top_bar.youtube_url', $topBarSettings->youtube_url ?? '') }}" maxlength="150" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="top_bar_tiktok_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">TikTok URL</label>
                        <input type="url" name="top_bar[tiktok_url]" id="top_bar_tiktok_url" value="{{ old('top_bar.tiktok_url', $topBarSettings->tiktok_url ?? '') }}" maxlength="150" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="submit" id="topbar-submit-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unsaved Changes Modal -->
<div id="unsavedChangesModal" class="fixed inset-0 bg-black/25 dark:bg-black/50 backdrop-blur-[1px] z-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-slate-800 rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Perubahan Belum Disimpan</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman ini?</p>
            </div>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" id="cancelLeaveBtn" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-700 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600">
                Batal
            </button>
            <button type="button" id="confirmLeaveBtn" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                Tinggalkan
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                tabButtons.forEach(btn => {
                    btn.classList.remove('border-b-2', 'border-green-700', 'border-transparent', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');
                    btn.classList.add('border-b-2', 'border-transparent', 'text-slate-500', 'dark:text-slate-400');
                });
                this.classList.remove('text-slate-500', 'dark:text-slate-400', 'border-transparent');
                this.classList.add('border-b-2', 'border-green-700', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById('tab-' + targetTab).classList.remove('hidden');
            });
        });

        // Logo Drag & Drop Functions
        window.handleLogoFileSelect = function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showLogoPreview(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        };

        window.handleLogoDrop = function(event) {
            event.preventDefault();
            event.stopPropagation();

            const card = document.getElementById('logo-upload-card');
            card.classList.remove('border-green-500', 'dark:border-green-600');
            card.classList.add('border-gray-300', 'dark:border-slate-600');

            const files = event.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showLogoPreview(e.target.result);
                };
                reader.readAsDataURL(files[0]);
            }
        };

        window.handleLogoDragOver = function(event) {
            event.preventDefault();
            event.stopPropagation();

            const card = document.getElementById('logo-upload-card');
            card.classList.remove('border-gray-300', 'dark:border-slate-600');
            card.classList.add('border-green-500', 'dark:border-green-600');
        };

        window.handleLogoDragLeave = function(event) {
            event.preventDefault();
            event.stopPropagation();

            const card = document.getElementById('logo-upload-card');
            card.classList.remove('border-green-500', 'dark:border-green-600');
            card.classList.add('border-gray-300', 'dark:border-slate-600');
        };

        window.showLogoPreview = function(imageSrc) {
            document.getElementById('logo-upload-default').classList.add('hidden');
            document.getElementById('logo-preview-container').classList.remove('hidden');
            document.getElementById('logo-preview-img').src = imageSrc;

            // Enable tombol simpan ketika ada gambar
            const submitBtn = document.getElementById('logo-submit-btn');
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            submitBtn.removeAttribute('disabled');
        };

        window.resetLogoImage = function() {
            document.getElementById('logo-upload-default').classList.remove('hidden');
            document.getElementById('logo-preview-container').classList.add('hidden');
            document.getElementById('logo-preview-img').src = '';
            document.getElementById('logo-upload').value = '';

            // Disable tombol simpan ketika tidak ada gambar
            const submitBtn = document.getElementById('logo-submit-btn');
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
            submitBtn.setAttribute('disabled', 'disabled');
        };

        // Top Bar Form Changes Detection
        let topBarInitialValues = {};
        let topBarCurrentValues = {};

        // Function to get initial values for Top Bar
        function getTopBarInitialValues() {
            const inputs = ['top_bar_phone', 'top_bar_email', 'top_bar_facebook_url', 'top_bar_instagram_url', 'top_bar_youtube_url', 'top_bar_tiktok_url'];
            const values = {};
            inputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    values[id] = element.value;
                }
            });
            return values;
        }

        // Function to get current values for Top Bar
        function getTopBarCurrentValues() {
            const inputs = ['top_bar_phone', 'top_bar_email', 'top_bar_facebook_url', 'top_bar_instagram_url', 'top_bar_youtube_url', 'top_bar_tiktok_url'];
            const values = {};
            inputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    values[id] = element.value;
                }
            });
            return values;
        }

        // Function to check if Top Bar form has changes
        function hasTopBarChanges() {
            const current = getTopBarCurrentValues();
            for (const key in topBarInitialValues) {
                if (current[key] !== topBarInitialValues[key]) {
                    return true;
                }
            }
            return false;
        }

        // Function to update Top Bar save button state
        function updateTopBarSaveButtonState() {
            const saveBtn = document.getElementById('topbar-submit-btn');
            if (hasTopBarChanges()) {
                // Enable tombol
                saveBtn.disabled = false;
                saveBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                saveBtn.removeAttribute('disabled');
            } else {
                // Disable tombol
                saveBtn.disabled = true;
                saveBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
                saveBtn.setAttribute('disabled', 'disabled');
            }
        }

        // Initialize Top Bar form when tab is opened
        function initializeTopBarForm() {
            topBarInitialValues = getTopBarInitialValues();
            updateTopBarSaveButtonState();

            // Add event listeners to all Top Bar inputs
            const inputs = ['top_bar_phone', 'top_bar_email', 'top_bar_facebook_url', 'top_bar_instagram_url', 'top_bar_youtube_url', 'top_bar_tiktok_url'];
            inputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateTopBarSaveButtonState);
                    element.addEventListener('change', updateTopBarSaveButtonState);
                }
            });
        }

        // Modify tab switching to initialize Top Bar form
        const originalTabSwitch = function() {
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-b-2', 'border-green-700', 'border-transparent', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');
                        btn.classList.add('border-b-2', 'border-transparent', 'text-slate-500', 'dark:text-slate-400');
                    });
                    this.classList.remove('text-slate-500', 'dark:text-slate-400', 'border-transparent');
                    this.classList.add('border-b-2', 'border-green-700', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    const targetContent = document.getElementById('tab-' + targetTab);
                    targetContent.classList.remove('hidden');

                    // Initialize Top Bar form when Top Bar tab is opened
                    if (targetTab === 'top-bar') {
                        setTimeout(() => {
                            initializeTopBarForm();
                        }, 100);
                    }
                });
            });
        };

        // Override the original tab switching
        originalTabSwitch();

        // Form submission handlers to stay on same tab
        function handleFormSubmit(event, formType) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');

            // Disable submit button during submission
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Menyimpan...';
            submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');

            // Submit form via fetch
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showSuccessMessage(data.message || 'Data berhasil disimpan!');

                    // Reset form state based on type
                    if (formType === 'logo') {
                        resetLogoImage();
                    } else if (formType === 'topbar') {
                        // Update initial values and disable button
                        topBarInitialValues = getTopBarCurrentValues();
                        updateTopBarSaveButtonState();
                    }

                    // Reset submit button
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                } else {
                    // Show error message
                    showErrorMessage(data.message || 'Terjadi kesalahan saat menyimpan data.');

                    // Reset submit button
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Submit error:', error);
                showErrorMessage('Terjadi kesalahan jaringan. Silakan coba lagi.');

                // Reset submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            });
        }

        // Success message function
        function showSuccessMessage(message) {
            // Remove existing success messages
            const existingSuccess = document.querySelector('.success-message');
            if (existingSuccess) {
                existingSuccess.remove();
            }

            const successDiv = document.createElement('div');
            successDiv.className = 'success-message mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            successDiv.textContent = message;

            // Insert at the beginning of the active tab
            const activeTab = document.querySelector('.tab-content:not(.hidden)');
            if (activeTab) {
                activeTab.insertBefore(successDiv, activeTab.firstChild);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    successDiv.remove();
                }, 5000);
            }
        }

        // Error message function
        function showErrorMessage(message) {
            // Remove existing error messages
            const existingError = document.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }

            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            errorDiv.textContent = message;

            // Insert at the beginning of the active tab
            const activeTab = document.querySelector('.tab-content:not(.hidden)');
            if (activeTab) {
                activeTab.insertBefore(errorDiv, activeTab.firstChild);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    errorDiv.remove();
                }, 5000);
            }
        }

        // Add submit event listeners to forms
        document.addEventListener('DOMContentLoaded', function() {
            // Logo form
            const logoForm = document.querySelector('#tab-logo form');
            if (logoForm) {
                logoForm.addEventListener('submit', (e) => handleFormSubmit(e, 'logo'));
            }

            // Top Bar form
            const topBarForm = document.querySelector('#tab-top-bar form');
            if (topBarForm) {
                topBarForm.addEventListener('submit', (e) => handleFormSubmit(e, 'topbar'));
            }
        });

        // Unsaved Changes Modal Logic
        let pendingTabSwitch = null;

        // File preview stage (belum upload) harus dianggap "ada perubahan"
        function hasLogoChanges() {
            const logoInput = document.getElementById('logo-upload');
            const previewImg = document.getElementById('logo-preview-img');
            const hasFile = !!(logoInput && logoInput.files && logoInput.files.length > 0);
            const hasPreviewSrc = !!(previewImg && previewImg.getAttribute('src'));
            return hasFile || hasPreviewSrc;
        }

        function hasBannerUploadChanges() {
            const bannerInput = document.getElementById('gambar');
            const promosiInput = document.getElementById('promosi_banner');
            const bannerPreviewImg = document.getElementById('preview-img');
            const promosiPreviewImg = document.getElementById('promosi-preview-img');

            const hasBannerFile = !!(bannerInput && bannerInput.files && bannerInput.files.length > 0);
            const hasPromosiFile = !!(promosiInput && promosiInput.files && promosiInput.files.length > 0);
            const hasBannerPreviewSrc = !!(bannerPreviewImg && bannerPreviewImg.getAttribute('src'));
            const hasPromosiPreviewSrc = !!(promosiPreviewImg && promosiPreviewImg.getAttribute('src'));

            return hasBannerFile || hasPromosiFile || hasBannerPreviewSrc || hasPromosiPreviewSrc;
        }

        function hasBannerChanges() {
            // 1) Upload stage (preview) -> cukup file terpilih
            if (hasBannerUploadChanges()) return true;

            // 2) Settings form stage -> fallback dari tombol save (cara lama)
            const bannerSaveBtn = document.getElementById('save-settings-btn');
            return !!(bannerSaveBtn && !bannerSaveBtn.disabled);
        }

        function hasAnyUnsavedChanges() {
            // hasTopBarChanges() hanya valid jika topBarInitialValues sudah di-set.
            return hasBannerChanges() || hasLogoChanges() || hasTopBarChanges();
        }

        // Show unsaved changes modal
        function showUnsavedChangesModal(callback) {
            const modal = document.getElementById('unsavedChangesModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Tambahkan flex untuk centering

            const cancelBtn = document.getElementById('cancelLeaveBtn');
            const confirmBtn = document.getElementById('confirmLeaveBtn');

            // Remove existing listeners
            cancelBtn.replaceWith(cancelBtn.cloneNode(true));
            confirmBtn.replaceWith(confirmBtn.cloneNode(true));

            // Add new listeners
            document.getElementById('cancelLeaveBtn').addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                if (callback) callback(false);
            });

            document.getElementById('confirmLeaveBtn').addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                if (callback) callback(true);
            });

            // Tutup modal saat klik area gelap (outside)
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    if (callback) callback(false);
                }
            }, { once: true });
        }

        // Enhanced tab switching with unsaved changes detection
        function enhancedTabSwitch() {
            tabButtons.forEach(button => {
                // Capture phase supaya handler tab lain tidak keburu jalan
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();

                    const targetTab = this.getAttribute('data-tab');
                    const currentTab = document.querySelector('.tab-content:not(.hidden)');
                    const currentTabId = currentTab ? currentTab.id.replace('tab-', '') : '';

                    if (!targetTab || targetTab === currentTabId) return;

                    // Check if we're leaving a tab with unsaved changes
                    if (currentTabId === 'logo' && hasLogoChanges()) {
                        event.preventDefault();
                        pendingTabSwitch = targetTab;
                        showUnsavedChangesModal((confirmed) => {
                            if (confirmed) {
                                // Reset logo form and proceed with tab switch
                                resetLogoImage();
                                performTabSwitch(targetTab);
                            }
                            pendingTabSwitch = null;
                        });
                    } else if (currentTabId === 'top-bar' && hasTopBarChanges()) {
                        event.preventDefault();
                        pendingTabSwitch = targetTab;
                        showUnsavedChangesModal((confirmed) => {
                            if (confirmed) {
                                // Reset top bar form and proceed with tab switch
                                topBarInitialValues = getTopBarCurrentValues();
                                updateTopBarSaveButtonState();
                                performTabSwitch(targetTab);
                            }
                            pendingTabSwitch = null;
                        });
                    } else if (currentTabId === 'banner' && hasBannerChanges()) {
                        pendingTabSwitch = targetTab;
                        showUnsavedChangesModal((confirmed) => {
                            if (confirmed) {
                                // Reset preview upload banner/promosi jika tersedia
                                if (typeof window.resetImage === 'function') {
                                    window.resetImage();
                                }
                                if (typeof window.resetPromosiImage === 'function') {
                                    window.resetPromosiImage();
                                }
                                performTabSwitch(targetTab);
                            }
                            pendingTabSwitch = null;
                        });
                    } else {
                        // No unsaved changes, proceed normally
                        performTabSwitch(targetTab);
                    }
                }, true);
            });
        }

        // Perform actual tab switch
        function performTabSwitch(targetTab) {
            tabButtons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-green-700', 'border-transparent', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');
                btn.classList.add('border-b-2', 'border-transparent', 'text-slate-500', 'dark:text-slate-400');
            });

            const activeBtn = document.querySelector(`[data-tab="${targetTab}"]`);
            activeBtn.classList.remove('text-slate-500', 'dark:text-slate-400', 'border-transparent');
            activeBtn.classList.add('border-b-2', 'border-green-700', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');

            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            const targetContent = document.getElementById('tab-' + targetTab);
            targetContent.classList.remove('hidden');

            // Initialize Top Bar form when Top Bar tab is opened
            if (targetTab === 'top-bar') {
                setTimeout(() => {
                    initializeTopBarForm();
                }, 100);
            }
        }

        // Override with enhanced tab switching
        enhancedTabSwitch();

        // Intercept klik menu sidebar (pindah halaman) saat ada perubahan yang belum disimpan
        document.addEventListener('click', function(e) {
            const link = e.target.closest('aside#admin-sidebar a[href]');
            if (!link) return;

            const url = link.getAttribute('href');
            if (!url || url.startsWith('#')) return;

            if (!hasAnyUnsavedChanges()) return;

            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            showUnsavedChangesModal((confirmed) => {
                if (confirmed) {
                    window.location.href = url;
                }
            });
        }, true);
    });
</script>
@endsection
