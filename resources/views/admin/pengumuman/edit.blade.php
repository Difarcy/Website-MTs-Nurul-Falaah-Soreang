@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pengumuman.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Pengumuman</h1>
                <p class="text-sm text-slate-500 mt-1">Ubah informasi pengumuman</p>
            </div>
        </div>

        <form action="{{ route('admin.pengumuman.update', $pengumuman) }}" method="POST" id="pengumuman-form" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="judul" class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Pengumuman *
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $pengumuman->judul) }}" maxlength="255" required placeholder="Masukkan judul pengumuman" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="checkFormChanges()">
                    <p class="text-xs text-slate-500 mt-1 text-right">
                        <span id="judul-count">{{ strlen(old('judul', $pengumuman->judul)) }}</span>/255 karakter
                    </p>
                    @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="isi-editor" class="block text-sm font-semibold text-slate-700 mb-2">
                        Isi Pengumuman *
                    </label>
                    <textarea name="isi" id="isi-editor" rows="10" required placeholder="Masukkan isi pengumuman" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('isi', $pengumuman->isi) }}</textarea>
                    @error('isi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Pengumuman *
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pengumuman->tanggal?->format('Y-m-d')) }}" required class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600" onchange="checkFormChanges()">
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
                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $pengumuman->urutan) }}" min="0" placeholder="0" class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600" onchange="checkFormChanges()">
                        <p class="text-xs text-slate-500 mt-1">Angka lebih kecil akan tampil lebih dulu</p>
                        @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="is_active" class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $pengumuman->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600" onchange="checkFormChanges()">
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        let initialData = {
            judul: '{{ addslashes($pengumuman->judul) }}',
            isi: {!! json_encode($pengumuman->isi) !!},
            tanggal: '{{ $pengumuman->tanggal?->format('Y-m-d') }}',
            urutan: {{ $pengumuman->urutan }},
            is_active: {{ $pengumuman->is_active ? 'true' : 'false' }}
        };
        let pengumumanEditorReady = false;

        function getFormData() {
            let isiContent = '';
            const isiInput = document.getElementById('isi-editor');
            if (isiInput) {
                // Check if Summernote is initialized
                if (typeof $ !== 'undefined' && $(isiInput).summernote('code')) {
                    isiContent = $(isiInput).summernote('code');
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

        // Initialize Summernote editor with image upload
        (function initSummernote() {
            const editorEl = document.querySelector('#isi-editor');
            if (!editorEl) return;

            function createEditor() {
                if (typeof $ !== 'undefined' && $.fn.summernote) {
                    $(editorEl).summernote({
                        height: 400,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                            ['history', ['undo', 'redo']]
                        ],
                        popover: {
                            image: [
                                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                                ['remove', ['removeMedia']]
                            ],
                            link: [
                                ['link', ['linkDialogShow', 'unlink']]
                            ],
                            table: [
                                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                            ]
                        },
                        styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                        codeviewFilter: false,
                        codeviewIframeFilter: true,
                        callbacks: {
                            onImageUpload: function(files) {
                                uploadImageToServer(files[0], editorEl);
                            },
                            onChange: function(contents) {
                            checkFormChanges();
                            },
                            onInit: function() {
                                // Fix numbering and bullet lists after init
                                const editor = $(editorEl).summernote('code');
                                if (editor) {
                                    const $editor = $('<div>').html(editor);
                                    $editor.find('ul, ol').each(function() {
                                        if (!$(this).attr('style')) {
                                            $(this).css('padding-left', '2em');
                                        }
                                    });
                                    $(editorEl).summernote('code', $editor.html());
                                }
                            }
                        }
                    });

                    pengumumanEditorReady = true;

                        // Ensure button state is correct after editor loads
                        setTimeout(() => checkFormChanges(), 100);
                } else {
                    console.error('Summernote not loaded');
                }
            }

            function uploadImageToServer(file, editorEl) {
                const formData = new FormData();
                formData.append('upload', file);

                fetch('{{ route("admin.uploads.images") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        $(editorEl).summernote('insertImage', data.url);
                    } else {
                        alert('Gagal mengupload gambar');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Gagal mengupload gambar');
                });
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

            // Initialize form state check
            checkFormChanges();
        });
    </script>
@endsection
