@extends('layouts.app')

@section('title', 'Pengumuman | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Pengumuman']
        ]" />
        <x-page-title title="Pengumuman" />
        
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 mt-8">
            <!-- Kiri: Pengumuman (2/3) -->
            <div class="w-full lg:w-2/3">
                @if($pengumuman->count() > 0)
                    <div class="space-y-6">
                        @foreach($pengumuman as $item)
                        <article class="bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col md:flex-row">
                                <!-- Foto (Kiri) -->
                                <div class="w-full md:w-1/3 flex-shrink-0">
                                    <img
                                        src="{{ asset('img/default-backgrounds.png') }}@if(file_exists(public_path('img/default-backgrounds.png')))?v={{ filemtime(public_path('img/default-backgrounds.png')) }}@endif"
                                        alt="{{ $item->judul }}"
                                        class="w-full h-48 md:h-full object-cover"
                                    >
                                </div>
                                <!-- Konten (Kanan) -->
                                <div class="w-full md:w-2/3 p-5 sm:p-6">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 hover:text-green-700 transition-colors">
                                        {{ $item->judul }}
                                    </h3>
                                    <div class="text-sm text-gray-700 leading-relaxed mb-3 prose prose-sm max-w-none">
                                        {!! $item->isi !!}
                                    </div>
                                    <div class="flex items-center justify-start">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs text-gray-500">
                                                @if($item->tanggal)
                                                    @php
                                                        $dateObj = $item->tanggal;
                                                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                        $monthName = $months[$dateObj->month - 1];
                                                        $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                                                    @endphp
                                                    {{ $date }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $pengumuman->links() }}
                    </div>
                @else
                    <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                        <p class="text-gray-500">Belum ada pengumuman</p>
                    </div>
                @endif
            </div>

            <!-- Garis Pembatas -->
            <div class="hidden lg:block border-l border-gray-300"></div>

            <!-- Kanan: Sidebar (1/3) -->
            <div class="w-full lg:w-1/3">
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

                <!-- Berita Terbaru -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Berita Terbaru
                        </h3>
                        <div class="space-y-4 min-h-[300px]">
                            @if(count($berita) > 0)
                                @foreach($berita as $item)
                                <article class="pb-4 last:pb-0">
                                    <a href="#" class="block hover:text-green-700 transition-colors">
                                        <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-green-700">
                                            {{ $item['judul'] }}
                                        </h4>
                                        <p class="text-xs text-gray-600 line-clamp-2 mb-2">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            @if(isset($item['tanggal']))
                                                @php
                                                    $dateObj = \Carbon\Carbon::parse($item['tanggal']);
                                                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                    $monthName = $months[$dateObj->month - 1];
                                                    $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                                                    $hour = str_pad($dateObj->format('h'), 2, '0', STR_PAD_LEFT);
                                                    $minute = $dateObj->format('i');
                                                    $ampm = strtolower($dateObj->format('A'));
                                                    $time = $hour . ':' . $minute . ' ' . $ampm;
                                                @endphp
                                                {{ $date }} | {{ $time }}
                                            @endif
                                        </p>
                                    </a>
                                </article>
                                @endforeach
                            @else
                                <div class="flex items-center justify-center" style="min-height: 300px;">
                                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-300 text-center">
                                        Belum Ada Berita
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pengumuman
                        </h3>
                        <div class="space-y-3 min-h-[300px]">
                            @if(count($infoTerkini) > 0)
                                @foreach($infoTerkini as $item)
                                <div class="pb-3 last:pb-0">
                                    <a href="#" class="block hover:text-green-700 transition-colors">
                                        <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700">
                                            {{ $item['judul'] }}
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            {{ date('d M Y', strtotime($item['tanggal'])) }}
                                        </p>
                                    </a>
                                </div>
                                @endforeach
                            @else
                                <div class="flex items-center justify-center" style="min-height: 300px;">
                                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-300 text-center">
                                        Belum Ada Pengumuman
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Agenda -->
                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Agenda
                        </h3>
                        <div class="space-y-3">
                            @php
                                $agendaSidebar = [
                                    ['judul' => 'Rapat Koordinasi Guru dan Staf', 'tanggal' => '2025-01-20'],
                                    ['judul' => 'Kegiatan Outing Class Siswa Kelas 7', 'tanggal' => '2025-01-25'],
                                    ['judul' => 'Lomba Tahfidz Al-Qur\'an Tingkat Sekolah', 'tanggal' => '2025-02-01'],
                                ];
                            @endphp
                            @foreach($agendaSidebar as $item)
                            <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
                                <a href="{{ route('informasi.agenda') }}" class="block hover:text-green-700 transition-colors">
                                    <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700">
                                        {{ $item['judul'] }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        @php
                                            $dateObj = \Carbon\Carbon::parse($item['tanggal']);
                                            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            $monthName = $months[$dateObj->month - 1];
                                            echo $dateObj->day . ' ' . $monthName . ' ' . $dateObj->year;
                                        @endphp
                                    </p>
                                </a>
                            </div>
                            @endforeach
                            <div class="text-center mt-4">
                                <a href="{{ route('informasi.agenda') }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                    Lihat Semua Agenda
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
