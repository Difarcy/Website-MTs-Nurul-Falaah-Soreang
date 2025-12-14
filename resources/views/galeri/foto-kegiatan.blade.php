@extends('layouts.app')

@section('title', 'Foto Kegiatan | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Galeri', 'url' => route('galeri')],
            ['label' => 'Foto Kegiatan']
        ]" />
        <x-page-title title="Foto Kegiatan" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 mt-8 min-h-[400px]">
            @if(isset($fotos) && $fotos->count() > 0)
                @foreach($fotos as $index => $item)
            <div class="group bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-full aspect-video overflow-hidden">
                    <img
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/default-backgrounds.png') }}"
                        alt="{{ $item->judul ?? 'Foto Kegiatan ' . ($index + 1) }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    >
                </div>
                <div class="p-4 sm:p-5">
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900 mb-2 group-hover:text-green-700 transition-colors">
                        {{ $item->judul ?? 'Foto Kegiatan ' . ($index + 1) }}
                    </h3>
                    @if($item->deskripsi)
                        <p class="text-[10px] sm:text-xs text-gray-600 leading-relaxed">
                            {{ $item->deskripsi }}
                        </p>
                    @endif
                </div>
            </div>
                @endforeach
            @else
                <div class="col-span-full flex items-center justify-center" style="min-height: 400px;">
                    <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                        Belum Ada Foto Kegiatan
                    </p>
                </div>
            @endif
        </div>
    </div>

@endsection
