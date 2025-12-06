@extends('layouts.admin')

@section('title', 'Profil Sekolah')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Profil Sekolah</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola informasi umum sekolah yang ditampilkan di website</p>
            </div>
            <a href="{{ route('admin.info-sekolah.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Info Baru
            </a>
        </div>

        @if($infos->count() > 0)
            <div class="space-y-3">
                @foreach($infos as $info)
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-green-500 hover:shadow-lg transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded">{{ $info->type }}</span>
                                    <h3 class="font-bold text-slate-900 text-lg">{{ $info->label }}</h3>
                                </div>
                                <p class="text-sm text-slate-600 mb-2">
                                    <span class="font-semibold">Key:</span> {{ $info->key }}
                                </p>
                                <p class="text-base text-slate-700 mb-2">
                                    <span class="font-semibold">Value:</span> {{ Str::limit($info->value, 100) }}
                                </p>
                                <div class="text-xs text-slate-500">
                                    Urutan: {{ $info->urutan }}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.info-sekolah.edit', $info) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                    Edit
                                </a>
                                <form action="{{ route('admin.info-sekolah.destroy', $info) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus info ini?');">
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
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Info Sekolah</h3>
                <p class="text-sm text-slate-500 mb-6">Mulai dengan menambahkan info pertama</p>
                <a href="{{ route('admin.info-sekolah.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Info Pertama
                </a>
            </div>
        @endif
    </div>
@endsection

