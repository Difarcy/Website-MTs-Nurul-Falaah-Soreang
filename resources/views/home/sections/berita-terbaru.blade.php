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
                    $newsItems = $latestNews ?? collect();
                    $articleItems = $latestArticles ?? collect();
                    $fallbackImages = ['img/banner1.jpg', 'img/banner2.jpg', 'img/banner3.jpg'];
                    $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 lg:gap-6">
                    @forelse($newsItems as $index => $item)
                        @php
                            $image = $item->thumbnail_path
                                ? asset('storage/' . $item->thumbnail_path)
                                : asset($fallbackImages[$index % count($fallbackImages)]);
                            $dateObj = $item->published_at ?? $item->created_at;
                            $monthName = $monthNames[$dateObj->month - 1];
                            $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                            $time = $dateObj->format('H:i');
                        @endphp
                    <article class="bg-white border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col">
                        <div class="w-full">
                            <img
                                src="{{ $image }}"
                                alt="{{ $item->title }}"
                                class="w-full h-40 sm:h-48 object-cover"
                            >
                        </div>
                        <div class="w-full p-4 flex flex-col flex-grow">
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 line-clamp-2 hover:text-green-700 transition-colors">
                                {{ $item->title }}
                            </h3>
                            <p class="text-xs text-gray-600 line-clamp-3 mb-3 flex-grow">
                                {{ $item->excerpt }}
                            </p>
                            <div class="mt-auto space-y-2">
                                <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                    Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <p class="text-xs text-gray-500">
                                    {{ $date }} | {{ $time }}
                                </p>
                            </div>
                        </div>
                    </article>
                    @empty
                        <div class="col-span-full flex items-center justify-center" style="min-height: 600px;">
                            <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                                Belum Ada Berita
                            </p>
                        </div>
                    @endforelse
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
                                src="{{ asset('img/default-backgrounds.png') }}@if(file_exists(public_path('img/default-backgrounds.png')))?v={{ filemtime(public_path('img/default-backgrounds.png')) }}@endif"
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
                        @forelse($articleItems as $index => $item)
                            @php
                                $image = $item->thumbnail_path
                                    ? asset('storage/' . $item->thumbnail_path)
                                    : asset($fallbackImages[($index + 1) % count($fallbackImages)]);
                                $dateObj = $item->published_at ?? $item->created_at;
                                $monthName = $monthNames[$dateObj->month - 1];
                                $date = $dateObj->day . ' ' . $monthName . ', ' . $dateObj->year;
                                $time = $dateObj->format('H:i');
                        @endphp
                        <article class="bg-white border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col sm:flex-row">
                                <div class="w-full sm:w-1/4 shrink-0">
                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-40 sm:h-full object-cover"
                                    >
                                </div>
                                <div class="w-full sm:w-3/4 p-4 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 line-clamp-2 hover:text-green-700 transition-colors">
                                            {{ $item->title }}
                                        </h3>
                                        <p class="text-xs text-gray-600 line-clamp-2 mb-3">
                                            {{ $item->excerpt }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-500">
                                            {{ $date }} | {{ $time }}
                                        </p>
                                        <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                            Baca Artikel
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @empty
                            <div class="flex items-center justify-center" style="min-height: 400px;">
                                <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                                    Belum Ada Artikel
                                </p>
                            </div>
                        @endforelse
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
                
                @include('home.sections.prestasi-siswa', ['prestasiSiswa' => $prestasiSiswa ?? collect()])
                @include('home.sections.foto-kegiatan', ['fotoKegiatan' => $fotoKegiatan ?? collect()])
            </div>

            <!-- Kanan: Sambutan Kepala Madrasah (30%) -->
            <div class="w-full lg:w-[30%] lg:pt-[32px]">
                <div class="bg-white border border-gray-200 overflow-hidden">
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
                
                @include('home.sections.info-terkini', ['infoTerkini' => $infoTerkini ?? collect()])
                @include('home.sections.agenda-terbaru', ['agendaTerbaru' => $agendaTerbaru ?? collect()])
            </div>
        </div>
    </div>
</section>

