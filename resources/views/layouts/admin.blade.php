<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>

    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $adminFaviconPath = $siteSettings && $siteSettings->logo_path ? ('storage/' . $siteSettings->logo_path) : null;
        // Cache busting untuk favicon admin
        $adminFaviconVersion = $adminFaviconPath && $siteSettings->updated_at ? $siteSettings->updated_at->timestamp : null;
    @endphp
    @if($adminFaviconPath)
        <link rel="icon" type="image/png" href="{{ asset($adminFaviconPath) }}@if($adminFaviconVersion)?v={{ $adminFaviconVersion }}@endif">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">
        <link rel="icon" type="image/svg+xml" media="(prefers-color-scheme: light)" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000000' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">
    @endif
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        body {
            font-family: 'Archivo Narrow', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700">
            <div class="px-4 pt-3 pb-2 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-1.5">
                    <div class="flex items-center justify-center w-12 h-12 bg-slate-900 rounded-lg">
                        <svg class="w-7 h-7 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Admin Panel</p>
                    </div>
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 text-base font-semibold">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.posts.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Berita & Artikel</span>
                </a>
                <a href="{{ route('admin.pengumuman.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.pengumuman.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Pengumuman</span>
                </a>
                <a href="{{ route('admin.agenda.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.agenda.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Agenda</span>
                </a>
                <a href="{{ route('admin.banners.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Banner</span>
                </a>
                <a href="{{ route('admin.foto-kegiatan.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.foto-kegiatan.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Foto Kegiatan</span>
                </a>
                <a href="{{ route('admin.prestasi-siswa.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.prestasi-siswa.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Prestasi Siswa</span>
                </a>
                <a href="{{ route('admin.kontak.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.kontak.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Kontak</span>
                </a>
                <a href="{{ route('admin.info-sekolah.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.info-sekolah.*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Info Sekolah</span>
                </a>
                <a href="{{ route('admin.settings.logo') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.logo') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Logo</span>
                </a>
                <a href="{{ route('admin.settings.top-bar') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.top-bar*') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Top Bar</span>
                </a>
                <a href="{{ route('admin.change-password') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.change-password') ? 'bg-slate-100 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:!text-white' }}">
                    <span>Ganti Password</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 px-4 sm:px-6 py-4 flex items-center justify-between">
                <div class="lg:hidden flex items-center gap-1.5">
                    <div class="flex items-center justify-center w-12 h-12 bg-slate-900 rounded-lg">
                        <svg class="w-7 h-7 !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-bold tracking-tight dark:text-white">Admin Panel</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 ml-auto">
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:block" id="logout-form">
                        @csrf
                        <button type="submit" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar?')) { document.getElementById('logout-form').submit(); }" class="inline-flex items-center px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </header>

            <main class="admin-main flex-1 px-4 sm:px-6 py-6">
                @if(session('status'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        // Function untuk update counter karakter
        function updateCharCount(fieldId, maxLength) {
            const field = document.getElementById(fieldId);
            if (!field) return;
            
            const countElement = document.getElementById(fieldId + '-count');
            if (!countElement) return;
            
            const currentLength = field.value.length;
            const remaining = maxLength - currentLength;
            
            countElement.textContent = currentLength;
            
            // Update warna berdasarkan sisa karakter
            if (remaining < 20) {
                countElement.className = 'text-red-600 font-semibold';
            } else if (remaining < 50) {
                countElement.className = 'text-amber-600 font-semibold';
            } else {
                countElement.className = 'text-slate-500';
            }
        }

        // Auto-initialize counter untuk semua field yang memiliki maxlength
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[maxlength]').forEach(function(field) {
                const fieldId = field.id;
                const maxLength = parseInt(field.getAttribute('maxlength'));
                
                if (fieldId && maxLength) {
                    // Update counter saat ini
                    updateCharCount(fieldId, maxLength);
                    
                    // Tambahkan event listener jika belum ada
                    if (!field.hasAttribute('data-char-counter-initialized')) {
                        field.setAttribute('data-char-counter-initialized', 'true');
                        field.addEventListener('input', function() {
                            updateCharCount(fieldId, maxLength);
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>

