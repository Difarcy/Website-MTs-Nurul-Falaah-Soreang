@extends('layouts.app')

@section('title', 'Agenda - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <x-page-title title="Agenda" />
        
        @php
            $agenda = [
                [
                    'judul' => 'Rapat Koordinasi Guru dan Staf',
                    'tanggal' => '2025-01-20',
                    'waktu' => '08:00 - 12:00',
                    'lokasi' => 'Aula MTs Nurul Falaah Soreang',
                    'deskripsi' => 'Rapat koordinasi bulanan untuk membahas program dan kegiatan sekolah bulan depan.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Kegiatan Outing Class Siswa Kelas 7',
                    'tanggal' => '2025-01-25',
                    'waktu' => '07:00 - 15:00',
                    'lokasi' => 'Taman Wisata Alam',
                    'deskripsi' => 'Kegiatan pembelajaran di luar kelas untuk meningkatkan pengalaman belajar siswa.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'judul' => 'Lomba Tahfidz Al-Qur\'an Tingkat Sekolah',
                    'tanggal' => '2025-02-01',
                    'waktu' => '08:00 - 14:00',
                    'lokasi' => 'Masjid MTs Nurul Falaah Soreang',
                    'deskripsi' => 'Kompetisi tahfidz Al-Qur\'an antar kelas untuk memotivasi siswa dalam menghafal Al-Qur\'an.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Workshop Peningkatan Kompetensi Guru',
                    'tanggal' => '2025-02-05',
                    'waktu' => '09:00 - 15:00',
                    'lokasi' => 'Laboratorium Komputer',
                    'deskripsi' => 'Pelatihan peningkatan kompetensi guru dalam penggunaan teknologi pembelajaran.',
                'gambar' => 'sample2.jpg'
                ],
                [
                    'judul' => 'Kegiatan Bakti Sosial Siswa',
                    'tanggal' => '2025-02-10',
                    'waktu' => '08:00 - 12:00',
                    'lokasi' => 'Lingkungan Sekitar Sekolah',
                    'deskripsi' => 'Kegiatan bakti sosial untuk menumbuhkan kepedulian sosial siswa terhadap lingkungan.',
                'gambar' => 'sample1.jpg'
                ],
                [
                    'judul' => 'Pertemuan Orang Tua dan Wali Murid',
                    'tanggal' => '2025-02-15',
                    'waktu' => '13:00 - 16:00',
                    'lokasi' => 'Aula MTs Nurul Falaah Soreang',
                    'deskripsi' => 'Pertemuan rutin untuk membahas perkembangan siswa dan program sekolah.',
                'gambar' => 'sample2.jpg'
                ]
            ];
            
            // Data untuk testing
            $infoTerkini = [
                ['judul' => 'Pengumuman Libur Semester Genap', 'tanggal' => '2025-01-20'],
                ['judul' => 'Jadwal Ujian Tengah Semester', 'tanggal' => '2025-01-18'],
                ['judul' => 'Pendaftaran Ekstrakurikuler Baru', 'tanggal' => '2025-01-16'],
            ];
            
            $now = \Carbon\Carbon::now();
            $selectedMonth = request()->get('cal_month', $now->month);
            $selectedYear = request()->get('cal_year', $now->year);
            
            // Validate month and year
            $selectedMonth = max(1, min(12, (int)$selectedMonth));
            $selectedYear = max(2000, min(2100, (int)$selectedYear));
            
            $firstDay = \Carbon\Carbon::create($selectedYear, $selectedMonth, 1);
            $lastDay = $firstDay->copy()->endOfMonth();
            $startDate = $firstDay->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
            $endDate = $lastDay->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
            
            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $daysShort = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            
            // Calculate prev/next month
            $prevMonth = $selectedMonth - 1;
            $prevYear = $selectedYear;
            if ($prevMonth < 1) {
                $prevMonth = 12;
                $prevYear--;
            }
            
            $nextMonth = $selectedMonth + 1;
            $nextYear = $selectedYear;
            if ($nextMonth > 12) {
                $nextMonth = 1;
                $nextYear++;
            }
        @endphp

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 mt-8">
            <!-- Kiri: Agenda (70%) -->
            <div class="w-full lg:w-[70%]">
                <div class="space-y-6">
                    @foreach($agenda as $item)
                    <div class="bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer" onclick="window.location.href='#'">
                        <div class="flex flex-col md:flex-row">
                            <!-- Foto (Kiri) -->
                            <div class="w-full md:w-1/3 flex-shrink-0">
                                <img
                                    src="{{ asset('img/' . $item['gambar']) }}?v={{ filemtime(public_path('img/' . $item['gambar'])) }}"
                                    alt="{{ $item['judul'] }}"
                                    class="w-full h-48 md:h-full object-cover"
                                >
                            </div>
                            <!-- Konten (Kanan) -->
                            <div class="w-full md:w-2/3 p-5 sm:p-6">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-3">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 hover:text-green-700 transition-colors">
                                        {{ $item['judul'] }}
                                    </h3>
                                    <div class="flex-shrink-0">
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs sm:text-sm font-semibold rounded">
                                            @php
                                                $dateObj = \Carbon\Carbon::parse($item['tanggal']);
                                                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                $monthName = $months[$dateObj->month - 1];
                                                echo $dateObj->day . ' ' . $monthName . ' ' . $dateObj->year;
                                            @endphp
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-start gap-2 text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium">Waktu:</span>
                                        <span>{{ $item['waktu'] }}</span>
                                    </div>
                                    <div class="flex items-start gap-2 text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="font-medium">Lokasi:</span>
                                        <span>{{ $item['lokasi'] }}</span>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    {{ $item['deskripsi'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Garis Pembatas -->
            <div class="hidden lg:block border-l border-gray-300"></div>

            <!-- Kanan: Sidebar (30%) -->
            <div class="w-full lg:w-[30%]">
                <!-- Info Terkini -->
                <div class="bg-white border border-gray-200 overflow-hidden mb-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Info Terkini
                        </h3>
                        <div class="space-y-3 min-h-[300px]">
                            @if(count($infoTerkini) > 0)
                                @foreach($infoTerkini as $item)
                                <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
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

                <!-- Kalender -->
                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Kalender
                        </h3>
                        <div id="calendar-header" class="flex items-center justify-between mb-3">
                            <button onclick="changeCalendarMonth(-1)" class="p-1 hover:bg-gray-100 rounded transition-colors" aria-label="Bulan Sebelumnya">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <h4 id="calendar-title" class="text-sm font-bold text-gray-900">{{ $months[$selectedMonth - 1] }} {{ $selectedYear }}</h4>
                            <button onclick="changeCalendarMonth(1)" class="p-1 hover:bg-gray-100 rounded transition-colors" aria-label="Bulan Selanjutnya">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        <div id="calendar-grid" class="grid grid-cols-7 gap-1 text-center">
                            @foreach($daysShort as $day)
                            <div class="text-xs font-semibold text-gray-600 py-1">{{ $day }}</div>
                            @endforeach
                            @php
                                $currentDate = $startDate->copy();
                            @endphp
                            @while($currentDate <= $endDate)
                            <div class="aspect-square flex items-center justify-center text-xs {{ $currentDate->month == $selectedMonth ? 'text-gray-900' : 'text-gray-400' }} {{ $currentDate->isToday() && $currentDate->month == $now->month && $currentDate->year == $now->year ? 'bg-green-700 text-white rounded font-bold' : '' }} hover:bg-gray-100 hover:rounded transition-colors cursor-pointer">
                                {{ $currentDate->day }}
                            </div>
                            @php
                                $currentDate->addDay();
                            @endphp
                            @endwhile
                        </div>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="bg-white border border-gray-200 overflow-hidden mt-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Media Sosial
                        </h3>
                        <div class="flex items-center justify-start gap-4">
                            <!-- Facebook -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-blue-600 hover:text-blue-700 transition-colors duration-300 transform hover:scale-110" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <!-- X (Twitter) -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-gray-900 hover:text-gray-700 transition-colors duration-300 transform hover:scale-110" aria-label="X (Twitter)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            <!-- Instagram -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-pink-600 hover:text-pink-700 transition-colors duration-300 transform hover:scale-110" aria-label="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <!-- YouTube -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-red-600 hover:text-red-700 transition-colors duration-300 transform hover:scale-110" aria-label="YouTube">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <!-- TikTok -->
                            <a href="{{ route('social-media-unavailable') }}" class="text-black hover:text-gray-800 transition-colors duration-300 transform hover:scale-110" aria-label="TikTok">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Akses Cepat -->
                <div class="bg-white border border-gray-200 overflow-hidden mt-6">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Akses Cepat
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('informasi.berita') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Berita</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('informasi.artikel') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Artikel</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('informasi.pengumuman') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Pengumuman</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('galeri.foto-kegiatan') }}" class="flex items-center gap-2 text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors group">
                                    <span>Foto Kegiatan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    // Calendar state
    let currentCalendarMonth = {{ $selectedMonth }};
    let currentCalendarYear = {{ $selectedYear }};
    const today = new Date({{ $now->year }}, {{ $now->month - 1 }}, {{ $now->day }});
    
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const daysShort = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    
    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }
    
    function getFirstDayOfMonth(month, year) {
        const firstDay = new Date(year, month - 1, 1);
        return firstDay.getDay(); // 0 = Sunday, 1 = Monday, etc.
    }
    
    function isToday(date, month, year) {
        return date === today.getDate() && 
               month === today.getMonth() + 1 && 
               year === today.getFullYear();
    }
    
    function renderCalendar(month, year) {
        const calendarTitle = document.getElementById('calendar-title');
        const calendarGrid = document.getElementById('calendar-grid');
        
        // Update title
        calendarTitle.textContent = `${months[month - 1]} ${year}`;
        
        // Clear existing days
        calendarGrid.innerHTML = '';
        
        // Add day headers back
        daysShort.forEach(day => {
            const header = document.createElement('div');
            header.className = 'text-xs font-semibold text-gray-600 py-1';
            header.textContent = day;
            calendarGrid.appendChild(header);
        });
        
        // Calculate calendar dates
        const daysInMonth = getDaysInMonth(month, year);
        const firstDay = getFirstDayOfMonth(month, year);
        
        // Previous month days
        const prevMonth = month === 1 ? 12 : month - 1;
        const prevYear = month === 1 ? year - 1 : year;
        const daysInPrevMonth = getDaysInMonth(prevMonth, prevYear);
        
        for (let i = firstDay - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            const dayElement = document.createElement('div');
            dayElement.className = 'aspect-square flex items-center justify-center text-xs text-gray-400 hover:bg-gray-100 hover:rounded transition-colors cursor-pointer';
            dayElement.textContent = day;
            calendarGrid.appendChild(dayElement);
        }
        
        // Current month days
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            const isTodayDate = isToday(day, month, year);
            dayElement.className = `aspect-square flex items-center justify-center text-xs text-gray-900 hover:bg-gray-100 hover:rounded transition-colors cursor-pointer ${isTodayDate ? 'bg-green-700 text-white rounded font-bold' : ''}`;
            dayElement.textContent = day;
            calendarGrid.appendChild(dayElement);
        }
        
        // Next month days (fill remaining cells)
        const totalCells = calendarGrid.children.length;
        const remainingCells = 42 - totalCells; // 6 weeks * 7 days = 42
        
        const nextMonth = month === 12 ? 1 : month + 1;
        const nextYear = month === 12 ? year + 1 : year;
        
        for (let day = 1; day <= remainingCells; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'aspect-square flex items-center justify-center text-xs text-gray-400 hover:bg-gray-100 hover:rounded transition-colors cursor-pointer';
            dayElement.textContent = day;
            calendarGrid.appendChild(dayElement);
        }
    }
    
    function changeCalendarMonth(direction) {
        currentCalendarMonth += direction;
        
        if (currentCalendarMonth < 1) {
            currentCalendarMonth = 12;
            currentCalendarYear--;
        } else if (currentCalendarMonth > 12) {
            currentCalendarMonth = 1;
            currentCalendarYear++;
        }
        
        renderCalendar(currentCalendarMonth, currentCalendarYear);
        
        // Update URL without reload
        const url = new URL(window.location.href);
        url.searchParams.set('cal_month', currentCalendarMonth);
        url.searchParams.set('cal_year', currentCalendarYear);
        window.history.pushState({}, '', url.toString());
    }
</script>
@endpush
@endsection

