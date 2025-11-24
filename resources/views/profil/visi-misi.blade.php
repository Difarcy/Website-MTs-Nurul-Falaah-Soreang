@extends('layouts.app')

@section('title', 'Visi & Misi | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <!-- Header Section -->
        <div class="mb-8">
            <x-page-title title="Visi, Misi, dan Tujuan" />
        </div>

        @php
            $berita = [
                [
                    'judul' => 'Siswa MTs Nurul Falaah Soreang Raih Juara 1 Olimpiade Matematika',
                    'deskripsi' => 'Prestasi membanggakan diraih oleh siswa MTs Nurul Falaah Soreang dalam Olimpiade Matematika tingkat Kabupaten Bandung.',
                    'tanggal' => '2025-01-15 10:30:00'
                ],
                [
                    'judul' => 'Kegiatan Outbound Siswa Kelas 9',
                    'deskripsi' => 'Siswa kelas 9 mengikuti kegiatan outbound sebagai bagian dari persiapan mental dan fisik menghadapi ujian nasional.',
                    'tanggal' => '2025-01-12 14:20:00'
                ],
            ];
            
            $artikel = [
                [
                    'judul' => 'Tips Sukses Belajar di Era Digital',
                    'deskripsi' => 'Panduan lengkap untuk siswa dalam memanfaatkan teknologi digital untuk mendukung proses pembelajaran.',
                    'tanggal' => '2025-01-14 11:45:00'
                ],
                [
                    'judul' => 'Pentingnya Pendidikan Karakter',
                    'deskripsi' => 'Artikel ini membahas tentang pentingnya pendidikan karakter yang terintegrasi dalam proses pembelajaran.',
                    'tanggal' => '2025-01-11 08:30:00'
                ],
            ]; // Kosong untuk placeholder
            // $artikel = [
            //     [
            //         'judul' => 'Judul Artikel 1',
            //         'deskripsi' => 'Deskripsi artikel...',
            //         'tanggal' => '2025-01-15'
            //     ],
            // ];
        @endphp

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Kiri: Visi, Misi, dan Tujuan (70%) -->
            <div class="w-full lg:w-[70%]">
                <div class="space-y-6 sm:space-y-8">
                    <!-- Visi -->
                    <div class="bg-white border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-base sm:text-lg font-bold text-green-700 mb-4 text-center uppercase">
                                - VISI -
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-700 leading-relaxed text-justify">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                            </p>
                        </div>
                    </div>
                    <!-- Misi -->
                    <div class="bg-white border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-base sm:text-lg font-bold text-green-700 mb-4 text-center uppercase">
                                - MISI -
                            </h3>
                            <ul class="text-xs sm:text-sm text-gray-700 leading-relaxed list-disc list-inside space-y-2">
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                <li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                                <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</li>
                                <li>Duis aute irure dolor in reprehenderit in voluptate velit esse.</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Tujuan -->
                    <div class="bg-white border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-base sm:text-lg font-bold text-green-700 mb-4 text-center uppercase">
                                - TUJUAN -
                            </h3>
                            <ul class="text-xs sm:text-sm text-gray-700 leading-relaxed list-disc list-inside space-y-2">
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                <li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                                <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</li>
                                <li>Duis aute irure dolor in reprehenderit in voluptate velit esse.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Garis Pembatas -->
            <div class="hidden lg:block border-l border-gray-300"></div>

            <!-- Kanan: Sidebar (30%) -->
            <div class="w-full lg:w-[30%]">
                <!-- Berita Terbaru -->
                <div class="mb-6">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Berita Terbaru
                    </h3>
                    <div class="space-y-4 min-h-[300px]">
                        @if(count($berita) > 0)
                            @foreach($berita as $item)
                            <article class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
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

                <!-- Artikel Terbaru -->
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Artikel Terbaru
                    </h3>
                    <div class="space-y-4 min-h-[300px]">
                        @if(count($artikel) > 0)
                            @foreach($artikel as $item)
                            <article class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
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
                                    Belum Ada Artikel
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
