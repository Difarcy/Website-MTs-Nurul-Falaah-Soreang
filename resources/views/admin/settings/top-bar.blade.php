@extends('layouts.admin')

@section('title', 'Top Bar')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Top Bar</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage contact information and social media links displayed on the top bar of the website</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <form action="{{ route('admin.settings.top-bar.update') }}" method="POST" id="top-bar-form">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Informasi Kontak -->
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Informasi Kontak</h2>

                        <div class="space-y-4">
                            <!-- Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Nomor Telepon
                                </label>
                                <div class="relative">
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $settings->phone ?? '') }}" maxlength="20" placeholder="Masukkan nomor telepon" inputmode="numeric" autocomplete="tel" onkeypress="return isNumberKey(event)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                        <span id="phone-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('phone', $settings->phone ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/20</span>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Hanya angka dan spasi yang dapat diinput</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Email
                                </label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" value="{{ old('email', $settings->email ?? '') }}" maxlength="50" placeholder="Masukkan email" autocomplete="email" oninput="updateCharCount('email', 50)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                        <span id="email-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('email', $settings->email ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/50</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Link Sosial Media -->
                    <div class="border-t border-gray-200 dark:border-slate-700 pt-6">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Link Sosial Media</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Masukkan URL lengkap untuk setiap platform sosial media (contoh: https://facebook.com/username)</p>

                        <div class="space-y-4">
                            <!-- Facebook -->
                            <div>
                                <label for="facebook_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Facebook URL
                                </label>
                                <div class="relative">
                                    <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" maxlength="150" placeholder="Masukkan URL Facebook" autocomplete="url" oninput="updateCharCount('facebook_url', 150)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                        <span id="facebook_url-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('facebook_url', $settings->facebook_url ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Instagram URL
                                </label>
                                <div class="relative">
                                    <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings->instagram_url ?? '') }}" maxlength="150" placeholder="Masukkan URL Instagram" autocomplete="url" oninput="updateCharCount('instagram_url', 150)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                        <span id="instagram_url-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('instagram_url', $settings->instagram_url ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                    </span>
                                </div>
                            </div>

                            <!-- YouTube -->
                            <div>
                                <label for="youtube_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    YouTube URL
                                </label>
                                <div class="relative">
                                    <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $settings->youtube_url ?? '') }}" maxlength="150" placeholder="Masukkan URL YouTube" autocomplete="url" oninput="updateCharCount('youtube_url', 150)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                        <span id="youtube_url-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('youtube_url', $settings->youtube_url ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                    </span>
                                </div>
                            </div>

                            <!-- TikTok -->
                            <div>
                                <label for="tiktok_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    TikTok URL
                                </label>
                                <div class="relative">
                                    <input type="url" name="tiktok_url" id="tiktok_url" value="{{ old('tiktok_url', $settings->tiktok_url ?? '') }}" maxlength="150" placeholder="Masukkan URL TikTok" autocomplete="url" oninput="updateCharCount('tiktok_url', 150)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 pr-20 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                                        <span id="tiktok_url-count" class="text-slate-400 dark:text-slate-500">{{ mb_strlen(old('tiktok_url', $settings->tiktok_url ?? '')) }}</span><span class="text-slate-400 dark:text-slate-500">/150</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <button type="submit" id="save-topbar-btn" disabled class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
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
        // Update character count
        function updateCharCount(fieldId, maxLength) {
            const input = document.getElementById(fieldId);
            const countElement = document.getElementById(fieldId + '-count');
            if (input && countElement) {
                const length = input.value.length;
                countElement.textContent = length;
                // Pastikan class warna selalu tetap (tidak berubah menjadi merah)
                // Hapus semua kemungkinan class warna merah/amber
                const redClasses = ['text-red-600', 'dark:text-red-400', 'text-red-700', 'dark:text-red-300', 'text-red-500', 'dark:text-red-500', 'text-red-800', 'dark:text-red-600', 'text-red-400', 'dark:text-red-300', 'text-amber-600', 'text-amber-500', 'font-semibold'];
                redClasses.forEach(cls => countElement.classList.remove(cls));
                // Pastikan class warna default selalu ada - paksa dengan remove dan add
                countElement.classList.remove('text-slate-400', 'dark:text-slate-500', 'text-slate-500');
                countElement.classList.add('text-slate-400', 'dark:text-slate-500');
                // Pastikan tidak ada style inline yang mengubah warna
                countElement.style.color = '';
                countElement.style.removeProperty('color');
            }
        }

        // Inisialisasi counter saat halaman dimuat (sebelum DOMContentLoaded)
        function initializeCounters() {
            updateCharCount('phone', 20);
            updateCharCount('email', 50);
            updateCharCount('facebook_url', 150);
            updateCharCount('instagram_url', 150);
            updateCharCount('youtube_url', 150);
            updateCharCount('tiktok_url', 150);
        }

        // Validasi input hanya angka (0-9) dan spasi
        function isNumberKey(event) {
            const char = String.fromCharCode(event.which);
            // Izinkan angka (0-9) dan spasi
            if ((char >= '0' && char <= '9') || char === ' ') {
                return true;
            }
            event.preventDefault();
            return false;
        }

        // Function untuk initialize top bar
        function initializeTopBar() {
            // Inisialisasi counter untuk semua field
            initializeCounters();

            // Validasi saat paste (hanya angka dan spasi) untuk phone
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    // Hanya izinkan angka dan spasi
                    const cleaned = paste.replace(/[^0-9 ]/g, '');
                    this.value = cleaned;
                    updateCharCount('phone', 20);
                });

                // Validasi saat input (hanya angka dan spasi)
                phoneInput.addEventListener('input', function(e) {
                    // Hapus semua karakter yang bukan angka atau spasi
                    this.value = this.value.replace(/[^0-9 ]/g, '');
                    // Update character count
                    updateCharCount('phone', 20);
                });
            }
        });

        // Inisialisasi counter segera setelah script dimuat (jika DOM sudah siap)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCounters);
        } else {
            // DOM sudah siap, langsung inisialisasi
            initializeCounters();
        }

        // Modal konfirmasi perubahan
        let isSubmitting = false;
        let pendingNavigationUrl = null;
        const topBarForm = document.getElementById('top-bar-form');
        const modal = document.getElementById('confirm-modal');
        const modalCancelBtn = document.getElementById('modal-cancel-btn');
        const modalDiscardBtn = document.getElementById('modal-discard-btn');
        const modalSaveBtn = document.getElementById('modal-save-btn');

        // Get initial form snapshot
        function getFormSnapshot() {
            const snapshot = {
                inputs: {}
            };

            if (topBarForm) {
                const inputs = topBarForm.querySelectorAll('input[type="text"], input[type="tel"], input[type="email"], input[type="url"]');
                inputs.forEach(input => {
                    if (input.name && input.id) {
                        snapshot.inputs[input.name] = input.value.trim();
                    }
                });
            }

            return snapshot;
        }

        let initialSnapshot;

        // Check if form has changed
        function hasFormChanged() {
            // Safety check: ensure initialSnapshot is defined
            if (!initialSnapshot || !initialSnapshot.inputs) {
                return false;
            }

            const currentSnapshot = getFormSnapshot();

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

            return false;
        }

        // Fungsi untuk update status tombol Simpan berdasarkan perubahan form
        function updateSaveButtonState() {
            const saveBtn = document.getElementById('save-topbar-btn');
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

        function showModal(url = null) {
            pendingNavigationUrl = url;
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function hideModal() {
            if (modal) {
                modal.classList.add('hidden');
            }
            pendingNavigationUrl = null;
        }

        // Form submit
        if (topBarForm) {
            topBarForm.addEventListener('submit', () => {
                isSubmitting = true;
                // Reset snapshot setelah submit untuk mencegah modal muncul dan disable tombol
                setTimeout(() => {
                    initialSnapshot = getFormSnapshot();
                    updateSaveButtonState();
                }, 100);
            });
        }

        // Event listeners untuk semua input di form topbar
        document.addEventListener('DOMContentLoaded', function() {
            const topBarForm = document.getElementById('top-bar-form');
            if (!topBarForm) return;

            // Simpan snapshot awal segera setelah DOM ready
            initialSnapshot = getFormSnapshot();
            // Set tombol disabled secara default
            updateSaveButtonState();

            // Listen untuk semua perubahan input
            const inputs = topBarForm.querySelectorAll('input[type="text"], input[type="tel"], input[type="email"], input[type="url"]');
            inputs.forEach(input => {
                input.addEventListener('input', updateSaveButtonState);
                input.addEventListener('change', updateSaveButtonState);
            });
        });

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

                if (topBarForm) {
                    if (url) {
                        const existingInput = topBarForm.querySelector('input[name="_redirect_after_save"]');
                        if (existingInput) {
                            existingInput.remove();
                        }
                        const redirectInput = document.createElement('input');
                        redirectInput.type = 'hidden';
                        redirectInput.name = '_redirect_after_save';
                        redirectInput.value = url;
                        topBarForm.appendChild(redirectInput);
                    }
                    topBarForm.submit();
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
@endsection

