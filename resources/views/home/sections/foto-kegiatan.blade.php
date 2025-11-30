<!-- Galeri Foto Kegiatan -->
<div class="mt-6">
    <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
        <span class="w-px h-6 sm:h-8 bg-green-700"></span>
        Kegiatan Sekolah
    </h2>
    <div class="grid grid-cols-3 gap-4 min-h-[320px]">
            @if(isset($fotoKegiatan) && $fotoKegiatan->count() > 0)
                @foreach($fotoKegiatan as $index => $item)
                @php $i = $index + 1; @endphp
            <div class="relative overflow-hidden rounded-lg cursor-pointer" onclick="openHomeLightbox(this)">
                <div class="w-full aspect-[4/3] overflow-hidden relative">
                    <img
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/default-backgrounds.png') }}"
                        alt="{{ $item->judul ?? 'Foto Kegiatan ' . $i }}"
                        class="w-full h-full object-cover"
                    >
                </div>
            </div>
                @endforeach
            @else
                <div class="col-span-full flex items-center justify-center py-12">
                    <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                        Belum Ada Foto Kegiatan
                    </p>
                </div>
        @endif
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('galeri.foto-kegiatan') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Lightbox Modal untuk Foto Beranda -->
    <div id="home-lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="relative w-full h-full flex items-center justify-center">
            <!-- Previous Button -->
            <button
                onclick="prevHomeLightboxImage()"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-200 transition-colors z-10 bg-black/50 rounded-full p-2 hover:bg-black/70 backdrop-blur-sm"
                aria-label="Sebelumnya"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Next Button -->
            <button
                onclick="nextHomeLightboxImage()"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-200 transition-colors z-10 bg-black/50 rounded-full p-2 hover:bg-black/70 backdrop-blur-sm"
                aria-label="Selanjutnya"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Close Button -->
            <button
                onclick="closeHomeLightbox()"
                class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors z-10 bg-black/50 rounded-full p-1.5 hover:bg-black/70 backdrop-blur-sm"
                aria-label="Tutup"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Image Wrapper for Slide Effect -->
            <div class="relative w-full h-full overflow-hidden flex items-center justify-center p-4">
                <img
                    id="home-lightbox-image"
                    src=""
                    alt=""
                    class="max-w-full max-h-full w-auto h-auto object-contain transition-all duration-300 ease-in-out"
                    style="transform: scale(0.8) translateX(0); opacity: 0;"
                >
            </div>
        </div>
    </div>

    <script>
        // Initialize foto slides for lightbox
        document.addEventListener('DOMContentLoaded', function() {
            // Get all foto kegiatan items (grid items with onclick)
            const fotoItems = document.querySelectorAll('div[onclick*="openHomeLightbox"]');
            window.homeFotoSlides = Array.from(fotoItems);
            window.currentHomeLightboxIndex = 0;
        });

        function openHomeLightbox(element) {
            // Pastikan lightbox dan image element ada
            const lightbox = document.getElementById('home-lightbox');
            const lightboxImage = document.getElementById('home-lightbox-image');
            
            if (!lightbox || !lightboxImage) {
                console.error('Lightbox elements not found');
                return;
            }
            
            // Inisialisasi slides jika belum ada
            if (!window.homeFotoSlides || window.homeFotoSlides.length === 0) {
                const fotoItems = document.querySelectorAll('div[onclick*="openHomeLightbox"]');
                window.homeFotoSlides = Array.from(fotoItems);
            }
            
            const homeFotoSlides = window.homeFotoSlides || [];
            
            // Find index of clicked element
            let foundIndex = -1;
            homeFotoSlides.forEach((slide, index) => {
                if (slide === element || slide.contains(element)) {
                    foundIndex = index;
                }
            });
            
            if (foundIndex === -1) foundIndex = 0;
            
            window.currentHomeLightboxIndex = foundIndex;
            
            // Cari gambar di dalam element
            let img = element.querySelector('img');
            if (!img && element.tagName === 'IMG') {
                img = element;
            }
            
            if (!img) {
                console.error('Image not found in element');
                return;
            }
            
            // Set image source
            lightboxImage.src = img.src;
            lightboxImage.alt = img.alt || '';

            // Show lightbox
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Reset transform dan opacity
            lightboxImage.style.transform = 'scale(0.8) translateX(0)';
            lightboxImage.style.opacity = '0';

            // Animate zoom in
            setTimeout(() => {
                lightboxImage.style.transform = 'scale(1) translateX(0)';
                lightboxImage.style.opacity = '1';
            }, 10);
        }
        
        // Make function globally available
        window.openHomeLightbox = openHomeLightbox;

        function prevHomeLightboxImage() {
            const slides = window.homeFotoSlides || [];
            const currentIdx = window.currentHomeLightboxIndex || 0;
            
            if (!slides || slides.length === 0) return;
            
            const newIndex = (currentIdx - 1 + slides.length) % slides.length;
            window.currentHomeLightboxIndex = newIndex;
            updateHomeLightboxImage('prev');
        }

        function nextHomeLightboxImage() {
            const slides = window.homeFotoSlides || [];
            const currentIdx = window.currentHomeLightboxIndex || 0;
            
            if (!slides || slides.length === 0) return;
            
            const newIndex = (currentIdx + 1) % slides.length;
            window.currentHomeLightboxIndex = newIndex;
            updateHomeLightboxImage('next');
        }

        function updateHomeLightboxImage(direction = 'next') {
            const lightboxImage = document.getElementById('home-lightbox-image');
            const slides = window.homeFotoSlides || [];
            const currentIndex = window.currentHomeLightboxIndex || 0;
            const slide = slides[currentIndex];
            
            if (!slide) return;
            
            // Cari gambar di dalam slide
            let img = slide.querySelector('img');
            if (!img && slide.tagName === 'IMG') {
                img = slide;
            }
            
            if (!img) return;
            
            // Fade out with slight translate
            const translateX = direction === 'next' ? '-20px' : '20px';
            lightboxImage.style.transform = `scale(0.95) translateX(${translateX})`;
            lightboxImage.style.opacity = '0';
            
            setTimeout(() => {
                lightboxImage.src = img.src;
                lightboxImage.alt = img.alt;
                
                // Fade in from opposite direction
                const translateInX = direction === 'next' ? '20px' : '-20px';
                lightboxImage.style.transform = `scale(0.95) translateX(${translateInX})`;
                
                setTimeout(() => {
                    lightboxImage.style.opacity = '1';
                    lightboxImage.style.transform = 'scale(1) translateX(0)';
                }, 50);
            }, 200);
        }

        function closeHomeLightbox() {
            const lightbox = document.getElementById('home-lightbox');
            const lightboxImage = document.getElementById('home-lightbox-image');

            if (!lightbox || !lightboxImage) return;

            lightboxImage.style.transform = 'scale(0.8)';
            lightboxImage.style.opacity = '0';

            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.style.overflow = '';
            }, 200);
        }
        
        // Make functions globally available
        window.prevHomeLightboxImage = prevHomeLightboxImage;
        window.nextHomeLightboxImage = nextHomeLightboxImage;
        window.closeHomeLightbox = closeHomeLightbox;

        // Close on overlay click
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = document.getElementById('home-lightbox');
            if (lightbox) {
                lightbox.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeHomeLightbox();
                    }
                });
            }
        });

        // Close on Escape key and navigation with arrow keys
        document.addEventListener('keydown', function(e) {
            const lightbox = document.getElementById('home-lightbox');
            if (!lightbox || lightbox.classList.contains('hidden')) return;

            if (e.key === 'Escape') {
                closeHomeLightbox();
            } else if (e.key === 'ArrowLeft') {
                prevHomeLightboxImage();
            } else if (e.key === 'ArrowRight') {
                nextHomeLightboxImage();
            }
        });
    </script>
</div>

