@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pengumuman</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola pengumuman yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.pengumuman.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengumuman Baru
            </a>
        </div>

        @if($pengumuman->count() > 0)
            <div class="space-y-3">
                @foreach($pengumuman as $item)
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-green-500 hover:shadow-lg transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $item->judul }}</h3>
                                <p class="text-sm text-slate-600 line-clamp-2 mb-3">{{ $item->isi }}</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span>{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}</span>
                                    <span>Urutan: {{ $item->urutan }}</span>
                                    @if(!$item->is_active)
                                        <span class="text-red-600 font-semibold">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.pengumuman.edit', $item) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                    Edit
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
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
                {{ $pengumuman->links() }}
            </div>
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Pengumuman</h3>
                <p class="text-sm text-slate-500 mb-6">Mulai dengan menambahkan pengumuman pertama</p>
                <a href="{{ route('admin.pengumuman.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengumuman Pertama
                </a>
            </div>
        @endif
    </div>
@endsection

