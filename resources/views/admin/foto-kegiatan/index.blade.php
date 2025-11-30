@extends('layouts.admin')

@section('title', 'Foto Kegiatan')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Foto Kegiatan</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola foto-foto kegiatan sekolah yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.foto-kegiatan.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Foto Baru
            </a>
        </div>

        <!-- Daftar Foto -->
        @if($fotos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($fotos as $foto)
                    <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden hover:border-green-500 hover:shadow-lg transition">
                        <div class="aspect-video bg-gray-100 relative">
                            <img src="{{ $foto->gambar ? asset('storage/' . $foto->gambar) : asset('img/default-backgrounds.png') }}" alt="{{ $foto->judul ?? 'Foto Kegiatan' }}" class="w-full h-full object-cover">
                            @if(!$foto->is_active)
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded font-semibold">Tidak Aktif</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-900 text-base mb-2">{{ $foto->judul ?? 'Tanpa Judul' }}</h3>
                            @if($foto->deskripsi)
                                <p class="text-sm text-slate-600 line-clamp-2 mb-3">{{ $foto->deskripsi }}</p>
                            @endif
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-400">Urutan: {{ $foto->urutan }}</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.foto-kegiatan.edit', $foto) }}" class="px-3 py-1.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.foto-kegiatan.destroy', $foto) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $fotos->links() }}
            </div>
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Foto Kegiatan</h3>
                <p class="text-sm text-slate-500 mb-6">Mulai dengan menambahkan foto kegiatan sekolah pertama</p>
                <a href="{{ route('admin.foto-kegiatan.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Foto Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
