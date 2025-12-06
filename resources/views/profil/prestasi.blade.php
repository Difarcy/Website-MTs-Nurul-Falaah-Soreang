@extends('layouts.app')

@section('title', 'Prestasi Siswa | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Profil', 'url' => route('profil')],
            ['label' => 'Prestasi']
        ]" />
        <x-page-title title="Prestasi Siswa" />

        @php
            // Data prestasi dari database sudah dikirim dari controller
            $prestasi = isset($prestasi) ? $prestasi : collect();
            
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
            <!-- Kiri: Prestasi Siswa (70%) -->
            <div class="w-full lg:w-[70%]">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 min-h-[400px]">
                    @if($prestasi->count() > 0)
                        @foreach($prestasi as $index => $item)
                        <div class="group bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="w-full h-56 sm:h-64 overflow-hidden cursor-pointer" onclick="openLightbox({{ $index }})">
                                <img
                                    src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/default-backgrounds.png') }}"
                                    alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                >
                            </div>
                            <div class="p-4 sm:p-5">
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-green-700 transition-colors">
                                    {{ $item->judul }}
                                </h3>
                                @if($item->deskripsi)
                                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed line-clamp-3">
                                        {{ $item->deskripsi }}
                                    </p>
                                @endif
                                @if($item->kategori)
                                    <p class="text-xs text-green-700 mt-2 font-semibold">{{ $item->kategori }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full flex items-center justify-center" style="min-height: 400px;">
                            <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                                Belum Ada Prestasi
                            </p>
                        </div>
                    @endif
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

                <!-- Info Terkini -->
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Info Terkini
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
                                    Belum Ada Info Terkini
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-md">
        <div class="relative w-full h-full flex items-center justify-center p-4">
            <!-- Previous Button -->
            <button
                onclick="prevLightboxImage()"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-200 transition-colors z-10 bg-black/40 rounded-full p-2 hover:bg-black/60 backdrop-blur-sm"
                aria-label="Sebelumnya"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Next Button -->
            <button
                onclick="nextLightboxImage()"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-200 transition-colors z-10 bg-black/40 rounded-full p-2 hover:bg-black/60 backdrop-blur-sm"
                aria-label="Selanjutnya"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Image Container with Close Button -->
            <div class="relative max-w-7xl w-full h-full flex items-center justify-center">
                <!-- Close Button - aligned with top of image -->
                <button
                    onclick="closeLightbox()"
                    class="absolute top-0 right-0 text-white hover:text-gray-200 transition-colors z-10 bg-black/40 rounded-full p-1.5 hover:bg-black/60 backdrop-blur-sm"
                    aria-label="Tutup"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Image Wrapper for Slide Effect -->
                <div class="relative w-full h-full overflow-hidden flex items-center justify-center">
                    <img
                        id="lightbox-image"
                        src=""
                        alt=""
                        class="max-w-full max-h-full object-contain shadow-2xl transition-all duration-300 ease-in-out"
                        style="transform: scale(0.8) translateX(0); opacity: 0;"
                    >
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const prestasi = @json($prestasi);
        let currentLightboxIndex = 0;

        function openLightbox(index) {
            currentLightboxIndex = index;
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');

            const item = prestasi[index];
            lightboxImage.src = item.gambar ? "{{ asset('storage/') }}/" + item.gambar : "{{ asset('img/default-backgrounds.png') }}";
            lightboxImage.alt = item.judul;

            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Animate zoom in
            setTimeout(() => {
                lightboxImage.style.transform = 'scale(1) translateX(0)';
                lightboxImage.style.opacity = '1';
            }, 10);
        }

        function prevLightboxImage() {
            currentLightboxIndex = (currentLightboxIndex - 1 + prestasi.length) % prestasi.length;
            updateLightboxImage('prev');
        }

        function nextLightboxImage() {
            currentLightboxIndex = (currentLightboxIndex + 1) % prestasi.length;
            updateLightboxImage('next');
        }

        function updateLightboxImage(direction = 'next') {
            const lightboxImage = document.getElementById('lightbox-image');
            const item = prestasi[currentLightboxIndex];
            
            // Fade out with slight translate
            const translateX = direction === 'next' ? '-20px' : '20px';
            lightboxImage.style.transform = `scale(0.95) translateX(${translateX})`;
            lightboxImage.style.opacity = '0';
            
            setTimeout(() => {
                lightboxImage.src = item.gambar ? "{{ asset('storage/') }}/" + item.gambar : "{{ asset('img/default-backgrounds.png') }}";
                lightboxImage.alt = item.judul;
                
                // Fade in from opposite direction
                const translateInX = direction === 'next' ? '20px' : '-20px';
                lightboxImage.style.transform = `scale(0.95) translateX(${translateInX})`;
                
                setTimeout(() => {
                    lightboxImage.style.opacity = '1';
                    lightboxImage.style.transform = 'scale(1) translateX(0)';
                }, 50);
            }, 200);
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');

            lightboxImage.style.transform = 'scale(0.8)';
            lightboxImage.style.opacity = '0';

            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.style.overflow = '';
            }, 200);
        }

        // Close on overlay click
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Close on Escape key and navigation with arrow keys
        document.addEventListener('keydown', function(e) {
            const lightbox = document.getElementById('lightbox');
            if (lightbox.classList.contains('hidden')) return;

            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                prevLightboxImage();
            } else if (e.key === 'ArrowRight') {
                nextLightboxImage();
            }
        });
    </script>
    @endpush
@endsection

