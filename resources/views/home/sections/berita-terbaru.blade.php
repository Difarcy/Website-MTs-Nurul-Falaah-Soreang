<!-- Berita Terbaru dengan Sidebar -->
<section class="bg-white pt-1 sm:pt-2 pb-8 sm:pb-12 fade-in-section">
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Kiri: Berita Terbaru (70%) -->
            <div class="w-full lg:w-[70%]">
                @php
                    $fallbackImages = ['img/banner1.jpg', 'img/banner2.jpg', 'img/banner3.jpg'];
                    $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                @endphp

                <!-- Highlight News Slider -->
                @if(isset($highlightNews) && $highlightNews->count() > 0)
                <div class="mb-8">
                    <div class="relative overflow-hidden shadow-lg group" id="highlight-slider">
                        <div class="highlight-slides flex transition-transform duration-500 ease-in-out" id="highlight-slides">
                            @foreach($highlightNews as $index => $news)
                                @php
                                    $image = $news->thumbnail_path
                                        ? asset('storage/' . $news->thumbnail_path)
                                        : asset($fallbackImages[$index % count($fallbackImages)]);
                                    $dateObj = $news->published_at ?? $news->created_at;
                                    $month = $monthNames[$dateObj->month - 1];
                                    $date = $dateObj->day . ' ' . $month . ', ' . $dateObj->year;
                                @endphp
                                <div class="highlight-slide flex-shrink-0 w-full relative cursor-pointer" onclick="window.location.href='{{ route('informasi.show', ['type' => $news->type, 'slug' => $news->slug]) }}'">
                                    <img src="{{ $image }}" alt="{{ $news->title }}" class="w-full h-72 sm:h-80 md:h-96 lg:h-[28rem] object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 text-white">
                                        <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 line-clamp-2 drop-shadow-lg">
                                            {{ $news->title }}
                                        </h3>
                                        <p class="text-sm sm:text-base opacity-90 drop-shadow-md">
                                            {{ $date }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation Arrows -->
                        <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm opacity-0 group-hover:opacity-100" id="highlight-prev">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all duration-200 backdrop-blur-sm opacity-0 group-hover:opacity-100" id="highlight-next">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>

                        <!-- Indicators -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2" id="highlight-indicators">
                            @for($i = 0; $i < $highlightNews->count(); $i++)
                                <button class="w-2 h-2 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-200 {{ $i === 0 ? 'bg-white' : '' }}" data-slide="{{ $i }}"></button>
                            @endfor
                        </div>
                    </div>
                </div>
                @endif

                <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-4 flex items-center gap-3">
                    <span class="w-px h-6 sm:h-8 bg-green-700"></span>
                    Berita Terbaru
                </h2>
                @php
                    $newsItems = $latestNews ?? collect();
                    $articleItems = ($latestArticles ?? collect())->take(4);
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
                        <div class="w-full pointer-events-none">
                            <img
                                src="{{ $image }}"
                                alt="{{ $item->title }}"
                                class="w-full aspect-video object-cover"
                            >
                        </div>
                        <div class="w-full p-4 flex flex-col grow">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-green-700 transition-colors">
                                <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="hover:text-green-700 transition-colors">
                                    {{ $item->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-3 mb-4 grow text-justify">
                                {{ $item->excerpt }}
                            </p>
                            <div class="mt-auto flex items-center justify-between">
                                <p class="text-xs text-gray-500">
                                    {{ $date }} | {{ $time }}
                                </p>
                                <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                    Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
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

                <!-- Banner Promosi -->
                <div class="mt-8">
                    @if(isset($promosiBannerPath) && $promosiBannerPath)
                        <div class="bg-gray-100 border border-gray-300 overflow-hidden hover:shadow-lg transition-all duration-300 cursor-pointer" style="aspect-ratio: 1920/600;" onclick="openPromosiBannerModal('{{ asset('storage/' . $promosiBannerPath) }}')">
                            <div class="w-full h-full">
                                <img
                                    src="{{ asset('storage/' . $promosiBannerPath) }}"
                                    alt="Banner Promosi"
                                    class="w-full h-full object-cover hover:opacity-90 transition-opacity"
                                    style="object-fit: cover;"
                                >
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-100 border border-gray-300 overflow-hidden" style="aspect-ratio: 1920/600;">
                            <div class="w-full h-full flex items-center justify-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada banner</p>
                            </div>
                        </div>
                    @endif
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
                                <div class="w-full sm:w-[38%] shrink-0">
                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-14 sm:h-16 object-cover"
                                    >
                                </div>
                                <div class="w-full sm:w-[62%] p-2.5 sm:p-3 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 line-clamp-2 hover:text-green-700 transition-colors">
                                            <a href="{{ route('informasi.show', ['type' => $item->type, 'slug' => $item->slug]) }}" class="hover:text-green-700 transition-colors">
                                                {{ $item->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-600 line-clamp-4 mb-2 text-justify">
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
                        <a href="{{ route('informasi.artikel') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
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
            <div class="w-full lg:w-[30%] lg:-mt-4">
                <div class="bg-white overflow-hidden">
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
                                class="w-full aspect-3/4 object-cover mx-auto kepala-madrasah"
                                style="max-height: 28rem;"
                            >
                        </div>
                        <div class="mb-3 text-center">
                            <p class="text-base text-gray-700 font-semibold text-center">
                                Waskam, S.Pd. M.Pd.
                            </p>
                            <p class="text-xs sm:text-sm text-gray-600 mt-1 text-center">
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

@push('scripts')
<script>
    // Fungsi untuk open image modal (jika belum ada di layout)
    if (typeof openImageModal === 'undefined') {
        function openImageModal(imageSrc) {
            let modal = document.getElementById('imageModal');
            if (!modal) {
                // Create modal if doesn't exist
                modal = document.createElement('div');
                modal.id = 'imageModal';
                modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/30 dark:bg-black/50 backdrop-blur-md';
                modal.innerHTML = `
                    <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation()">
                        <img id="modalImage" src="" alt="Zoom" class="max-w-full max-h-full object-contain pointer-events-none">
                        <button type="button" class="close-image-modal-btn fixed top-4 right-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors z-10 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);

                // Setup event listeners
                const closeBtn = modal.querySelector('.close-image-modal-btn');
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeImageModal(e);
                    return false;
                }, true);

                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeImageModal(e);
                        return false;
                    }
                }, true);
            }

            const img = document.getElementById('modalImage');
            img.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
            return false;
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('imageModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeImageModal(e);
                }
                const promosiModal = document.getElementById('promosiBannerModal');
                if (promosiModal && !promosiModal.classList.contains('hidden')) {
                    closePromosiBannerModal(e);
                }
            }
        });
    }

    // Fungsi khusus untuk zoom banner promosi dengan fitur zoom in/out
    let isZoomed = false;
    function openPromosiBannerModal(imageSrc) {
        let modal = document.getElementById('promosiBannerModal');
        if (!modal) {
            // Create modal if doesn't exist
            modal = document.createElement('div');
            modal.id = 'promosiBannerModal';
            modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/30 dark:bg-black/50 backdrop-blur-md';
            modal.innerHTML = `
                <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation()">
                    <img id="promosiModalImage" src="" alt="Banner Promosi" class="max-w-full max-h-[90vh] object-contain cursor-zoom-in transition-transform duration-300" style="transform: scale(1);">
                    <button type="button" class="close-promosi-modal-btn fixed top-4 right-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors z-10 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(modal);

            // Setup event listeners
            const closeBtn = modal.querySelector('.close-promosi-modal-btn');
            const img = modal.querySelector('#promosiModalImage');
            
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closePromosiBannerModal(e);
                return false;
            }, true);

            // Zoom on click
            img.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!isZoomed) {
                    img.style.transform = 'scale(1.5)';
                    img.classList.remove('cursor-zoom-in');
                    img.classList.add('cursor-zoom-out');
                    isZoomed = true;
                } else {
                    img.style.transform = 'scale(1)';
                    img.classList.remove('cursor-zoom-out');
                    img.classList.add('cursor-zoom-in');
                    isZoomed = false;
                }
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    e.preventDefault();
                    e.stopPropagation();
                    closePromosiBannerModal(e);
                    return false;
                }
            }, true);
        }

        const img = document.getElementById('promosiModalImage');
        img.src = imageSrc;
        img.style.transform = 'scale(1)';
        img.classList.remove('cursor-zoom-out');
        img.classList.add('cursor-zoom-in');
        isZoomed = false;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closePromosiBannerModal(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        const modal = document.getElementById('promosiBannerModal');
        if (modal) {
            const img = document.getElementById('promosiModalImage');
            if (img) {
                img.style.transform = 'scale(1)';
                img.classList.remove('cursor-zoom-out');
                img.classList.add('cursor-zoom-in');
                isZoomed = false;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        return false;
    }

    // Highlight News Slider
    let highlightCurrentSlide = 0;
    let highlightSlideInterval = null;
    const highlightSlides = document.getElementById('highlight-slides');
    const highlightIndicators = document.getElementById('highlight-indicators');
    const highlightPrevBtn = document.getElementById('highlight-prev');
    const highlightNextBtn = document.getElementById('highlight-next');

    if (highlightSlides && highlightIndicators) {
        const totalSlides = {{ $highlightNews ? $highlightNews->count() : 0 }};

        function updateHighlightSlide() {
            if (!highlightSlides || totalSlides === 0) return;

            // Update slide position
            highlightSlides.style.transform = `translateX(-${highlightCurrentSlide * 100}%)`;

            // Update indicators
            const indicatorButtons = highlightIndicators.querySelectorAll('button');
            indicatorButtons.forEach((btn, index) => {
                btn.classList.toggle('bg-white', index === highlightCurrentSlide);
                btn.classList.toggle('bg-white/50', index !== highlightCurrentSlide);
            });
        }

        function nextHighlightSlide() {
            highlightCurrentSlide = (highlightCurrentSlide + 1) % totalSlides;
            updateHighlightSlide();
        }

        function prevHighlightSlide() {
            highlightCurrentSlide = (highlightCurrentSlide - 1 + totalSlides) % totalSlides;
            updateHighlightSlide();
        }

        function goToHighlightSlide(slideIndex) {
            highlightCurrentSlide = slideIndex;
            updateHighlightSlide();
        }

        // Event listeners
        if (highlightNextBtn) {
            highlightNextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                nextHighlightSlide();
                resetHighlightAutoSlide();
            });
        }

        if (highlightPrevBtn) {
            highlightPrevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                prevHighlightSlide();
                resetHighlightAutoSlide();
            });
        }

        // Indicator click handlers
        const indicatorButtons = highlightIndicators.querySelectorAll('button');
        indicatorButtons.forEach((btn, index) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                goToHighlightSlide(index);
                resetHighlightAutoSlide();
            });
        });

        // Auto slide functionality
        function startHighlightAutoSlide() {
            if (highlightSlideInterval) clearInterval(highlightSlideInterval);
            highlightSlideInterval = setInterval(nextHighlightSlide, 3000); // Change slide every 3 seconds
        }

        function stopHighlightAutoSlide() {
            if (highlightSlideInterval) {
                clearInterval(highlightSlideInterval);
                highlightSlideInterval = null;
            }
        }

        function resetHighlightAutoSlide() {
            stopHighlightAutoSlide();
            startHighlightAutoSlide();
        }

        // Pause on hover
        const highlightSlider = document.getElementById('highlight-slider');
        if (highlightSlider) {
            highlightSlider.addEventListener('mouseenter', stopHighlightAutoSlide);
            highlightSlider.addEventListener('mouseleave', startHighlightAutoSlide);
        }

        // Initialize
        updateHighlightSlide();
        if (totalSlides > 1) {
            startHighlightAutoSlide();
        }
    }
</script>
@endpush

