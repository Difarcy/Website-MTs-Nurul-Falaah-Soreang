@extends('layouts.admin')

@section('title', 'Edit Berita & Artikel')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-2">
            <p class="text-sm text-slate-500 uppercase tracking-wide font-semibold">Perbarui Konten</p>
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route($type === 'artikel' ? 'admin.artikel.index' : 'admin.berita.index') }}" id="back-btn" class="flex items-center justify-center text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Edit: {{ $post->title }}</h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Terakhir diperbarui {{ $post->updated_at?->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route($type === 'artikel' ? 'admin.artikel.update' : 'admin.berita.update', $post) }}" method="POST" enctype="multipart/form-data" id="edit-form" class="bg-white border border-gray-200 p-6 space-y-6" style="border-radius: 0;">
            @method('PUT')
            @include('admin.posts._form', ['post' => $post, 'type' => $type])
        </form>
    </div>

    <!-- Modal Konfirmasi Perubahan -->
    <div id="confirm-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Ada Perubahan yang Belum Disimpan</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6" id="modal-message">Anda memiliki perubahan yang belum disimpan. Apakah Anda ingin menyimpan perubahan ini?</p>
                <div class="flex items-center justify-end gap-3" id="modal-buttons-container">
                    <!-- Buttons for sidebar navigation (3 buttons) -->
                    <div id="modal-sidebar-buttons" class="hidden flex items-center justify-end gap-3">
                        <button type="button" id="modal-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Tutup</button>
                        <button type="button" id="modal-discard-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                        <button type="button" id="modal-save-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px]">Simpan</button>
                    </div>
                    <!-- Buttons for back/cancel button (3 buttons) -->
                    <div id="modal-back-buttons" class="flex items-center justify-end gap-3">
                        <button type="button" id="modal-back-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                        <button type="button" id="modal-back-continue-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Lanjut Mengedit</button>
                        <button type="button" id="modal-back-save-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px]">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isSubmitting = false;
            const form = document.getElementById('edit-form');
            const backBtn = document.getElementById('back-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const modal = document.getElementById('confirm-modal');
            const modalSidebarButtons = document.getElementById('modal-sidebar-buttons');
            const modalBackButtons = document.getElementById('modal-back-buttons');
            const modalCancelBtn = document.getElementById('modal-cancel-btn');
            const modalDiscardBtn = document.getElementById('modal-discard-btn');
            const modalSaveBtn = document.getElementById('modal-save-btn');
            const modalBackCancelBtn = document.getElementById('modal-back-cancel-btn');
            const modalBackContinueBtn = document.getElementById('modal-back-continue-btn');
            const modalBackSaveBtn = document.getElementById('modal-back-save-btn');
            let pendingNavigationUrl = null;

            if (!form || !backBtn || !cancelBtn || !modal || !modalBackContinueBtn) {
                console.error('Required elements not found');
                return;
            }

            // Function to get form snapshot (all form values)
            function getFormSnapshot() {
                const snapshot = {
                    // Regular inputs
                    inputs: {},
                    // File inputs (check if files exist)
                    files: {},
                    // Tags
                    tags: [],
                    // Existing images
                    existingImages: []
                };

                // Get all regular inputs
                const formInputs = form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]):not([type="file"]), textarea, select');
                formInputs.forEach(input => {
                    const name = input.name;
                    if (name) {
                        if (input.type === 'checkbox') {
                            snapshot.inputs[name] = input.checked;
                        } else {
                            snapshot.inputs[name] = input.value || '';
                        }
                    }
                });

                // Get file inputs (check if files exist)
                const fileInputs = form.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    const name = input.name;
                    if (name) {
                        snapshot.files[name] = input.files.length > 0;
                    }
                });

                // Get tags
                const tagInputs = form.querySelectorAll('input[name="tags[]"]');
                snapshot.tags = Array.from(tagInputs).map(input => input.value.trim()).filter(v => v).sort();

                // Get existing images
                const existingImageInputs = form.querySelectorAll('input[name="existing_images[]"]');
                snapshot.existingImages = Array.from(existingImageInputs).map(input => input.value).sort();

                return snapshot;
            }

            // Get initial form snapshot (wait a bit for dynamic content to load)
            let initialSnapshot = getFormSnapshot();
            
            // Update snapshot after dynamic content loads (tags, images, etc)
            setTimeout(() => {
                initialSnapshot = getFormSnapshot();
            }, 500);

            // Function to check if form has actually changed
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

                // Compare files (if new files uploaded)
                for (const key in currentSnapshot.files) {
                    if (currentSnapshot.files[key] && !initialSnapshot.files[key]) {
                        return true;
                    }
                }

                // Compare tags
                if (JSON.stringify(initialSnapshot.tags) !== JSON.stringify(currentSnapshot.tags)) {
                    return true;
                }

                // Compare existing images
                if (JSON.stringify(initialSnapshot.existingImages) !== JSON.stringify(currentSnapshot.existingImages)) {
                    return true;
                }

                return false;
            }

            // Form submit
            form.addEventListener('submit', () => {
                isSubmitting = true;
            });

            // Back button
            backBtn.addEventListener('click', (e) => {
                if (!isSubmitting && hasFormChanged()) {
                    e.preventDefault();
                    showModal(null); // null = from back button, not sidebar
                }
            });

            // Cancel button
            cancelBtn.addEventListener('click', (e) => {
                if (!isSubmitting && hasFormChanged()) {
                    e.preventDefault();
                    showModal(null); // null = from cancel button, not sidebar
                }
            });

            // Before unload - disabled to avoid browser default warning
            // window.addEventListener('beforeunload', (e) => {
            //     if (!isSubmitting && hasFormChanged()) {
            //         e.preventDefault();
            //         e.returnValue = '';
            //         return '';
            //     }
            // });

            function showModal(url = null) {
                pendingNavigationUrl = url;
                
                // Show/hide appropriate buttons based on source
                if (url) {
                    // From sidebar - show 3 buttons (Cancel, Batal, Simpan)
                    modalSidebarButtons.classList.remove('hidden');
                    modalBackButtons.classList.add('hidden');
                } else {
                    // From back/cancel button - show 2 buttons (Batal, Simpan)
                    modalSidebarButtons.classList.add('hidden');
                    modalBackButtons.classList.remove('hidden');
                }
                
                modal.classList.remove('hidden');
            }

            function hideModal() {
                modal.classList.add('hidden');
                pendingNavigationUrl = null;
            }

            // Modal buttons for sidebar navigation
            modalCancelBtn.addEventListener('click', () => {
                hideModal();
                // Stay on current page (cancel navigation)
            });

            modalDiscardBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Navigate to sidebar menu without saving (discard changes)
                const url = pendingNavigationUrl;
                hideModal();
                
                // Prevent any form submission
                isSubmitting = false;
                
                if (url) {
                    // Immediately navigate, don't wait for any form operations
                    window.location.replace(url);
                }
            });

            modalSaveBtn.addEventListener('click', () => {
                // Store the navigation URL before hiding modal
                const url = pendingNavigationUrl;
                
                if (!url) {
                    console.error('No redirect URL found');
                    hideModal();
                    isSubmitting = true;
                    form.submit();
                    return;
                }
                
                // Remove existing redirect input if any
                const existingInput = form.querySelector('input[name="_redirect_after_save"]');
                if (existingInput) {
                    existingInput.remove();
                }
                
                // Create a hidden input to store the redirect URL
                const redirectInput = document.createElement('input');
                redirectInput.type = 'hidden';
                redirectInput.name = '_redirect_after_save';
                redirectInput.value = url;
                form.appendChild(redirectInput);
                
                // Verify input was added correctly
                const verifyInput = form.querySelector('input[name="_redirect_after_save"]');
                if (!verifyInput || verifyInput.value !== url) {
                    console.error('Failed to add redirect input to form', {
                        url: url,
                        verifyValue: verifyInput ? verifyInput.value : 'null'
                    });
                    hideModal();
                    isSubmitting = true;
                    form.submit();
                    return;
                }
                
                hideModal();
                
                // Save changes then navigate
                isSubmitting = true;
                
                // Submit form - controller will redirect to the URL after save
                form.submit();
            });

            // Modal buttons for back/cancel button
            modalBackCancelBtn.addEventListener('click', () => {
                hideModal();
                // Navigate back to index without saving
                window.location.href = backBtn.href;
            });

            modalBackContinueBtn.addEventListener('click', () => {
                hideModal();
                // Stay on current page (continue editing)
            });

            modalBackSaveBtn.addEventListener('click', () => {
                hideModal();
                // Save changes then navigate
                isSubmitting = true;
                
                // Store the navigation URL to use after form submission
                // For back/cancel buttons, it's always the index page
                let redirectInput = form.querySelector('input[name="_redirect_after_save"]');
                if (!redirectInput) {
                    redirectInput = document.createElement('input');
                    redirectInput.type = 'hidden';
                    redirectInput.name = '_redirect_after_save';
                    form.appendChild(redirectInput);
                }
                redirectInput.value = backBtn.href; // Redirect to index after saving
                
                form.submit();
            });

            // Close modal on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    hideModal();
                }
            });

            // Detect sidebar menu clicks (only on edit page)
            if (document.querySelector('aside nav')) {
                const sidebarLinks = document.querySelectorAll('aside nav a[href]');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        if (!isSubmitting && hasFormChanged()) {
                            e.preventDefault();
                            // Get the href attribute (could be relative or absolute)
                            let targetUrl = link.getAttribute('href');
                            
                            // If it's a relative path, make it absolute
                            if (targetUrl && !targetUrl.startsWith('http') && !targetUrl.startsWith('//')) {
                                // It's a relative path, ensure it starts with /
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

