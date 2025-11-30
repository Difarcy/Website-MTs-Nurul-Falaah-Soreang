@extends('layouts.admin')

@section('title', 'Agenda')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Agenda</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola agenda kegiatan sekolah yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.agenda.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Agenda Baru
            </a>
        </div>

        @if($agenda->count() > 0)
            <div class="space-y-3">
                @foreach($agenda as $item)
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-green-500 hover:shadow-lg transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $item->judul }}</h3>
                                @if($item->deskripsi)
                                    <p class="text-sm text-slate-600 line-clamp-2 mb-3">{{ $item->deskripsi }}</p>
                                @endif
                                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                    <span>{{ $item->tanggal_mulai->format('d M Y') }}</span>
                                    @if($item->tanggal_selesai && $item->tanggal_selesai != $item->tanggal_mulai)
                                        <span>s/d {{ $item->tanggal_selesai->format('d M Y') }}</span>
                                    @endif
                                    @if($item->waktu_mulai)
                                        <span>⏰ {{ $item->waktu_mulai }}</span>
                                    @endif
                                    @if($item->lokasi)
                                        <span>📍 {{ $item->lokasi }}</span>
                                    @endif
                                    <span>Urutan: {{ $item->urutan }}</span>
                                    @if(!$item->is_active)
                                        <span class="text-red-600 font-semibold">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.agenda.edit', $item) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                    Edit
                                </a>
                                <form action="{{ route('admin.agenda.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus agenda ini?');">
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
                {{ $agenda->links() }}
            </div>
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Agenda</h3>
                <p class="text-sm text-slate-500 mb-6">Mulai dengan menambahkan agenda pertama</p>
                <a href="{{ route('admin.agenda.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Agenda Pertama
                </a>
            </div>
        @endif
    </div>
@endsection

