<!-- Berita Terbaru dengan Sidebar -->
<section class="bg-white pt-1 sm:pt-2 pb-8 sm:pb-12 fade-in-section">
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Kiri: Berita Terbaru (70%) -->
            <div class="w-full lg:w-[70%]">
                <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-4 flex items-center gap-3">
                    <span class="w-px h-6 sm:h-8 bg-green-700"></span>
                    Berita Terbaru
                </h2>
                @php
                    // Data untuk testing - 6 berita (2 baris x 3 kolom)
                    $berita = [
                        [
                            'judul' => 'Siswa MTs Nurul Falaah Soreang Raih Juara 1 Olimpiade Matematika Tingkat Kabupaten',
                            'deskripsi' => 'Prestasi membanggakan diraih oleh siswa MTs Nurul Falaah Soreang dalam Olimpiade Matematika tingkat Kabupaten Bandung. Atas prestasi ini, siswa akan mewakili kabupaten di tingkat provinsi.',
                        'gambar' => 'sample1.jpg',
                            'tanggal' => '2025-01-15 10:30:00'
                        ],
                        [
                            'judul' => 'Kegiatan Outbound Siswa Kelas 9 untuk Persiapan Ujian',
                            'deskripsi' => 'Siswa kelas 9 mengikuti kegiatan outbound sebagai bagian dari persiapan mental dan fisik menghadapi ujian nasional. Kegiatan ini bertujuan untuk meningkatkan semangat dan motivasi belajar siswa.',
                        'gambar' => 'sample2.jpg',
                            'tanggal' => '2025-01-12 14:20:00'
                        ],
                        [
                            'judul' => 'Workshop Pembelajaran Digital untuk Guru MTs',
                            'deskripsi' => 'Guru-guru MTs Nurul Falaah Soreang mengikuti workshop pembelajaran digital untuk meningkatkan kualitas mengajar dengan memanfaatkan teknologi terkini dalam proses pembelajaran.',
                        'gambar' => 'sample1.jpg',
                            'tanggal' => '2025-01-10 09:15:00'
                        ],
                        [
                            'judul' => 'Kegiatan Pramuka MTs Nurul Falaah Soreang',
                            'deskripsi' => 'Siswa-siswi MTs Nurul Falaah Soreang aktif mengikuti kegiatan pramuka untuk melatih kemandirian, kedisiplinan, dan kepemimpinan. Kegiatan ini rutin dilaksanakan setiap minggu.',
                        'gambar' => 'sample2.jpg',
                            'tanggal' => '2025-01-08 08:00:00'
                        ],
                        [
                            'judul' => 'Kegiatan Ekstrakurikuler Seni dan Budaya',
                            'deskripsi' => 'Siswa MTs Nurul Falaah Soreang mengembangkan bakat seni dan budaya melalui berbagai ekstrakurikuler seperti tari, musik, dan teater. Kegiatan ini bertujuan untuk mengembangkan kreativitas siswa.',
                        'gambar' => 'sample1.jpg',
                            'tanggal' => '2025-01-05 15:30:00'
                        ],
                        [
                            'judul' => 'Kegiatan Bakti Sosial Siswa MTs',
                            'deskripsi' => 'Siswa-siswi MTs Nurul Falaah Soreang mengadakan kegiatan bakti sosial ke panti asuhan sebagai bentuk kepedulian sosial dan pendidikan karakter.',
                        'gambar' => 'sample2.jpg',
                            'tanggal' => '2025-01-03 11:00:00'
                        ],
                    ];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 lg:gap-6">
                    @if(count($berita) > 0)
                        @foreach(array_slice($berita, 0, 4) as $index => $item)
                        @php $i = $index + 1; @endphp
                    <article class="bg-white border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col">
                        <div class="w-full">
                            <img
                                src="{{ asset('img/sample' . ($i % 2 + 1) . '.jpg') }}?v={{ filemtime(public_path('img/sample' . ($i % 2 + 1) . '.jpg')) }}"
                                alt="Berita Terbaru {{ $i }}"
                                class="w-full h-40 sm:h-48 object-cover"
                            >
                        </div>
                        <div class="w-full p-4 flex flex-col flex-grow">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 line-clamp-2 hover:text-green-700 transition-colors">
                                {{ $item['judul'] }}
                            </h3>
                            <p class="text-xs text-gray-600 line-clamp-3 mb-3 flex-grow">
                                {{ $item['deskripsi'] }}
                            </p>
                            <div class="mt-auto space-y-2">
                                <a href="#" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                    Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <p class="text-xs text-gray-500">
                                    @php
                                        $dateObj = \Carbon\Carbon::now()->subDays(6 - $i)->subHours(6 - $i);
                                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        $monthName = $months[$dateObj->month - 1];
                                        $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                                        $hour = $dateObj->format('h');
                                        $minute = $dateObj->format('i');
                                        $ampm = strtolower($dateObj->format('A'));
                                        $time = $hour . ':' . $minute . ' ' . $ampm;
                                    @endphp
                                    {{ $date }} | {{ $time }}
                                </p>
                            </div>
                        </div>
                    </article>
                        @endforeach
                    @else
                        <div class="col-span-full flex items-center justify-center" style="min-height: 600px;">
                            <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                                Belum Ada Berita
                            </p>
                        </div>
                    @endif
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('informasi.berita') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
                        Lihat Semua Berita
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                
                <!-- Iklan/Banner -->
                <div class="mt-8">
                    <div class="bg-gray-100 border border-gray-300 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <a href="#" class="block">
                            <img
                                src="{{ asset('img/sample1.jpg') }}?v={{ filemtime(public_path('img/sample1.jpg')) }}"
                                alt="Banner Iklan"
                                class="w-full h-20 sm:h-24 md:h-28 object-cover"
                            >
                        </a>
                    </div>
                </div>
                
                <!-- Artikel -->
                <div class="mt-6">
                    <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-px h-6 sm:h-8 bg-green-700"></span>
                        Artikel Terbaru
                    </h2>
                    <div class="space-y-4 min-h-[400px]">
                        @php
                            // Data untuk testing - 4 artikel (layout horizontal)
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
                                [
                                    'judul' => 'Manfaat Ekstrakurikuler untuk Pengembangan Diri Siswa',
                                    'deskripsi' => 'Kegiatan ekstrakurikuler memiliki banyak manfaat untuk pengembangan diri siswa. Artikel ini menjelaskan berbagai manfaat yang dapat diperoleh dari kegiatan ekstrakurikuler.',
                                    'tanggal' => '2025-01-09 10:20:00'
                                ],
                                [
                                    'judul' => 'Membangun Budaya Literasi di Sekolah',
                                    'deskripsi' => 'Budaya literasi perlu dibangun sejak dini di sekolah. Artikel ini membahas langkah-langkah yang dapat dilakukan untuk membangun budaya literasi di lingkungan sekolah.',
                                    'tanggal' => '2025-01-07 14:15:00'
                                ],
                            ];
                        @endphp
                        @if(count($artikel) > 0)
                            @foreach($artikel as $index => $item)
                            @php $i = $index + 1; @endphp
                        <article class="bg-white border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col sm:flex-row">
                                <div class="w-full sm:w-1/4 shrink-0">
                                    <img
                                        src="{{ asset('img/sample' . ($i % 2 + 1) . '.jpg') }}?v={{ filemtime(public_path('img/sample' . ($i % 2 + 1) . '.jpg')) }}"
                                        alt="Artikel {{ $i }}"
                                        class="w-full h-40 sm:h-full object-cover"
                                    >
                                </div>
                                <div class="w-full sm:w-3/4 p-4 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 line-clamp-2 hover:text-green-700 transition-colors">
                                            {{ $item['judul'] }}
                                        </h3>
                                        <p class="text-xs text-gray-600 line-clamp-2 mb-3">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-500">
                                            @php
                                                $dateObj = \Carbon\Carbon::now()->subDays(4 - $i)->subHours(4 - $i);
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
                        @else
                            <div class="flex items-center justify-center" style="min-height: 400px;">
                                <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                                    Belum Ada Artikel
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 text-center">
                        <a href="#" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
                            Lihat Semua Artikel
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                @include('home.sections.prestasi-siswa')
                @include('home.sections.foto-kegiatan')
            </div>

            <!-- Kanan: Sambutan Kepala Madrasah (30%) -->
            <div class="w-full lg:w-[30%] lg:pt-[32px]">
                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        @php
                            $kepalaMadrasahPath = 'img/kepala-madrasah.jpg';
                            $kepalaMadrasahVersion = file_exists(public_path($kepalaMadrasahPath)) ? filemtime(public_path($kepalaMadrasahPath)) : null;
                        @endphp
                        <div class="mb-3">
                            <img
                                src="{{ asset($kepalaMadrasahPath) }}@if($kepalaMadrasahVersion)?v={{ $kepalaMadrasahVersion }}@endif"
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
                
                @include('home.sections.info-terkini')
                @include('home.sections.agenda-terbaru')
            </div>
        </div>
    </div>
</section>

