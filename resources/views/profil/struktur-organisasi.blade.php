@extends('layouts.app')

@section('title', 'Struktur Organisasi | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Profil', 'url' => route('profil')],
            ['label' => 'Struktur Organisasi']
        ]" />
        <x-page-title title="Struktur Organisasi" />

        @php
            $strukturOrganisasi = 'img/sample-kosong.png';
            // $strukturOrganisasi = null; // Kosong untuk placeholder
        @endphp

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 mt-8">
            <!-- Kiri: Struktur Organisasi (70%) -->
            <div class="w-full lg:w-[70%]">
                @if($strukturOrganisasi)
                    <div class="bg-white border border-gray-200 overflow-hidden">
                        <img
                            src="{{ asset($strukturOrganisasi) }}"
                            alt="Struktur Organisasi MTs Nurul Falaah Soreang"
                            class="w-full h-auto object-contain"
                            style="min-height: 570px;"
                        >
                    </div>
                @else
                    <div class="flex items-center justify-center bg-white border border-gray-200" style="min-height: 570px;">
                        <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                            Belum Ada Struktur Organisasi
                        </p>
                    </div>
                @endif
            </div>

            <!-- Garis Pembatas -->
            <div class="hidden lg:block border-l border-gray-300"></div>

            <!-- Kanan: Sidebar (30%) -->
            <div class="w-full lg:w-[30%]">
                <!-- Sambutan Kepala Madrasah -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        @php
                            $kepalaMadrasahPath = 'img/kepala-madrasah.jpg';
                            $kepalaMadrasahExists = file_exists(public_path($kepalaMadrasahPath));
                            $kepalaMadrasahImage = $kepalaMadrasahExists 
                                ? asset($kepalaMadrasahPath) . '?v=' . filemtime(public_path($kepalaMadrasahPath))
                                : asset('img/default-backgrounds.png');
                        @endphp
                        <div class="mb-3">
                            <img
                                src="{{ $kepalaMadrasahImage }}"
                                alt="Kepala Madrasah MTs Nurul Falaah Soreang"
                                class="w-full aspect-[3/4] object-cover mx-auto"
                                style="max-height: 28rem;"
                            >
                        </div>
                        <div class="mb-3 text-center">
                            <p class="text-base text-gray-700 font-semibold">
                                Waskam, S.Pd. M.Pd.
                            </p>
                            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                                - Kepala Madrasah -
                            </p>
                        </div>
                        <div class="mb-0">
                            <p class="text-sm text-gray-700 leading-relaxed text-justify line-clamp-5">
                                Puji syukur kita panjatkan kehadirat Allah SWT atas limpahan rahmat-Nya. Selamat datang di website resmi MTs Nurul Falaah Soreang. Melalui media ini, kami berharap masyarakat dapat mengenal lebih dekat komitmen madrasah dalam mencetak generasi berilmu, berakhlak, dan berprestasi. Sebagai lembaga pendidikan tingkat menengah pertama berbasis Islam, kami senantiasa mengintegrasikan nilai-nilai keislaman dalam setiap proses pembelajaran...
                            </p>
                        </div>
                        <div class="text-center mt-1">
                            <a href="{{ route('profil.kepala-sekolah-guru') }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

