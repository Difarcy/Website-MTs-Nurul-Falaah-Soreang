@extends('layouts.admin')

@section('title', 'Tambah Berita & Artikel')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm text-slate-500 uppercase tracking-wide font-semibold">Konten Baru</p>
            <div class="flex items-center gap-3 mt-1">
                <a href="{{ route($type === 'artikel' ? 'admin.artikel.index' : 'admin.berita.index') }}" id="back-btn" class="flex items-center justify-center text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Tambah {{ ucfirst($type) }}</h1>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Isi formulir berikut untuk mempublikasikan informasi di website utama.</p>
        </div>

        <form action="{{ route($type === 'artikel' ? 'admin.artikel.store' : 'admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="create-form" class="bg-white border border-gray-200 p-6 space-y-6" style="border-radius: 0;">
            @include('admin.posts._form', ['post' => $post, 'type' => $type])
        </form>
    </div>

    <!-- Modal Konfirmasi Perubahan -->
    <div id="confirm-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Ada Perubahan yang Belum Disimpan</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Anda memiliki perubahan yang belum disimpan. Apakah Anda ingin membatalkan dan kembali, atau lanjut menambahkan?</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="modal-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                    <button type="button" id="modal-continue-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px]">Lanjut Menambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isSubmitting = false;
            let initialSnapshot = null;
            let pendingNavigationUrl = null; // To store URL for sidebar navigation

            const form = document.getElementById('create-form');
            const backBtn = document.getElementById('back-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const modal = document.getElementById('confirm-modal');
            const modalCancelBtn = document.getElementById('modal-cancel-btn');
            const modalContinueBtn = document.getElementById('modal-continue-btn');

            if (!form || !backBtn || !cancelBtn || !modal || !modalCancelBtn || !modalContinueBtn) {
                console.error('Required elements not found');
                return;
            }

            // Function to get current form state
            function getFormSnapshot() {
                const snapshot = {
                    inputs: {},
                    files: {},
                    tags: [],
                    existingImages: []
                };

                // Get all regular inputs, textareas, and selects
                const formInputs = form.querySelectorAll('input:not([type="file"]):not([type="hidden"]):not([type="submit"]), textarea, select');
                formInputs.forEach(input => {
                    const name = input.name;
                    if (name && name !== '_token' && name !== '_method') {
                        if (input.type === 'checkbox') {
                            snapshot.inputs[name] = input.checked;
                        } else {
                            snapshot.inputs[name] = (input.value || '').trim();
                        }
                    }
                });

                // Get file inputs (check if files exist)
                const fileInputs = form.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    const name = input.name;
                    if (name) {
                        snapshot.files[name] = input.files.length > 0 ? input.files[0].name : null;
                    }
                });

                // Get tags
                const tagInputs = form.querySelectorAll('input[name="tags[]"]');
                snapshot.tags = Array.from(tagInputs).map(input => input.value.trim()).filter(v => v).sort();

                // Get existing images
                const existingImageInputs = form.querySelectorAll('input[name="existing_images[]"]');
                snapshot.existingImages = Array.from(existingImageInputs).map(input => input.value).filter(v => v).sort();

                return snapshot;
            }

            // Function to compare current form state with initial snapshot
            function hasFormChanged() {
                if (!initialSnapshot) return false; // Should not happen if snapshot is taken on load

                const currentSnapshot = getFormSnapshot();

                // Compare regular inputs
                for (const key in initialSnapshot.inputs) {
                    const initialValue = String(initialSnapshot.inputs[key] || '').trim();
                    const currentValue = String(currentSnapshot.inputs[key] || '').trim();
                    if (initialValue !== currentValue) {
                        return true;
                    }
                }
                // Check for newly added inputs not in initial snapshot
                for (const key in currentSnapshot.inputs) {
                    if (!(key in initialSnapshot.inputs)) {
                        const currentValue = String(currentSnapshot.inputs[key] || '').trim();
                        if (currentValue !== '') {
                            return true;
                        }
                    }
                }

                // Compare file inputs (check if a file is selected or existing one removed)
                for (const key in initialSnapshot.files) {
                    if (initialSnapshot.files[key] !== currentSnapshot.files[key]) {
                        return true;
                    }
                }
                // Check for newly added files not in initial snapshot
                for (const key in currentSnapshot.files) {
                    if (currentSnapshot.files[key] && !initialSnapshot.files[key]) {
                        return true;
                    }
                }

                // Compare tags
                const initialTags = initialSnapshot.tags || [];
                const currentTags = currentSnapshot.tags || [];
                if (JSON.stringify(initialTags) !== JSON.stringify(currentTags)) {
                    return true;
                }

                // Compare existing images
                const initialImages = initialSnapshot.existingImages || [];
                const currentImages = currentSnapshot.existingImages || [];
                if (JSON.stringify(initialImages) !== JSON.stringify(currentImages)) {
                    return true;
                }

                return false;
            }

            // Function to activate observer (only after user interaction)
            let observerActive = false;
            let observer = null;

            function activateObserver() {
                if (observerActive) return;
                observerActive = true;

                observer = new MutationObserver(() => {
                    // No need to set formChanged = true here, hasFormChanged will check actual differences
                });

                // Observe changes in tags container and images container
                const tagsContainer = document.getElementById('tags-container');
                const imagesPreviewContainer = document.getElementById('images-preview-container');
                const existingImagesContainer = document.getElementById('existing-images-container');

                if (tagsContainer) {
                    observer.observe(tagsContainer, { childList: true, subtree: true });
                }
                if (imagesPreviewContainer) {
                    observer.observe(imagesPreviewContainer, { childList: true, subtree: true });
                }
                if (existingImagesContainer) {
                    observer.observe(existingImagesContainer, { childList: true, subtree: true });
                }
            }

            // Detect form changes
            const formInputs = form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]), textarea, select');
            formInputs.forEach(input => {
                input.addEventListener('change', activateObserver);
                input.addEventListener('input', activateObserver);
            });

            // File inputs
            const fileInputs = form.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', activateObserver);
            });

            // Activate observer on any form interaction
            form.addEventListener('click', activateObserver, { once: true });
            form.addEventListener('focus', activateObserver, { once: true, capture: true });

            // Take initial snapshot after DOM is fully loaded and any dynamic elements are rendered
            // Use a small timeout to ensure all JS has run and elements are in their final initial state
            setTimeout(() => {
                initialSnapshot = getFormSnapshot();
                // Debug: log initial snapshot to verify it's captured correctly
                // console.log('Initial snapshot:', initialSnapshot);
            }, 200);

            // Form submit
            form.addEventListener('submit', () => {
                isSubmitting = true;
            });

            // Back button
            backBtn.addEventListener('click', (e) => {
                if (!isSubmitting && hasFormChanged()) {
                    e.preventDefault();
                    showModal(null); // No specific URL, implies back to index
                }
            });

            // Cancel button
            cancelBtn.addEventListener('click', (e) => {
                if (!isSubmitting && hasFormChanged()) {
                    e.preventDefault();
                    showModal(null); // No specific URL, implies back to index
                }
            });

            function showModal(url = null) {
                pendingNavigationUrl = url;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function hideModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                pendingNavigationUrl = null;
            }

            // Modal buttons
            modalCancelBtn.addEventListener('click', () => {
                const url = pendingNavigationUrl;
                hideModal();
                // Navigate to the target URL (sidebar menu) or back to index
                if (url) {
                    window.location.href = url;
                } else {
                    window.location.href = backBtn.href;
                }
            });

            modalContinueBtn.addEventListener('click', () => {
                hideModal();
                // Stay on current page (continue adding)
            });

            // Close modal on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    hideModal();
                }
            });

            // Detect sidebar menu clicks (only on create page)
            if (document.querySelector('aside nav')) {
                const sidebarLinks = document.querySelectorAll('aside nav a[href]');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        if (!isSubmitting && hasFormChanged()) {
                            e.preventDefault();
                            // Get the href attribute (could be relative or absolute)
                            let targetUrl = link.getAttribute('href');

                            // If it's a relative path, ensure it starts with /
                            if (targetUrl && !targetUrl.startsWith('http') && !targetUrl.startsWith('//')) {
                                if (!targetUrl.startsWith('/')) {
                                    targetUrl = '/' + targetUrl;
                                }
                            }

                            showModal(targetUrl);
                        }
                    });
                });
            }
        });
    </script>
@endsection

