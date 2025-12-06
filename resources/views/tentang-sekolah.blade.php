@extends('layouts.app')

@section('title', 'Tentang Sekolah | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Profil']
        ]" />
        <!-- Header Section -->
        <div class="mb-8">
            <x-page-title title="Tentang Sekolah" />
        </div>

        <!-- Subtitle -->
        <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-6 text-center">
            MTs NURUL FALAAH SOREANG
        </h2>

        <!-- Foto Gedung Sekolah -->
        <img
            src="{{ asset('img/default-backgrounds.png') }}@if(file_exists(public_path('img/default-backgrounds.png')))?v={{ filemtime(public_path('img/default-backgrounds.png')) }}@endif"
            alt="Gedung MTs Nurul Falaah Soreang"
            class="w-full h-80 sm:h-96 md:h-[450px] object-cover mb-8"
        >

        <div class="prose prose-lg max-w-none">
            <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-0 text-justify">
                MTs Nurul Falaah Soreang merupakan lembaga pendidikan tingkat menengah pertama (Madrasah Tsanawiyah) yang berstatus swasta, berada di bawah naungan <strong class="text-green-700">Kementerian Agama Republik Indonesia</strong> dan dikelola oleh <strong class="text-green-700">Yayasan Nurul Falaah Soreang</strong>. Madrasah ini beralamat di <strong class="text-green-700">Jl. Soreang–Banjaran, Kp. Ciwaru RT 01/RW 16, Desa Soreang, Kecamatan Soreang, Kabupaten Bandung, Provinsi Jawa Barat</strong>, dengan <strong class="text-green-700">Nomor Pokok Sekolah Nasional (NPSN) 20278189</strong>. Sebagai lembaga pendidikan Islam, MTs Nurul Falaah Soreang berkomitmen untuk mencetak generasi yang berilmu, berakhlak, dan berprestasi, sejalan dengan motto <strong class="text-green-700">"Mencetak Generasi Berilmu, Berakhlak, dan Berprestasi."</strong> Dengan waktu penyelenggaraan pagi hari, madrasah ini menjadi wadah pembentukan karakter dan pengembangan potensi akademik serta spiritual siswa. Berdasarkan <strong class="text-green-700">Surat Keputusan Akreditasi Nomor 1442/BAN-SM/SK/2019</strong> tertanggal <strong class="text-green-700">12 Desember 2019</strong>, MTs Nurul Falaah Soreang telah memperoleh <strong class="text-green-700">akreditasi B</strong> dari BAN-S/M, sebagai bukti bahwa mutu pendidikan dan manajemen sekolah telah memenuhi standar nasional pendidikan. Selain itu, madrasah juga telah memiliki fasilitas penunjang yang memadai, seperti akses internet, sumber listrik permanen, dan sarana belajar yang terus dikembangkan guna mendukung kegiatan pembelajaran yang modern dan efektif.
            </p>
        </div>

        <!-- Sejarah Singkat -->
        <div class="mt-8">
            <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                <span class="w-px h-6 sm:h-8 bg-green-700"></span>
                Sejarah Singkat
            </h2>
            <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-center">
                <!-- Gambar Sejarah (Kiri) -->
                <div class="w-full md:w-1/2 shrink-0">
                    <img
                        src="{{ asset('img/default-backgrounds.png') }}@if(file_exists(public_path('img/default-backgrounds.png')))?v={{ filemtime(public_path('img/default-backgrounds.png')) }}@endif"
                        alt="Sejarah MTs Nurul Falaah Soreang"
                        class="w-full h-64 sm:h-80 md:h-96 object-cover"
                    >
                </div>
                <!-- Teks Sejarah (Kanan) -->
                <div class="w-full md:w-1/2 flex-1">
                    <div class="prose prose-lg max-w-none">
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-0 text-justify">
                            Madrasah Tsanawiyah (MTs) Nurul Falaah Soreang didirikan pada tanggal <strong class="text-green-700">13 Mei 2002</strong> berdasarkan <strong class="text-green-700">SK Pendirian Nomor WI/PP.00.5/1242/2002</strong>. Pada awal berdirinya, madrasah ini hadir atas prakarsa masyarakat dan tokoh agama setempat yang memiliki kepedulian terhadap pentingnya pendidikan Islam di wilayah Soreang dan sekitarnya. Seiring berkembangnya kegiatan pendidikan dan meningkatnya kebutuhan akan pengelolaan yang lebih profesional, maka dibentuklah <strong class="text-green-700">Yayasan Nurul Falaah Soreang</strong> pada tahun <strong class="text-green-700">2009</strong> sebagai badan hukum resmi yang menaungi madrasah. Kemudian, melalui <strong class="text-green-700">SK Operasional Nomor Kd.104/04/pp.00.5351/2010</strong> tertanggal <strong class="text-green-700">23 Juni 2010</strong>, MTs Nurul Falaah Soreang resmi memperoleh izin operasional dari Kementerian Agama Kabupaten Bandung. Hingga saat ini, MTs Nurul Falaah Soreang terus berkembang menjadi lembaga pendidikan yang dipercaya masyarakat, dengan semangat untuk membangun generasi muda yang beriman, berilmu, dan berdaya saing tinggi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="mt-8 prose prose-lg max-w-none">
            <p class="text-sm sm:text-base text-gray-700 leading-relaxed text-justify">
                Untuk informasi lebih lengkap mengenai MTs Nurul Falaah Soreang, silakan kunjungi halaman <a href="{{ route('profil.informasi-sekolah') }}" class="text-green-700 hover:text-green-800 font-semibold underline">Informasi Sekolah</a>. Informasi mengenai <a href="{{ route('profil.visi-misi') }}" class="text-green-700 hover:text-green-800 font-semibold underline">Visi, Misi, dan Tujuan</a> dapat dilihat di halaman khusus. Kami berharap MTs Nurul Falaah Soreang senantiasa berkembang dan menjadi salah satu lembaga pendidikan terdepan yang turut mendukung kemajuan masyarakat di Soreang.
            </p>
        </div>
    </div>
@endsection

