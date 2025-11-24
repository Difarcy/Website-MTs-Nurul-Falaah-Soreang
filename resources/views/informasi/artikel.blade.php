@extends('layouts.app')

@section('title', 'Artikel - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <x-page-title title="Artikel" />
        
        @php
            $artikel = [
                [
                    'judul' => 'Pentingnya Pendidikan Karakter dalam Pembelajaran di MTs',
                    'deskripsi' => 'Pendidikan karakter merupakan aspek penting dalam proses pembelajaran di MTs. Artikel ini membahas bagaimana pendidikan karakter dapat diintegrasikan dalam kegiatan pembelajaran sehari-hari.',
                    'tanggal' => '2025-01-14 11:20:00',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Strategi Meningkatkan Minat Baca Siswa di Era Digital',
                    'deskripsi' => 'Di era digital seperti sekarang, minat baca siswa cenderung menurun. Artikel ini membahas berbagai strategi yang dapat diterapkan untuk meningkatkan minat baca siswa.',
                    'tanggal' => '2025-01-11 09:15:00',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'judul' => 'Peran Orang Tua dalam Mendukung Prestasi Akademik Anak',
                    'deskripsi' => 'Dukungan orang tua sangat penting dalam mencapai prestasi akademik anak. Artikel ini membahas bagaimana orang tua dapat mendukung proses belajar anak di rumah.',
                    'tanggal' => '2025-01-09 15:30:00',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Manfaat Ekstrakurikuler untuk Pengembangan Diri Siswa',
                    'deskripsi' => 'Kegiatan ekstrakurikuler memiliki banyak manfaat untuk pengembangan diri siswa. Artikel ini menjelaskan berbagai manfaat yang dapat diperoleh dari kegiatan ekstrakurikuler.',
                    'tanggal' => '2025-01-07 10:45:00',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'judul' => 'Teknologi dalam Pembelajaran: Peluang dan Tantangan',
                    'deskripsi' => 'Penggunaan teknologi dalam pembelajaran memberikan peluang dan tantangan tersendiri. Artikel ini membahas bagaimana memanfaatkan teknologi secara efektif dalam pembelajaran.',
                    'tanggal' => '2025-01-05 13:00:00',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Membangun Budaya Literasi di Sekolah',
                    'deskripsi' => 'Budaya literasi perlu dibangun sejak dini di sekolah. Artikel ini membahas langkah-langkah yang dapat dilakukan untuk membangun budaya literasi di lingkungan sekolah.',
                    'tanggal' => '2025-01-03 08:30:00',
                'gambar' => 'sample2.jpg'
                ]
            ];
            
            // Data untuk testing
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
            
            $infoTerkini = [
                ['judul' => 'Pengumuman Libur Semester Genap', 'tanggal' => '2025-01-20'],
                ['judul' => 'Jadwal Ujian Tengah Semester', 'tanggal' => '2025-01-18'],
                ['judul' => 'Pendaftaran Ekstrakurikuler Baru', 'tanggal' => '2025-01-16'],
            ];
        @endphp

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 mt-8">
            <!-- Kiri: Artikel (2/3) -->
            <div class="w-full lg:w-2/3">
                <div class="space-y-6">
                    @foreach($artikel as $item)
                    <article class="bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="flex flex-col md:flex-row">
                            <!-- Foto (Kiri) -->
                            <div class="w-full md:w-1/3 flex-shrink-0">
                                <img
                                    src="{{ asset('img/' . $item['gambar']) }}?v={{ filemtime(public_path('img/' . $item['gambar'])) }}"
                                    alt="{{ $item['judul'] }}"
                                    class="w-full h-48 md:h-full object-cover"
                                >
                            </div>
                            <!-- Konten (Kanan) -->
                            <div class="w-full md:w-2/3 p-5 sm:p-6">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                                    {{ $item['judul'] }}
                                </h3>
                                <p class="text-sm text-gray-700 leading-relaxed mb-3 line-clamp-4">
                                    {{ $item['deskripsi'] }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-gray-500">
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
                                    </p>
                                    <a href="#" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                        Baca Artikel
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>

            <!-- Garis Pembatas -->
            <div class="hidden lg:block border-l border-gray-300"></div>

            <!-- Kanan: Sidebar (1/3) -->
            <div class="w-full lg:w-1/3">
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
                </div>

                <!-- Info Terkini -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Info Terkini
                        </h3>
                        <div class="space-y-3 min-h-[300px]">
                            @if(count($infoTerkini) > 0)
                                @foreach($infoTerkini as $item)
                                <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
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
                                        Belum Ada Info Terkini
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Media Sosial
                        </h3>
                        <div class="flex items-center justify-start gap-4">
                            <!-- Facebook -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-blue-600 hover:text-blue-700 transition-colors duration-300 transform hover:scale-110" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <!-- X (Twitter) -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-gray-900 hover:text-gray-700 transition-colors duration-300 transform hover:scale-110" aria-label="X (Twitter)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <!-- Instagram -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-pink-600 hover:text-pink-700 transition-colors duration-300 transform hover:scale-110" aria-label="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <!-- YouTube -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-red-600 hover:text-red-700 transition-colors duration-300 transform hover:scale-110" aria-label="YouTube">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <!-- TikTok -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-black hover:text-gray-800 transition-colors duration-300 transform hover:scale-110" aria-label="TikTok">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Akses Cepat -->
                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Akses Cepat
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('informasi.berita') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Berita</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('informasi.pengumuman') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Pengumuman</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('informasi.agenda') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Agenda</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('galeri.foto-kegiatan') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Foto Kegiatan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
