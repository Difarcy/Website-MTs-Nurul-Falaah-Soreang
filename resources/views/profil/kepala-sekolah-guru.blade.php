@extends('layouts.app')

@section('title', 'Sambutan Kepala Madrasah | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <!-- Header Section -->
        <div class="mb-8">
            <x-page-title title="Sambutan Kepala Madrasah" />
        </div>

        <!-- Sambutan Kepala Madrasah -->
        <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-center">
            <!-- Gambar Kepala Madrasah (Kiri) -->
            <div class="w-full md:w-[30%] shrink-0">
                @php
                    $kepalaMadrasahPath = 'img/kepala-madrasah.jpg';
                    $kepalaMadrasahVersion = file_exists(public_path($kepalaMadrasahPath)) ? filemtime(public_path($kepalaMadrasahPath)) : null;
                @endphp
                <img
                    src="{{ asset($kepalaMadrasahPath) }}@if($kepalaMadrasahVersion)?v={{ $kepalaMadrasahVersion }}@endif"
                    alt="Kepala Madrasah MTs Nurul Falaah Soreang"
                    class="w-full aspect-[3/4] object-cover"
                    style="max-height: 36rem;"
                >
            </div>
            <!-- Teks Sambutan (Kanan) -->
            <div class="w-full md:w-[70%] flex-1">
                <div class="mb-4 text-center md:text-left">
                    <p class="text-base sm:text-lg font-semibold text-gray-900 mb-2">
                        Waskam, S.Pd. M.Pd.
                    </p>
                    <p class="text-xs sm:text-sm text-gray-600">
                        - Kepala Madrasah -
                    </p>
                </div>
                <div class="prose prose-lg max-w-none">
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-0 text-justify">
                        Assalamualaikum warahmatullahi wabarakatuh,
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4 text-justify mt-4">
                        Puji syukur kita panjatkan kehadirat Allah SWT atas limpahan rahmat-Nya. Selamat datang di website resmi MTs Nurul Falaah Soreang. Melalui media ini, kami berharap masyarakat dapat mengenal lebih dekat komitmen madrasah dalam mencetak generasi berilmu, berakhlak, dan berprestasi.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4 text-justify">
                        Sebagai lembaga pendidikan tingkat menengah pertama berbasis Islam, kami senantiasa mengintegrasikan nilai-nilai keislaman dalam setiap proses pembelajaran. Dengan dukungan tenaga pendidik profesional dan fasilitas yang terus ditingkatkan, kami berupaya menghadirkan lingkungan belajar yang aman, nyaman, dan inspiratif bagi seluruh siswa.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4 text-justify">
                        Berbagai program akademik, keagamaan, dan ekstrakurikuler kami rancang untuk mengembangkan potensi siswa secara optimal. Kami yakin sinergi antara pengetahuan, akhlak, dan karakter akan melahirkan generasi yang siap menghadapi tantangan masa depan.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-0 text-justify">
                        Terima kasih kepada para orang tua dan seluruh pihak yang telah mempercayakan pendidikan putra-putrinya kepada MTs Nurul Falaah Soreang. Semoga website ini dapat menjadi sarana informasi dan komunikasi yang bermanfaat bagi kita semua.
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-0 text-justify mt-4">
                        Wassalamualaikum warahmatullahi wabarakatuh.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
