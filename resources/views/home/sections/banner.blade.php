<!-- Banner Hero -->
@php
    $logoPath = 'img/logo.png';
    $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
    $slides = [
        [
            'tagline' => 'Selamat Datang di Website Resmi',
            'title' => 'MTs Nurul Falaah Soreang',
            'description' => 'Kami berkomitmen mencetak generasi berilmu, berakhlak, dan berprestasi. Mari bersama membangun masa depan yang cerah.',
            'button_text' => 'Lihat Profil Sekolah',
            'button_route' => 'profil',
            'image' => 'img/banner1.jpg',
        ],
        [
            'tagline' => 'Fokus pada Prestasi dan Akhlak',
            'title' => 'Membina Generasi Unggul',
            'description' => 'Program akademik dan keagamaan kami dirancang untuk menumbuhkan karakter disiplin, kreatif, dan berakhlak mulia.',
            'button_text' => 'Lihat Prestasi Siswa',
            'button_route' => 'profil.prestasi',
            'image' => 'img/banner2.jpg',
        ],
        [
            'tagline' => 'Lingkungan Belajar Nyaman',
            'title' => 'Fasilitas Lengkap dan Modern',
            'description' => 'Ruang belajar yang nyaman, laboratorium, sarana ibadah, serta kegiatan ekstrakurikuler yang variatif siap mendukung potensi siswa.',
            'button_text' => 'Galeri Kegiatan',
            'button_route' => 'galeri.foto-kegiatan',
            'image' => 'img/banner3.jpg',
        ],
    ];
@endphp
<section class="w-full relative overflow-hidden">
    <div class="relative banner-slider h-[460px] sm:h-[560px] md:h-[620px] lg:h-[680px]" data-banner-slider>
        @foreach ($slides as $index => $slide)
            @php
                $imagePath = $slide['image'];
                $imageVersion = file_exists(public_path($imagePath)) ? filemtime(public_path($imagePath)) : null;
            @endphp
            <div class="banner-slide @if($index === 0) is-active @endif" data-banner-slide data-slide-index="{{ $index }}">
                <img
                    src="{{ asset($imagePath) }}@if($imageVersion)?v={{ $imageVersion }}@endif"
                    alt="{{ $slide['title'] }}"
                    class="banner-slide__image"
                >
                <div class="banner-slide__overlay"></div>
                <div class="banner-slide__content">
                    <div class="banner-slide__inner">
                        <div class="mb-4 sm:mb-6">
                            <img
                                src="{{ asset($logoPath) }}@if($logoVersion)?v={{ $logoVersion }}@endif"
                                alt="Logo MTs Nurul Falaah Soreang"
                                class="h-24 w-24 sm:h-32 sm:w-32 md:h-36 md:w-36 lg:h-40 lg:w-40 object-contain drop-shadow-lg"
                                style="filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));"
                            >
                        </div>
                        <p class="text-sm sm:text-base md:text-lg font-bold text-white mb-2 drop-shadow-md banner-slide__tagline">
                            {{ $slide['tagline'] }}
                        </p>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-lg banner-slide__title">
                            {{ $slide['title'] }}
                        </h1>
                        <p class="text-sm sm:text-base md:text-lg text-white mb-5 drop-shadow-md leading-relaxed max-w-2xl banner-slide__description">
                            {{ $slide['description'] }}
                        </p>
                        <a
                            href="{{ route($slide['button_route']) }}"
                            class="inline-block bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 px-6 rounded-lg transition-all duration-300 hover:shadow-xl shadow-lg uppercase text-sm"
                        >
                            {{ $slide['button_text'] }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Indicators -->
        <div class="banner-slider__indicators" data-banner-indicators>
            @foreach ($slides as $index => $slide)
                <button
                    class="banner-indicator @if($index === 0) is-active @endif"
                    data-banner-dot
                    data-slide-target="{{ $index }}"
                    aria-label="Pilih slide {{ $index + 1 }}"
                ></button>
            @endforeach
        </div>
    </div>
</section>

