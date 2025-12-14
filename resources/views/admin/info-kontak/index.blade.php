@extends('layouts.admin')

@section('title', 'Info Kontak')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Info Kontak</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola kontak dan informasi footer (alamat & sosial media)</p>
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
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border-b-2 border-green-700 bg-green-50 dark:bg-green-900/20" data-tab="kontak">
                    Kontak
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="footer">
                    Footer (Alamat & Sosmed)
                </button>
            </div>
        </div>

        <form action="{{ route('admin.info-kontak.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Tab Content: Kontak -->
            <div id="tab-kontak" class="tab-content">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Kontak</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola informasi kontak yang ditampilkan di halaman kontak</p>
                </div>

                <div class="mb-4">
                    <a href="{{ route('admin.kontak.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800">
                        + Tambah Kontak Baru
                    </a>
                </div>

                @if($kontaks->count() > 0)
                    <div class="space-y-3">
                        @foreach($kontaks as $index => $kontak)
                            <div class="border-2 border-gray-200 dark:border-slate-600 rounded-lg p-4 space-y-3">
                                <input type="hidden" name="kontak[{{ $index }}][id]" value="{{ $kontak->id }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jenis</label>
                                        <input type="text" name="kontak[{{ $index }}][jenis]" value="{{ old("kontak.$index.jenis", $kontak->jenis) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Label</label>
                                        <input type="text" name="kontak[{{ $index }}][label]" value="{{ old("kontak.$index.label", $kontak->label) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nilai</label>
                                        <input type="text" name="kontak[{{ $index }}][nilai]" value="{{ old("kontak.$index.nilai", $kontak->nilai) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Icon</label>
                                        <input type="text" name="kontak[{{ $index }}][icon]" value="{{ old("kontak.$index.icon", $kontak->icon) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Urutan</label>
                                        <input type="number" name="kontak[{{ $index }}][urutan]" value="{{ old("kontak.$index.urutan", $kontak->urutan) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                    </div>
                                    <div class="flex items-end">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="kontak[{{ $index }}][is_active]" value="1" {{ old("kontak.$index.is_active", $kontak->is_active) ? 'checked' : '' }} class="w-5 h-5">
                                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Aktif</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.kontak.edit', $kontak) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                        Edit Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 dark:text-slate-400">Belum ada kontak</p>
                @endif
            </div>

            <!-- Tab Content: Footer -->
            <div id="tab-footer" class="tab-content hidden">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Footer (Alamat & Sosial Media)</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Kelola alamat dan link sosial media yang ditampilkan di footer website</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="footer_alamat" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat</label>
                        <textarea name="footer_alamat" id="footer_alamat" rows="3" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">{{ old('footer_alamat', $alamat->value ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="footer_email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                        <input type="email" name="footer_email" id="footer_email" value="{{ old('footer_email', $email->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="footer_whatsapp" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">WhatsApp</label>
                        <input type="text" name="footer_whatsapp" id="footer_whatsapp" value="{{ old('footer_whatsapp', $whatsapp->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div class="border-t border-gray-200 dark:border-slate-700 pt-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-slate-100 mb-4">Link Sosial Media</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="footer_facebook_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Facebook URL</label>
                                <input type="url" name="footer_facebook_url" id="footer_facebook_url" value="{{ old('footer_facebook_url', $facebookUrl->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label for="footer_instagram_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Instagram URL</label>
                                <input type="url" name="footer_instagram_url" id="footer_instagram_url" value="{{ old('footer_instagram_url', $instagramUrl->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label for="footer_youtube_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">YouTube URL</label>
                                <input type="url" name="footer_youtube_url" id="footer_youtube_url" value="{{ old('footer_youtube_url', $youtubeUrl->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label for="footer_tiktok_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">TikTok URL</label>
                                <input type="url" name="footer_tiktok_url" id="footer_tiktok_url" value="{{ old('footer_tiktok_url', $tiktokUrl->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200 dark:border-slate-700">
                <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                    Simpan Semua Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

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
        const form = document.querySelector('form');

        let isDirty = false;
        let pendingNavigationUrl = null;
        let pendingTabTarget = null;

        if (form) {
            form.addEventListener('input', () => { isDirty = true; }, true);
            form.addEventListener('change', () => { isDirty = true; }, true);
            form.addEventListener('submit', () => { isDirty = false; }, true);
        }

        function showUnsavedModal(onConfirm) {
            const modal = document.getElementById('unsavedChangesModal');
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const cancelBtn = document.getElementById('cancelLeaveBtn');
            const confirmBtn = document.getElementById('confirmLeaveBtn');
            if (cancelBtn) cancelBtn.replaceWith(cancelBtn.cloneNode(true));
            if (confirmBtn) confirmBtn.replaceWith(confirmBtn.cloneNode(true));

            document.getElementById('cancelLeaveBtn')?.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                pendingNavigationUrl = null;
                pendingTabTarget = null;
            });

            document.getElementById('confirmLeaveBtn')?.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                const url = pendingNavigationUrl;
                const tab = pendingTabTarget;
                pendingNavigationUrl = null;
                pendingTabTarget = null;
                isDirty = false;
                if (typeof onConfirm === 'function') onConfirm({ url, tab });
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    pendingNavigationUrl = null;
                    pendingTabTarget = null;
                }
            }, { once: true });
        }

        function performTabSwitch(targetTab) {
            tabButtons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-green-700', 'border-transparent', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');
                btn.classList.add('border-b-2', 'border-transparent', 'text-slate-500', 'dark:text-slate-400');
            });
            const activeBtn = document.querySelector(`[data-tab="${targetTab}"]`);
            activeBtn?.classList.remove('text-slate-500', 'dark:text-slate-400', 'border-transparent');
            activeBtn?.classList.add('border-b-2', 'border-green-700', 'bg-green-50', 'dark:bg-green-900/20', 'text-slate-700', 'dark:text-slate-300');

            tabContents.forEach(content => content.classList.add('hidden'));
            document.getElementById('tab-' + targetTab)?.classList.remove('hidden');
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                const targetTab = this.getAttribute('data-tab');
                const currentTab = document.querySelector('.tab-content:not(.hidden)');
                const currentTabId = currentTab ? currentTab.id.replace('tab-', '') : '';

                if (!targetTab || targetTab === currentTabId) return;

                if (isDirty) {
                    pendingTabTarget = targetTab;
                    showUnsavedModal(({ tab }) => {
                        if (tab) performTabSwitch(tab);
                    });
                    return;
                }

                performTabSwitch(targetTab);
            }, true);
        });

        document.addEventListener('click', function(e) {
            const link = e.target.closest('aside#admin-sidebar a[href]');
            if (!link) return;
            const url = link.getAttribute('href');
            if (!url || url.startsWith('#')) return;
            if (!isDirty) return;

            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            pendingNavigationUrl = url;
            showUnsavedModal(({ url: confirmedUrl }) => {
                if (confirmedUrl) window.location.href = confirmedUrl;
            });
        }, true);
    });
</script>
@endsection

