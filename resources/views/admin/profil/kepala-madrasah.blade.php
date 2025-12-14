@extends('layouts.admin')

@section('title', 'Kepala Madrasah')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Kepala Madrasah</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi dan sambutan kepala madrasah yang ditampilkan di website</p>
            </div>
        </div>

        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <form action="{{ route('admin.profil.kepala-madrasah.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Nama Kepala Madrasah <span class="text-red-600 dark:text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $kepalaMadrasah->value ?? '') }}" required maxlength="255" placeholder="Masukkan nama kepala madrasah" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        @error('nama') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sambutan" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Sambutan <span class="text-red-600 dark:text-red-500">*</span>
                        </label>
                        <textarea name="sambutan" id="sambutan-editor" required class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('sambutan', $sambutan->value ?? '') }}</textarea>
                        @error('sambutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="foto" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Foto Kepala Madrasah
                        </label>
                        <input type="file" name="foto" id="foto" accept="image/*" class="w-full border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600" onchange="previewFoto(event)">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Format: JPG, PNG (Maks. 2MB). Disarankan rasio 3:4 (portrait)</p>
                        @error('foto') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        
                        @php
                            $fotoKepala = \App\Models\InfoText::where('key', 'foto_kepala_madrasah')->first();
                        @endphp
                        @if($fotoKepala && $fotoKepala->value)
                            <div class="mt-4">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $fotoKepala->value) }}" alt="Foto Kepala Madrasah" class="w-48 h-64 object-cover border border-gray-200 dark:border-slate-600 rounded-lg">
                            </div>
                        @endif
                        
                        <div id="foto-preview" class="hidden mt-4">
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Preview Foto Baru:</p>
                            <img id="preview-img" src="" alt="Preview Foto" class="w-48 h-64 object-cover border border-gray-200 dark:border-slate-600 rounded-lg">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewFoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('foto-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined' && $.fn.summernote) {
                $('#sambutan-editor').summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['fullscreen', 'codeview']]
                    ],
                    styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                    codeviewFilter: false,
                    codeviewIframeFilter: true
                });
            }
        });
    </script>
@endsection

