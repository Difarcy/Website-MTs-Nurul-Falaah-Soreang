@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pengumuman.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Pengumuman</h1>
                <p class="text-sm text-slate-500 mt-1">Buat pengumuman baru yang akan ditampilkan di website</p>
            </div>
        </div>

        <form action="{{ route('admin.pengumuman.store') }}" method="POST" id="pengumuman-form" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Pengumuman *
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" maxlength="255" required placeholder="Masukkan judul pengumuman" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="checkFormChanges()">
                    <p class="text-xs text-slate-500 mt-1 text-right">
                        <span id="judul-count">0</span>/255 karakter
                    </p>
                    @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Isi Pengumuman *
                    </label>
                    <textarea name="isi" id="isi-editor" rows="10" required placeholder="Masukkan isi pengumuman" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('isi') }}</textarea>
                    @error('isi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Pengumuman *
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600" onchange="checkFormChanges()">
                    @error('tanggal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <details class="border border-gray-200 dark:border-slate-700 rounded-lg">
                <summary class="px-4 py-3 cursor-pointer text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                    Pengaturan Lanjutan (Opsional)
                </summary>
                <div class="px-4 pb-4 pt-2 space-y-4 border-t border-gray-200">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0" class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600" onchange="checkFormChanges()">
                        <p class="text-xs text-slate-500 mt-1">Angka lebih kecil akan tampil lebih dulu</p>
                        @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600" onchange="checkFormChanges()">
                            <span class="text-sm font-semibold text-slate-700">Tampilkan di Website</span>
                        </label>
                    </div>
                </div>
            </details>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.pengumuman.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" id="submit-btn" disabled class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px] disabled:opacity-50 disabled:cursor-not-allowed">
                    Publikasikan Pengumuman
                </button>
            </div>
        </form>
    </div>

    <script>
        let initialData = null;
        let pengumumanEditorReady = false;

        function getFormData() {
            let isiContent = '';
            const isiInput = document.getElementById('isi-editor');
            if (isiInput) {
                // Check if CKEditor is initialized
                if (window.pengumumanEditor && window.pengumumanEditor.getData) {
                    isiContent = window.pengumumanEditor.getData();
                } else {
                    isiContent = isiInput.value;
                }
            }

            return {
                judul: document.getElementById('judul').value.trim(),
                isi: isiContent.trim(),
                tanggal: document.getElementById('tanggal').value,
                urutan: parseInt(document.getElementById('urutan').value) || 0,
                is_active: document.getElementById('is_active').checked
            };
        }

        function hasChanges() {
            if (!initialData) return false;
            const current = getFormData();
            return current.judul !== initialData.judul ||
                   current.isi !== initialData.isi ||
                   current.tanggal !== initialData.tanggal ||
                   current.urutan !== initialData.urutan ||
                   current.is_active !== initialData.is_active;
        }

        function checkFormChanges() {
            const submitBtn = document.getElementById('submit-btn');
            if (!submitBtn) return;

            if (hasChanges()) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        // Initialize form state after page load
        function initializeFormState() {
            initialData = getFormData();
            checkFormChanges();
        }

        // Update character count
        document.addEventListener('DOMContentLoaded', function() {
            const judulInput = document.getElementById('judul');
            if (judulInput) {
                judulInput.addEventListener('input', function() {
                    document.getElementById('judul-count').textContent = this.value.length;
                    checkFormChanges();
                });
            }
        });

        // Initialize CKEditor 5 (Classic) with Simple Upload Adapter
        (function initCKEditor() {
            const editorEl = document.querySelector('#isi-editor');
            if (!editorEl) return;

            function createEditor() {
                if (window.ClassicEditor) {
                    ClassicEditor.create(editorEl, {
                        toolbar: [
                            'heading', '|', 'bold', 'italic', 'link', 'blockquote',
                            'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|',
                            'insertTable', 'imageUpload', 'mediaEmbed', '|', 'undo', 'redo'
                        ],
                        image: {
                            toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
                        },
                        simpleUpload: {
                            uploadUrl: '{{ route("admin.uploads.images") }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    })
                    .then(editor => {
                        window.pengumumanEditor = editor;
                        pengumumanEditorReady = true;
                        editor.model.document.on('change:data', () => {
                            const ta = document.getElementById('isi-editor');
                            if (ta) ta.value = editor.getData();
                            checkFormChanges();
                        });

                        // Dark mode sync
                        const isDarkMode = document.body.classList.contains('dark') ||
                                           document.documentElement.classList.contains('dark') ||
                                           window.matchMedia('(prefers-color-scheme: dark)').matches;
                        if (isDarkMode) {
                            try {
                                if (!document.getElementById('ck-dark-mode-styles')) {
                                    const style = document.createElement('style');
                                    style.id = 'ck-dark-mode-styles';
                                    style.innerHTML = `
                                        .ck-dark-mode .ck-editor__editable_inline, .ck-dark-mode .ck-content {
                                            background: #0f172a !important;
                                            color: #e2e8f0 !important;
                                        }
                                        .ck-dark-mode .ck-toolbar {
                                            background: #0b1220 !important;
                                            border-color: #1f2937 !important;
                                        }
                                        .ck-dark-mode .ck-button__label, .ck-dark-mode .ck-button {
                                            color: #e2e8f0 !important;
                                        }
                                    `;
                                    document.head.appendChild(style);
                                }
                                const wrapper = editor.ui.view.element;
                                wrapper.classList.add('ck-dark-mode');
                                editor.editing.view.change(writer => {
                                    writer.setStyle('background-color', '#0f172a', editor.editing.view.document.getRoot());
                                    writer.setStyle('color', '#e2e8f0', editor.editing.view.document.getRoot());
                                });
                            } catch (e) {
                                console.warn('Failed to apply CKEditor dark mode styles', e);
                            }
                        }

                        // Initialize form state after editor is ready
                        setTimeout(() => {
                            initializeFormState();
                        }, 100);
                    })
                    .catch(err => console.error('CKEditor init error:', err));
                } else {
                    const s = document.createElement('script');
                    s.src = 'https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js';
                    s.referrerPolicy = 'origin';
                    s.onload = createEditor;
                    s.onerror = function() { console.error('Failed to load CKEditor'); };
                    document.head.appendChild(s);
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', createEditor);
            } else {
                setTimeout(createEditor, 50);
            }
        })();

        // Wire input events to checkFormChanges
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput) {
                tanggalInput.addEventListener('change', checkFormChanges);
            }

            const urutanInput = document.getElementById('urutan');
            if (urutanInput) {
                urutanInput.addEventListener('change', checkFormChanges);
            }

            const isActiveInput = document.getElementById('is_active');
            if (isActiveInput) {
                isActiveInput.addEventListener('change', checkFormChanges);
            }

            // Initialize form state if all elements are ready and editor might not be loaded yet
            setTimeout(() => {
                if (!initialData) {
                    initializeFormState();
                }
            }, 500);
        });
    </script>
@endsection
