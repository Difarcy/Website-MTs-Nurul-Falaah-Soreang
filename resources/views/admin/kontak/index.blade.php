@extends('layouts.admin')

@section('title', 'Kontak')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kontak</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola informasi kontak sekolah yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.kontak.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kontak Baru
            </a>
        </div>

        @if($kontaks->count() > 0)
            <div class="space-y-3">
                @foreach($kontaks as $kontak)
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-green-500 hover:shadow-lg transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($kontak->icon)
                                        <span class="text-2xl">{{ $kontak->icon }}</span>
                                    @endif
                                    <h3 class="font-bold text-slate-900 text-lg">{{ $kontak->label }}</h3>
                                </div>
                                <p class="text-base text-slate-700 mb-2">{{ $kontak->nilai }}</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span>Jenis: {{ $kontak->jenis }}</span>
                                    <span>•</span>
                                    <span>Urutan: {{ $kontak->urutan }}</span>
                                    @if(!$kontak->is_active)
                                        <span class="text-red-600 font-semibold">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.kontak.edit', $kontak) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kontak.destroy', $kontak) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kontak ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $kontaks->links() }}
            </div>
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Kontak</h3>
                <p class="text-sm text-slate-500 mb-6">Mulai dengan menambahkan kontak pertama</p>
                <a href="{{ route('admin.kontak.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kontak Pertama
                </a>
            </div>
        @endif
    </div>
@endsection

