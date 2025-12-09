@extends('layouts.admin')

@section('title', 'Ticker')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Ticker</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage ticker text displayed on the top bar of the website</p>
            </div>
        </div>

        <!-- Form Tambah Text Baru -->
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Add Ticker</h2>
            <form action="{{ route('admin.running-texts.store') }}" method="POST" id="running-text-form" onsubmit="isSubmitting = true;">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="text" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Ticker Text
                        </label>
                        <textarea
                            id="text"
                            name="text"
                            rows="3"
                            required
                            maxlength="500"
                            class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                            placeholder="Masukkan teks ticker (maksimal 500 karakter)"
                            oninput="updateCharCount('text', 'text-char-count', 500); this.setCustomValidity('')"
                            oninvalid="this.setCustomValidity('Teks ticker wajib diisi.')"
                        >{{ old('text') }}</textarea>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Text will be displayed in order according to position</p>
                            <span id="text-char-count" class="text-xs text-slate-400 dark:text-slate-500">0/500 characters</span>
                        </div>
                        @error('text')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors rounded-lg">
                            Add Ticker
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Text Berjalan -->
        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Ticker List</h2>
            
            @if($runningTexts->count() > 0)
                <div id="running-text-list" class="space-y-3">
                    @foreach($runningTexts as $runningText)
                        <div class="running-text-item bg-slate-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg p-4 cursor-move hover:shadow-md transition-shadow" data-id="{{ $runningText->id }}" data-urutan="{{ $runningText->urutan }}">
                            <div class="flex items-start gap-4">
                                <!-- Drag Handle -->
                                <div class="flex-shrink-0 pt-1 cursor-move">
                                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                    </svg>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-semibold px-2 py-1 {{ $runningText->is_active ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300' }} rounded">
                                            {{ $runningText->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">Posisi: {{ $runningText->urutan }}</span>
                                    </div>
                                    <p class="text-sm text-slate-700 dark:text-slate-300">{{ $runningText->text }}</p>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" onclick="editRunningText({{ $runningText->id }}, '{{ addslashes($runningText->text) }}')" class="px-3 py-1.5 text-xs font-bold text-white bg-green-700 hover:bg-green-800 transition-colors rounded">
                                        Ubah
                                    </button>
                                    <!-- Toggle Aktif -->
                                    <form action="{{ route('admin.running-texts.toggle', $runningText) }}" method="POST" class="inline" onclick="event.stopPropagation()">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-bold {{ $runningText->is_active ? 'bg-green-700 text-white hover:bg-green-800' : 'text-gray-700 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/30 hover:bg-gray-100 dark:hover:bg-gray-900/50' }} transition-colors rounded">
                                            {{ $runningText->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <!-- Hapus -->
                                    <form action="{{ route('admin.running-texts.destroy', $runningText) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus text berjalan ini?');" class="inline" onclick="event.stopPropagation()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-bold bg-red-700 text-white hover:bg-red-800 transition-colors rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 p-12 text-center rounded-lg">
                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400 text-center">Belum ada ticker. Tambahkan ticker pertama Anda di atas.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="edit-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Edit Ticker</h3>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="edit-text" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Ticker Text
                            </label>
                            <textarea
                                id="edit-text"
                                name="text"
                                rows="3"
                                required
                                maxlength="500"
                                class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                                placeholder="Masukkan teks ticker (maksimal 500 karakter)"
                                oninput="updateCharCount('edit-text', 'edit-text-char-count', 500); this.setCustomValidity('')"
                                oninvalid="this.setCustomValidity('Teks ticker wajib diisi.')"
                            ></textarea>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-slate-500 dark:text-slate-400">Text will be displayed in order according to position</p>
                                <span id="edit-text-char-count" class="text-xs text-slate-400 dark:text-slate-500">0/500 characters</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors rounded-lg">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Character counter
        function updateCharCount(inputId, counterId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (input && counter) {
                const length = input.value.length;
                counter.textContent = `${length}/${maxLength} karakter`;
            }
        }

        // Initialize character counters
        document.addEventListener('DOMContentLoaded', function() {
            const textInput = document.getElementById('text');
            if (textInput) {
                updateCharCount('text', 'text-char-count', 500);
            }
        });

        // Edit modal
        window.editRunningText = function(id, text) {
            const modal = document.getElementById('edit-modal');
            const form = document.getElementById('edit-form');
            const textInput = document.getElementById('edit-text');
            
            if (form && textInput && modal) {
                form.action = `{{ url('admin/running-texts') }}/${id}`;
                textInput.value = text;
                updateCharCount('edit-text', 'edit-text-char-count', 500);
                modal.classList.remove('hidden');
                
                // Update snapshot after opening edit modal
                setTimeout(() => {
                    initialSnapshot = getFormSnapshot();
                }, 100);
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-modal');
            if (modal) {
                modal.classList.add('hidden');
                // Reset snapshot when closing edit modal
                setTimeout(() => {
                    initialSnapshot = getFormSnapshot();
                }, 100);
            }
        }

        // Drag and drop untuk reorder
        let draggedElement = null;

        document.addEventListener('DOMContentLoaded', function() {
            const list = document.getElementById('running-text-list');
            if (!list) return;

            const items = list.querySelectorAll('.running-text-item');
            
            items.forEach(item => {
                item.setAttribute('draggable', 'true');
                
                item.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                });
                
                item.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                    draggedElement = null;
                });
                
                item.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    if (draggedElement && draggedElement !== this) {
                        const rect = this.getBoundingClientRect();
                        const midY = rect.top + rect.height / 2;
                        if (e.clientY < midY) {
                            list.insertBefore(draggedElement, this);
                        } else {
                            list.insertBefore(draggedElement, this.nextSibling);
                        }
                    }
                });
                
                item.addEventListener('drop', function(e) {
                    e.preventDefault();
                    if (draggedElement && draggedElement !== this) {
                        saveOrder();
                    }
                });
            });
        });

        function saveOrder() {
            const items = document.querySelectorAll('.running-text-item');
            const order = [];
            
            items.forEach((item, index) => {
                order.push({
                    id: item.dataset.id,
                    urutan: index + 1
                });
            });
            
            fetch('{{ route('admin.running-texts.update-order') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update urutan display
                    items.forEach((item, index) => {
                        const urutanSpan = item.querySelector('.text-xs.text-slate-500');
                        if (urutanSpan) {
                            urutanSpan.textContent = `Posisi: ${index + 1}`;
                        }
                        item.dataset.urutan = index + 1;
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Close modal on background click
        document.getElementById('edit-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Modal konfirmasi perubahan
        let isSubmitting = false;
        let pendingNavigationUrl = null;
        const runningTextForm = document.getElementById('running-text-form');
        const editForm = document.getElementById('edit-form');
        const confirmModal = document.getElementById('confirm-modal');
        const modalCancelBtn = document.getElementById('modal-cancel-btn');
        const modalDiscardBtn = document.getElementById('modal-discard-btn');
        const modalSaveBtn = document.getElementById('modal-save-btn');

        // Get initial form snapshot
        function getFormSnapshot() {
            const snapshot = {
                addText: '',
                editText: '',
                editFormVisible: false
            };

            // Check add form
            if (runningTextForm) {
                const textInput = runningTextForm.querySelector('textarea[name="text"]');
                if (textInput) {
                    snapshot.addText = textInput.value.trim();
                }
            }

            // Check edit form
            const editModal = document.getElementById('edit-modal');
            if (editForm && editModal && editModal.classList && !editModal.classList.contains('hidden')) {
                const editTextInput = editForm.querySelector('textarea[name="text"]');
                if (editTextInput) {
                    snapshot.editText = editTextInput.value.trim();
                    snapshot.editFormVisible = true;
                }
            }

            return snapshot;
        }

        // Set initial snapshot setelah DOM ready (termasuk old('text') jika ada)
        let initialSnapshot = null;
        let snapshotInitialized = false;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial snapshot setelah semua elemen dimuat
            setTimeout(() => {
                initialSnapshot = getFormSnapshot();
                snapshotInitialized = true;
            }, 500);
        });

        // Check if form has changed
        function hasFormChanged() {
            // Jika sedang submit, jangan cek perubahan
            if (isSubmitting) {
                return false;
            }

            // Jika initialSnapshot belum di-set, tidak ada perubahan
            if (!snapshotInitialized || !initialSnapshot) {
                return false;
            }

            const currentSnapshot = getFormSnapshot();

            // Check add form - hanya jika ada teks yang berbeda dari initial
            if (currentSnapshot.addText !== initialSnapshot.addText) {
                return true;
            }

            // Check edit form (only if modal is visible)
            if (currentSnapshot.editFormVisible) {
                if (currentSnapshot.editText !== initialSnapshot.editText) {
                    return true;
                }
            }

            return false;
        }

        function showModal(url = null) {
            pendingNavigationUrl = url;
            if (confirmModal) {
                confirmModal.classList.remove('hidden');
                // Pastikan modal terlihat
                confirmModal.style.display = 'flex';
            }
        }

        function hideModal() {
            if (confirmModal) {
                confirmModal.classList.add('hidden');
                confirmModal.style.display = 'none';
            }
            pendingNavigationUrl = null;
        }

        // Form submit
        if (runningTextForm) {
            runningTextForm.addEventListener('submit', (e) => {
                isSubmitting = true;
                // Update snapshot immediately saat submit
                setTimeout(() => {
                    initialSnapshot = getFormSnapshot();
                    snapshotInitialized = true;
                }, 100);
            });
        }

        if (editForm) {
            editForm.addEventListener('submit', (e) => {
                isSubmitting = true;
                // Update snapshot immediately saat submit
                setTimeout(() => {
                    initialSnapshot = getFormSnapshot();
                    snapshotInitialized = true;
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
                
                // Check which form has changes
                const currentSnapshot = getFormSnapshot();
                const addFormHasText = runningTextForm && currentSnapshot.addText.trim() !== '';
                const editFormHasText = editForm && currentSnapshot.editFormVisible && currentSnapshot.editText.trim() !== '';
                
                // Save add form if it has text
                if (addFormHasText && runningTextForm) {
                    if (url) {
                        const existingInput = runningTextForm.querySelector('input[name="_redirect_after_save"]');
                        if (existingInput) {
                            existingInput.remove();
                        }
                        const redirectInput = document.createElement('input');
                        redirectInput.type = 'hidden';
                        redirectInput.name = '_redirect_after_save';
                        redirectInput.value = url;
                        runningTextForm.appendChild(redirectInput);
                    }
                    runningTextForm.submit();
                    return;
                }

                // Save edit form if it has text
                if (editFormHasText && editForm) {
                    if (url) {
                        const existingInput = editForm.querySelector('input[name="_redirect_after_save"]');
                        if (existingInput) {
                            existingInput.remove();
                        }
                        const redirectInput = document.createElement('input');
                        redirectInput.type = 'hidden';
                        redirectInput.name = '_redirect_after_save';
                        redirectInput.value = url;
                        editForm.appendChild(redirectInput);
                    }
                    editForm.submit();
                    return;
                }

                // If no form to save, just navigate
                if (url) {
                    window.location.replace(url);
                }
            });
        }


        // Close modal on outside click
        if (confirmModal) {
            confirmModal.addEventListener('click', (e) => {
                if (e.target === confirmModal) {
                    hideModal();
                }
            });
        }

        // Detect sidebar menu clicks - sama seperti top-bar dan logo
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const sidebarNav = document.querySelector('aside nav');
                if (sidebarNav) {
                    const links = sidebarNav.querySelectorAll('a');
                    links.forEach(link => {
                        link.addEventListener('click', function(e) {
                            // Skip jika link adalah form submit, button, atau link khusus
                            if (link.closest('form') || link.closest('button') || link.getAttribute('href') === '#' || link.getAttribute('href') === 'javascript:void(0)') {
                                return;
                            }
                            
                            if (!isSubmitting) {
                                const hasChanged = hasFormChanged();
                                if (hasChanged) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    const url = link.getAttribute('href');
                                    if (url) {
                                        showModal(url);
                                    }
                                    return false;
                                }
                            }
                        });
                    });
                }
            }, 1500); // Increase timeout untuk memastikan snapshot sudah di-set
        });
    </script>

    <!-- Modal Konfirmasi Perubahan -->
    <div id="confirm-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Ada Perubahan yang Belum Disimpan</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Anda memiliki perubahan yang belum disimpan. Apakah Anda ingin menyimpan perubahan ini?</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="modal-cancel-btn" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Tutup
                    </button>
                    <button type="button" id="modal-discard-btn" class="px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </button>
                    <button type="button" id="modal-save-btn" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

