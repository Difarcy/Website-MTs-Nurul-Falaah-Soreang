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
                            <div class="w-full h-56 sm:h-64 overflow-hidden">
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

                <!-- Pengumuman -->
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
                                    Belum Ada Pengumuman
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

