@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.foto-kegiatan.index') }}" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Galeri</h1>
                <p class="text-sm text-slate-500 mt-1">Upload foto kegiatan sekolah yang akan ditampilkan di website</p>
            </div>
        </div>

        <form action="{{ route('admin.foto-kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl p-6 space-y-6">
            @csrf

            <!-- Langkah 1: Upload Gambar -->
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-green-500 transition">
                <div class="max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <label for="gambar" class="cursor-pointer">
                        <span class="block text-lg font-semibold text-slate-700 mb-2">Klik untuk Upload Gambar</span>
                        <span class="block text-sm text-slate-500 mb-4">Format: JPG atau PNG (Maksimal 5MB)</span>
                        <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <span class="inline-block px-6 py-3 bg-green-700 text-white font-semibold rounded-lg hover:bg-green-800 transition">
                            Pilih File
                        </span>
                    </label>
                    <div id="preview-container" class="mt-4 hidden">
                        <img id="preview-image" src="" alt="Preview" class="max-w-full max-h-64 mx-auto rounded-lg border border-gray-200">
                    </div>
                    @error('gambar') 
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            <!-- Langkah 2: Informasi Foto -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <span class="bg-green-100 text-green-700 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">2</span>
                    Informasi Foto (Opsional)
                </h3>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Foto
                        <span class="text-xs font-normal text-slate-400">(bisa dikosongkan)</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul foto kegiatan" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi
                        <span class="text-xs font-normal text-slate-400">(bisa dikosongkan)</span>
                    </label>
                    <textarea name="deskripsi" rows="3" placeholder="Masukkan deskripsi foto kegiatan" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Pengaturan Lanjutan (Collapsible) -->
            <details class="border border-gray-200 dark:border-slate-700 rounded-lg">
                <summary class="px-4 py-3 cursor-pointer text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                    Pengaturan Lanjutan (Opsional)
                </summary>
                <div class="px-4 pb-4 pt-2 space-y-4 border-t border-gray-200">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan Tampil</label>
                        <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0" class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                        <p class="text-xs text-slate-500 mt-1">Angka lebih kecil akan tampil lebih dulu</p>
                        @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600">
                            <span class="text-sm font-semibold text-slate-700">Tampilkan di Website</span>
                        </label>
                        <p class="text-xs text-slate-500 mt-1 ml-8">Jika tidak dicentang, foto tidak akan ditampilkan di website</p>
                    </div>
                </div>
            </details>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.foto-kegiatan.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                    Simpan Foto
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
