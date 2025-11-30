@extends('layouts.admin')

@section('title', 'Prestasi Siswa')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Prestasi Siswa</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola prestasi dan pencapaian siswa yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.prestasi-siswa.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Prestasi Baru
            </a>
        </div>

        @if($prestasi->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($prestasi as $item)
                    <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden hover:border-green-500 hover:shadow-lg transition">
                        <div class="aspect-video bg-gray-100 relative">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/default-backgrounds.png') }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                            @if(!$item->is_active)
                                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded font-semibold">Tidak Aktif</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-900 text-base mb-2">{{ $item->judul }}</h3>
                            @if($item->kategori)
                                <p class="text-xs text-slate-500 mb-1">Kategori: {{ $item->kategori }}</p>
                            @endif
                            @if($item->tanggal_prestasi)
                                <p class="text-xs text-slate-500 mb-2">Tanggal: {{ $item->tanggal_prestasi->format('d M Y') }}</p>
                            @endif
                            <div class="flex items-center justify-between gap-2 mt-3">
                                <span class="text-xs text-slate-400">Urutan: {{ $item->urutan }}</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.prestasi-siswa.edit', $item) }}" class="px-3 py-1.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.prestasi-siswa.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?');">
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
            <div class="mt-6">
                {{ $prestasi->links() }}
            </div>
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Prestasi Siswa</h3>
                <p class="text-sm text-slate-500 mb-6">Mulai dengan menambahkan prestasi siswa pertama</p>
                <a href="{{ route('admin.prestasi-siswa.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Prestasi Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
