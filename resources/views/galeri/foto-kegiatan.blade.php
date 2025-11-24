@extends('layouts.app')

@section('title', 'Foto Kegiatan | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <x-page-title title="Foto Kegiatan" />

        @php
            $kegiatan = [
                [
                    'nama' => 'Upacara Bendera',
                    'deskripsi' => 'Kegiatan upacara bendera rutin setiap hari Senin untuk menumbuhkan rasa nasionalisme dan disiplin siswa.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'nama' => 'Kegiatan Belajar Mengajar',
                    'deskripsi' => 'Proses pembelajaran aktif di dalam kelas dengan metode yang menyenangkan dan interaktif.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'nama' => 'Kegiatan Ekstrakurikuler',
                    'deskripsi' => 'Siswa mengikuti berbagai kegiatan ekstrakurikuler untuk mengembangkan bakat dan minat mereka.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'nama' => 'Kegiatan Outbound',
                    'deskripsi' => 'Kegiatan outbound untuk melatih kerja sama tim dan meningkatkan kebersamaan antar siswa.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'nama' => 'Kegiatan Pramuka',
                    'deskripsi' => 'Kegiatan pramuka untuk melatih kemandirian, kedisiplinan, dan kepemimpinan siswa.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'nama' => 'Kegiatan Olahraga',
                    'deskripsi' => 'Kegiatan olahraga untuk menjaga kesehatan dan kebugaran fisik siswa.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'nama' => 'Kegiatan Seni',
                    'deskripsi' => 'Kegiatan seni untuk mengembangkan kreativitas dan bakat seni siswa.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'nama' => 'Kegiatan Keagamaan',
                    'deskripsi' => 'Kegiatan keagamaan untuk memperdalam pemahaman agama dan akhlak siswa.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'nama' => 'Kegiatan Workshop Kreativitas',
                    'deskripsi' => 'Workshop kreativitas untuk mengasah kemampuan berpikir kreatif dan inovatif siswa dalam menyelesaikan masalah.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'nama' => 'Kegiatan Field Trip',
                    'deskripsi' => 'Kunjungan edukatif ke berbagai tempat untuk memperluas wawasan dan pengalaman belajar siswa di luar kelas.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'nama' => 'Kegiatan Seminar Pendidikan',
                    'deskripsi' => 'Seminar pendidikan untuk meningkatkan pemahaman siswa tentang pentingnya pendidikan dan pengembangan diri.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'nama' => 'Kegiatan Pentas Seni',
                    'deskripsi' => 'Pentas seni tahunan untuk menampilkan bakat dan kreativitas siswa dalam berbagai bidang seni dan budaya.',
                'gambar' => 'sample2.jpg'
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 mt-8 min-h-[400px]">
            @if(count($kegiatan) > 0)
                @foreach($kegiatan as $index => $item)
            <div class="group bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-full aspect-video overflow-hidden cursor-pointer" onclick="openLightbox({{ $index }})">
                    <img
                        src="{{ asset('img/' . $item['gambar']) }}?v={{ filemtime(public_path('img/' . $item['gambar'])) }}"
                        alt="{{ $item['nama'] }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    >
                </div>
                <div class="p-4 sm:p-5">
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900 mb-2 group-hover:text-green-700 transition-colors">
                        {{ $item['nama'] }}
                    </h3>
                    <p class="text-[10px] sm:text-xs text-gray-600 leading-relaxed">
                        {{ $item['deskripsi'] }}
                    </p>
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
        const kegiatan = @json($kegiatan);
        let currentLightboxIndex = 0;

        function openLightbox(index) {
            currentLightboxIndex = index;
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');

            const item = kegiatan[index];
            lightboxImage.src = "{{ asset('img/') }}/" + item.gambar + "?v={{ filemtime(public_path('img/sample1.jpg')) }}";
            lightboxImage.alt = item.nama;

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
            currentLightboxIndex = (currentLightboxIndex - 1 + kegiatan.length) % kegiatan.length;
            updateLightboxImage('prev');
        }

        function nextLightboxImage() {
            currentLightboxIndex = (currentLightboxIndex + 1) % kegiatan.length;
            updateLightboxImage('next');
        }

        function updateLightboxImage(direction = 'next') {
            const lightboxImage = document.getElementById('lightbox-image');
            const item = kegiatan[currentLightboxIndex];
            
            // Fade out with slight translate
            const translateX = direction === 'next' ? '-20px' : '20px';
            lightboxImage.style.transform = `scale(0.95) translateX(${translateX})`;
            lightboxImage.style.opacity = '0';
            
            setTimeout(() => {
                lightboxImage.src = "{{ asset('img/') }}/" + item.gambar + "?v={{ filemtime(public_path('img/sample1.jpg')) }}";
                lightboxImage.alt = item.nama;
                
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
