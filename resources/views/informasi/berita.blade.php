@extends('layouts.app')

@section('title', 'Berita - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <x-page-title title="Berita" />
        
        @php
            $berita = [
                [
                    'judul' => 'Siswa MTs Nurul Falaah Soreang Raih Juara 1 Olimpiade Matematika Tingkat Kabupaten',
                    'deskripsi' => 'Prestasi membanggakan diraih oleh siswa MTs Nurul Falaah Soreang dalam Olimpiade Matematika tingkat Kabupaten Bandung. Atas prestasi ini, siswa akan mewakili kabupaten di tingkat provinsi.',
                    'tanggal' => '2025-01-15 10:30:00',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Kegiatan Outing Class Kelas 7 Berhasil Dilaksanakan',
                    'deskripsi' => 'Kegiatan pembelajaran di luar kelas untuk siswa kelas 7 telah berhasil dilaksanakan di Taman Wisata Alam. Kegiatan ini bertujuan untuk meningkatkan pengalaman belajar siswa.',
                    'tanggal' => '2025-01-12 08:15:00',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'judul' => 'Workshop Peningkatan Kompetensi Guru di MTs Nurul Falaah',
                    'deskripsi' => 'Workshop peningkatan kompetensi guru dalam penggunaan teknologi pembelajaran telah dilaksanakan dengan sukses. Kegiatan ini diikuti oleh seluruh guru MTs Nurul Falaah Soreang.',
                    'tanggal' => '2025-01-10 14:20:00',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Lomba Tahfidz Al-Qur\'an Tingkat Sekolah Sukses Digelar',
                    'deskripsi' => 'Kompetisi tahfidz Al-Qur\'an antar kelas telah berhasil dilaksanakan. Kegiatan ini bertujuan untuk memotivasi siswa dalam menghafal Al-Qur\'an dan meningkatkan kualitas hafalan.',
                    'tanggal' => '2025-01-08 09:45:00',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'judul' => 'Kegiatan Bakti Sosial Siswa di Lingkungan Sekitar Sekolah',
                    'deskripsi' => 'Siswa MTs Nurul Falaah Soreang melaksanakan kegiatan bakti sosial di lingkungan sekitar sekolah. Kegiatan ini bertujuan untuk menumbuhkan kepedulian sosial siswa.',
                    'tanggal' => '2025-01-05 07:30:00',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Pertemuan Orang Tua dan Wali Murid Semester Genap',
                    'deskripsi' => 'Pertemuan rutin orang tua dan wali murid untuk membahas perkembangan siswa dan program sekolah telah dilaksanakan dengan baik.',
                    'tanggal' => '2025-01-03 13:00:00',
                'gambar' => 'sample2.jpg'
                ]
            ];
            
            // Data untuk testing
            $artikel = [
                [
                    'judul' => 'Tips Sukses Belajar di Era Digital untuk Siswa MTs',
                    'deskripsi' => 'Panduan lengkap untuk siswa dalam memanfaatkan teknologi digital untuk mendukung proses pembelajaran yang lebih efektif dan efisien di era modern ini.',
                    'tanggal' => '2025-01-14 11:45:00'
                ],
                [
                    'judul' => 'Pentingnya Pendidikan Karakter dalam Pembelajaran',
                    'deskripsi' => 'Artikel ini membahas tentang pentingnya pendidikan karakter yang terintegrasi dalam proses pembelajaran untuk membentuk siswa yang berakhlak mulia dan berkarakter kuat.',
                    'tanggal' => '2025-01-11 08:30:00'
                ],
            ];
            
            $infoTerkini = [
                ['judul' => 'Pengumuman Libur Semester Genap', 'tanggal' => '2025-01-20'],
                ['judul' => 'Jadwal Ujian Tengah Semester', 'tanggal' => '2025-01-18'],
                ['judul' => 'Pendaftaran Ekstrakurikuler Baru', 'tanggal' => '2025-01-16'],
            ];
        @endphp

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 mt-8">
            <!-- Kiri: Berita (2/3) -->
            <div class="w-full lg:w-2/3">
                <div class="space-y-6">
                    @foreach($berita as $item)
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
                                <p class="text-sm text-gray-700 leading-relaxed mb-3 line-clamp-3">
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
                                        Selengkapnya
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
                <!-- Artikel Terbaru -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
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
