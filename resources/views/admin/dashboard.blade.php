@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Selamat Datang</h1>
            <p class="text-base text-slate-500 mt-1 font-medium">Pilih menu di bawah untuk mengelola konten website</p>
        </div>

        <!-- Menu Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Berita & Artikel -->
            <a href="{{ route('admin.posts.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-green-100 rounded-lg p-3 group-hover:bg-green-600 transition">
                        <svg class="w-8 h-8 text-green-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Berita & Artikel</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola berita dan artikel sekolah</p>
                        <div class="mt-3 flex items-center gap-4 text-sm text-slate-400 font-medium">
                            <span>Total: {{ $stats['total_posts'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['published_posts'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Banner -->
            <a href="{{ route('admin.banners.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-blue-600 transition">
                        <svg class="w-8 h-8 text-blue-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Banner</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola gambar slider di halaman utama</p>
                        <div class="mt-3 flex items-center gap-4 text-sm text-slate-400 font-medium">
                            <span>Total: {{ $stats['total_banners'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['active_banners'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Foto Kegiatan -->
            <a href="{{ route('admin.foto-kegiatan.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-600 transition">
                        <svg class="w-8 h-8 text-purple-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Foto Kegiatan</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola foto-foto kegiatan sekolah</p>
                        <div class="mt-3 flex items-center gap-4 text-sm text-slate-400 font-medium">
                            <span>Total: {{ $stats['total_fotos'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['active_fotos'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Prestasi Siswa -->
            <a href="{{ route('admin.prestasi-siswa.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-yellow-100 rounded-lg p-3 group-hover:bg-yellow-600 transition">
                        <svg class="w-8 h-8 text-yellow-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Prestasi Siswa</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola prestasi dan pencapaian siswa</p>
                        <div class="mt-3 flex items-center gap-4 text-sm text-slate-400 font-medium">
                            <span>Total: {{ $stats['total_prestasi'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['active_prestasi'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Pengumuman -->
            <a href="{{ route('admin.pengumuman.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-orange-100 rounded-lg p-3 group-hover:bg-orange-600 transition">
                        <svg class="w-8 h-8 text-orange-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Pengumuman</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola pengumuman sekolah</p>
                        <div class="mt-3 flex items-center gap-4 text-xs text-slate-400">
                            <span>Total: {{ $stats['total_pengumuman'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['active_pengumuman'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Agenda -->
            <a href="{{ route('admin.agenda.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-indigo-100 rounded-lg p-3 group-hover:bg-indigo-600 transition">
                        <svg class="w-8 h-8 text-indigo-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Agenda</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola agenda dan jadwal kegiatan</p>
                        <div class="mt-3 flex items-center gap-4 text-xs text-slate-400">
                            <span>Total: {{ $stats['total_agenda'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['active_agenda'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Kontak -->
            <a href="{{ route('admin.kontak.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-teal-100 rounded-lg p-3 group-hover:bg-teal-600 transition">
                        <svg class="w-8 h-8 text-teal-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Kontak</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola informasi kontak sekolah</p>
                        <div class="mt-3 flex items-center gap-4 text-xs text-slate-400">
                            <span>Total: {{ $stats['total_kontak'] }}</span>
                            <span>•</span>
                            <span class="text-green-600">Aktif: {{ $stats['active_kontak'] }}</span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Info Sekolah -->
            <a href="{{ route('admin.info-sekolah.index') }}" class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-green-600 hover:shadow-lg transition-all group">
                <div class="flex items-start gap-4">
                    <div class="bg-pink-100 rounded-lg p-3 group-hover:bg-pink-600 transition">
                        <svg class="w-8 h-8 text-pink-700 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700">Info Sekolah</h3>
                        <p class="text-base text-slate-500 mt-1 font-medium">Kelola teks informasi di website</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Info Cepat -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-bold text-blue-900 text-base">Tips Menggunakan Panel</h4>
                    <ul class="text-sm text-blue-700 mt-2 space-y-1 list-disc list-inside font-medium">
                        <li>Klik menu di atas untuk mengelola konten</li>
                        <li>Gunakan tombol "Tambah" untuk membuat konten baru</li>
                        <li>Klik "Edit" untuk mengubah konten yang sudah ada</li>
                        <li>Pastikan gambar yang diupload ukurannya tidak terlalu besar (maksimal 5MB)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
