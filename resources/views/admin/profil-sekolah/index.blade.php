@extends('layouts.admin')

@section('title', 'Profil Sekolah')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Profil Sekolah</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola semua informasi profil sekolah</p>
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
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border-b-2 border-green-700 bg-green-50 dark:bg-green-900/20" data-tab="tentang">
                    Tentang Sekolah
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="visi-misi">
                    Visi & Misi
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="tujuan">
                    Tujuan
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="kepala-madrasah">
                    Kepala Madrasah
                </button>
                <button type="button" class="tab-button rounded-none px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 border-b-2 border-transparent hover:text-slate-700 dark:hover:text-slate-300" data-tab="struktur">
                    Struktur Organisasi
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <form action="{{ route('admin.profil-sekolah.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <!-- Tab: Tentang Sekolah -->
            <div id="tab-tentang" class="tab-content">
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Tentang Sekolah</h2>

                    @if($infos->count() > 0)
                        <div class="space-y-4">
                            @foreach($infos as $index => $info)
                                <div class="border-2 border-gray-200 dark:border-slate-600 rounded-lg p-4 space-y-4">
                                    <input type="hidden" name="info_sekolah[{{ $index }}][id]" value="{{ $info->id }}">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Key</label>
                                        <input type="text" name="info_sekolah[{{ $index }}][key]" value="{{ $info->key }}" readonly class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2 bg-gray-50 dark:bg-slate-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Label</label>
                                        <input type="text" name="info_sekolah[{{ $index }}][label]" value="{{ old("info_sekolah.$index.label", $info->label) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Value</label>
                                        @if($info->type == 'textarea')
                                            <textarea name="info_sekolah[{{ $index }}][value]" rows="4" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">{{ old("info_sekolah.$index.value", $info->value) }}</textarea>
                                        @elseif($info->type == 'image')
                                            <input type="file" name="info_sekolah[{{ $index }}][image]" accept="image/*" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                            @if($info->value)
                                                <img src="{{ asset('storage/' . $info->value) }}" alt="{{ $info->label }}" class="mt-2 w-48 h-auto">
                                            @endif
                                        @else
                                            <input type="text" name="info_sekolah[{{ $index }}][value]" value="{{ old("info_sekolah.$index.value", $info->value) }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                                        @endif
                                    </div>
                                    <input type="hidden" name="info_sekolah[{{ $index }}][type]" value="{{ $info->type }}">
                                    <input type="hidden" name="info_sekolah[{{ $index }}][urutan]" value="{{ $info->urutan }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 dark:text-slate-400">Belum ada data tentang sekolah</p>
                    @endif
                </div>
            </div>

            <!-- Tab: Visi & Misi -->
            <div id="tab-visi-misi" class="tab-content hidden">
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Visi & Misi</h2>
                    <div>
                        <label for="visi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Visi</label>
                        <textarea name="visi" id="visi-editor" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg">{{ old('visi', $visi->value ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="misi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Misi</label>
                        <textarea name="misi" id="misi-editor" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg">{{ old('misi', $misi->value ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tab: Tujuan -->
            <div id="tab-tujuan" class="tab-content hidden">
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Tujuan</h2>
                    <div>
                        <label for="tujuan" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tujuan</label>
                        <textarea name="tujuan" id="tujuan-editor" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg">{{ old('tujuan', $tujuan->value ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tab: Kepala Madrasah -->
            <div id="tab-kepala-madrasah" class="tab-content hidden">
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Kepala Madrasah</h2>
                    <div>
                        <label for="kepala_madrasah_nama" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama</label>
                        <input type="text" name="kepala_madrasah_nama" id="kepala_madrasah_nama" value="{{ old('kepala_madrasah_nama', $kepalaMadrasahNama->value ?? '') }}" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label for="kepala_madrasah_sambutan" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Sambutan</label>
                        <textarea name="kepala_madrasah_sambutan" id="sambutan-editor" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg">{{ old('kepala_madrasah_sambutan', $kepalaMadrasahSambutan->value ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="kepala_madrasah_foto" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Foto</label>
                        <input type="file" name="kepala_madrasah_foto" id="kepala_madrasah_foto" accept="image/*" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                        @if($kepalaMadrasahFoto->value)
                            <img src="{{ asset('storage/' . $kepalaMadrasahFoto->value) }}" alt="Foto Kepala Madrasah" class="mt-2 w-48 h-64 object-cover border border-gray-200 dark:border-slate-600 rounded-lg">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab: Struktur Organisasi -->
            <div id="tab-struktur" class="tab-content hidden">
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Struktur Organisasi</h2>
                    <div>
                        <label for="struktur_organisasi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Gambar Struktur Organisasi</label>
                        <input type="file" name="struktur_organisasi" id="struktur_organisasi" accept="image/*" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-2">
                        @if($strukturOrganisasi->value)
                            <img src="{{ asset('storage/' . $strukturOrganisasi->value) }}" alt="Struktur Organisasi" class="mt-2 w-full max-w-2xl h-auto border border-gray-200 dark:border-slate-600 rounded-lg">
                        @endif
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

        // Initialize Summernote editors
        if (typeof $ !== 'undefined' && $.fn.summernote) {
            $('#visi-editor').summernote({ height: 200, toolbar: [['style', ['style']], ['font', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['fullscreen', 'codeview']]], styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'], codeviewFilter: false, codeviewIframeFilter: true });
            $('#misi-editor').summernote({ height: 300, toolbar: [['style', ['style']], ['font', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['fullscreen', 'codeview']]], styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'], codeviewFilter: false, codeviewIframeFilter: true });
            $('#tujuan-editor').summernote({ height: 300, toolbar: [['style', ['style']], ['font', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['fullscreen', 'codeview']]], styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'], codeviewFilter: false, codeviewIframeFilter: true });
            $('#sambutan-editor').summernote({ height: 300, toolbar: [['style', ['style']], ['font', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['fullscreen', 'codeview']]], styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'], codeviewFilter: false, codeviewIframeFilter: true });

            $('#visi-editor').on('summernote.change', function() { isDirty = true; });
            $('#misi-editor').on('summernote.change', function() { isDirty = true; });
            $('#tujuan-editor').on('summernote.change', function() { isDirty = true; });
            $('#sambutan-editor').on('summernote.change', function() { isDirty = true; });
        }
    });
</script>
@endsection

