<!-- Banner Hero -->
@php
$siteSettings = \App\Models\SiteSetting::first();
$logoPath = $siteSettings && $siteSettings->logo_path ? ('storage/' . $siteSettings->logo_path) : 'img/logo.png';
// Cache busting: untuk storage gunakan updated_at, untuk file default gunakan filemtime
if ($siteSettings && $siteSettings->logo_path) {
$logoVersion = $siteSettings->updated_at ? $siteSettings->updated_at->timestamp : time();
} else {
$logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
}

// Ambil banner dari database, jika tidak ada gunakan default
$dbBanners = isset($banners) && $banners->count() > 0 ? $banners : collect();

// Ambil pengaturan global banner (informasi yang dipakai semua slide)
$globalSettings = \App\Models\BannerSetting::first();
$defaultSlides = [
[
'tagline' => 'Selamat Datang di Website Resmi',
'title' => 'MTs Nurul Falaah Soreang',
'description' => 'Kami berkomitmen mencetak generasi berilmu, berakhlak, dan berprestasi. Mari bersama membangun masa depan yang cerah.',
'button_text' => 'Lihat Profil Sekolah',
'button_route' => 'profil',
'image' => asset('img/default-backgrounds.png'),
],
[
'tagline' => 'Fokus pada Prestasi dan Akhlak',
'title' => 'Membina Generasi Unggul',
'description' => 'Program akademik dan keagamaan kami dirancang untuk menumbuhkan karakter disiplin, kreatif, dan berakhlak mulia.',
'button_text' => 'Lihat Prestasi Siswa',
'button_route' => 'profil.prestasi',
'image' => asset('img/default-backgrounds.png'),
],
[
'tagline' => 'Lingkungan Belajar Nyaman',
'title' => 'Fasilitas Lengkap dan Modern',
'description' => 'Ruang belajar yang nyaman, laboratorium, sarana ibadah, serta kegiatan ekstrakurikuler yang variatif siap mendukung potensi siswa.',
'button_text' => 'Galeri Kegiatan',
'button_route' => 'galeri.foto-kegiatan',
'image' => asset('img/default-backgrounds.png'),
],
];

// Siapkan informasi konten (statis, tidak berubah)
$tagline = '';
$title = '';
$description = '';
$buttonText = 'Lihat Selengkapnya';
$buttonLink = null;
$buttonRoute = null;
$showLogo = true;
$showTagline = true;
$showTitle = true;
$showDescription = true;
$showButton = true;

// Siapkan array gambar untuk slider
$slideImages = [];

// Jika ada banner dari DB, gunakan; jika tidak, gunakan default
if ($dbBanners->count() > 0) {
// Gunakan informasi global untuk konten (jika ada)
if ($globalSettings) {
$tagline = $globalSettings->tagline ?? '';
$title = $globalSettings->judul ?? '';
$description = $globalSettings->deskripsi ?? '';
$buttonText = $globalSettings->button_text ?? 'Lihat Selengkapnya';
$buttonLink = $globalSettings->link ?? null;
$showLogo = $globalSettings->show_logo ?? true;
$showTagline = $globalSettings->show_tagline ?? true;
$showTitle = $globalSettings->show_title ?? true;
$showDescription = $globalSettings->show_description ?? true;
$showButton = $globalSettings->show_button ?? true;
}

// Ambil hanya gambar-gambar untuk slider (urutkan berdasarkan urutan)
$slideImages = $dbBanners->filter(function($banner) {
return $banner->is_active && $banner->gambar;
})->sortBy('urutan')->values()->map(function($banner) {
$bannerUpdatedAt = $banner->updated_at ? $banner->updated_at->timestamp : time();
$imagePath = 'storage/' . $banner->gambar;
$imageUrl = asset('storage/' . $banner->gambar);

return [
'image' => $imageUrl,
'image_path' => $imagePath,
'image_version' => $bannerUpdatedAt,
];
})->toArray();

// Jika tidak ada slide aktif, gunakan default
if (empty($slideImages)) {
$slideImages = array_map(function($slide) {
$imagePath = str_replace(asset(''), '', $slide['image']);
$imageVersion = file_exists(public_path($imagePath)) ? filemtime(public_path($imagePath)) : null;
return [
'image' => $slide['image'],
'image_path' => $imagePath,
'image_version' => $imageVersion,
];
}, $defaultSlides);

// Gunakan informasi dari slide pertama default
$firstDefault = $defaultSlides[0];
$tagline = $firstDefault['tagline'] ?? '';
$title = $firstDefault['title'] ?? '';
$description = $firstDefault['description'] ?? '';
$buttonText = $firstDefault['button_text'] ?? 'Lihat Selengkapnya';
$buttonRoute = $firstDefault['button_route'] ?? null;
}
} else {
// Gunakan default slides
$slideImages = array_map(function($slide) {
$imagePath = str_replace(asset(''), '', $slide['image']);
$imageVersion = file_exists(public_path($imagePath)) ? filemtime(public_path($imagePath)) : null;
return [
'image' => $slide['image'],
'image_path' => $imagePath,
'image_version' => $imageVersion,
];
}, $defaultSlides);

// Gunakan informasi dari slide pertama default
$firstDefault = $defaultSlides[0];
$tagline = $firstDefault['tagline'] ?? '';
$title = $firstDefault['title'] ?? '';
$description = $firstDefault['description'] ?? '';
$buttonText = $firstDefault['button_text'] ?? 'Lihat Selengkapnya';
$buttonRoute = $firstDefault['button_route'] ?? null;
}
@endphp
<section class="w-full relative overflow-hidden">
    <div class="relative group h-[500px] sm:h-[600px] md:h-[660px] lg:h-[720px] w-full overflow-hidden flex" data-banner-slider>
        <!-- Hanya gambar yang di-slide -->
        @foreach ($slideImages as $index => $slideImage)
        @php
        // Cache busting untuk banner images
        if (isset($slideImage['image_version'])) {
        $imageSrc = $slideImage['image'] . '?v=' . $slideImage['image_version'];
        } else {
        $imagePath = $slideImage['image_path'] ?? '';
        $imageVersion = file_exists(public_path($imagePath)) ? filemtime(public_path($imagePath)) : null;
        $imageSrc = $slideImage['image'] . ($imageVersion ? '?v=' . $imageVersion : '');
        }
        @endphp
        @if($index === 0)
        <div class="absolute inset-0 transition-all duration-700 ease-in-out will-change-[transform] translate-x-0 opacity-100 visible z-10" data-banner-slide data-slide-index="{{ $index }}">
            <img src="{{ $imageSrc }}" alt="Banner {{ $index + 1 }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/65 dark:from-black/40 dark:to-black/70"></div>
        </div>
        @else
        <div class="absolute inset-0 transition-all duration-700 ease-in-out will-change-[transform] translate-x-full opacity-0 invisible z-0" data-banner-slide data-slide-index="{{ $index }}">
            <img src="{{ $imageSrc }}" alt="Banner {{ $index + 1 }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/65 dark:from-black/40 dark:to-black/70"></div>
        </div>
        @endif
        @endforeach

        <!-- Konten Statis (Logo, Teks, Tombol) - Tidak bergerak -->
        <div class="absolute inset-0 flex items-end pb-10 md:pb-16 z-20 pointer-events-none">
            <div class="px-6 max-w-3xl sm:pl-10 lg:pl-20 pointer-events-auto">
                @if($showLogo)
                <div class="mb-4 sm:mb-6">
                    <img src="{{ asset($logoPath) }}@if($logoVersion)?v={{ $logoVersion }}@endif" alt="Logo MTs Nurul Falaah Soreang" class="h-24 w-24 sm:h-32 sm:w-32 md:h-36 md:w-36 lg:h-40 lg:w-40 object-contain drop-shadow-[1px_1px_2px_rgba(0,0,0,0.4)] md:drop-shadow-[2px_2px_4px_rgba(0,0,0,0.5)] dark:drop-shadow-[2px_2px_4px_rgba(0,0,0,0.7)]">
                </div>
                @endif
                @if($showTagline && !empty($tagline))
                <p class="text-sm sm:text-base md:text-lg font-bold text-white mb-2 drop-shadow-md">
                    {{ $tagline }}
                </p>
                @endif
                @if($showTitle && !empty($title))
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                    {{ $title }}
                </h1>
                @endif
                @if($showDescription && !empty($description))
                <p class="text-sm sm:text-base md:text-lg text-white mb-5 drop-shadow-md leading-relaxed max-w-2xl text-left">
                    {{ $description }}
                </p>
                @endif
                @if($showButton)
                @if($buttonLink)
                <a href="{{ $buttonLink }}" class="inline-block bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 px-6 rounded-lg transition-all duration-300 hover:shadow-xl shadow-lg uppercase text-sm">
                    {{ $buttonText }}
                </a>
                @elseif($buttonRoute)
                <a href="{{ route($buttonRoute) }}" class="inline-block bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 px-6 rounded-lg transition-all duration-300 hover:shadow-xl shadow-lg uppercase text-sm">
                    {{ $buttonText }}
                </a>
                @endif
                @endif
            </div>
        </div>

        <!-- Indicators -->
        <div class="hidden sm:flex absolute bottom-8 left-1/2 -translate-x-1/2 items-center gap-3 z-30 px-4 py-2 opacity-0 invisible transition-all duration-300 ease-out group-hover:opacity-100 group-hover:visible" data-banner-indicators>
            @foreach ($slideImages as $index => $slideImage)
            <button class="w-8 h-1.5 rounded-sm bg-white/50 cursor-pointer transition-all duration-300 ease-in-out shrink-0 @if($index === 0) bg-white w-10 @endif" data-banner-dot data-slide-target="{{ $index }}" aria-label="Pilih slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </div>
</section>
