<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Control Panel')</title>

    <!-- Favicon Admin - Selalu menggunakan icon default, tidak mengikuti logo yang diupload -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">
    <link rel="icon" type="image/svg+xml" media="(prefers-color-scheme: light)" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000000' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .admin-sidebar-scroll {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .admin-sidebar-scroll::-webkit-scrollbar {
            display: none;
        }

        html[data-sidebar-state="1"] #admin-sidebar-menu-container {
            opacity: 0;
            pointer-events: none;
        }

    </style>

    <script>
        try {
            if (localStorage.getItem('admin_sidebar_open_menus')) {
                document.documentElement.dataset.sidebarState = '1';
            }
        } catch (e) {
            // ignore
        }

    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gray-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
    <div class="flex">
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-40 lg:hidden"></div>
        <aside id="admin-sidebar" class="fixed left-0 top-0 z-50 h-screen w-72 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 overflow-hidden transform -translate-x-full transition-transform duration-200 lg:translate-x-0 lg:flex lg:flex-col lg:w-64">
            <div class="h-[72px] px-4 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 flex items-center shrink-0">
                <div class="flex items-center gap-2 select-none">
                    <svg class="w-6 h-6 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-xl font-bold text-slate-900 dark:text-white">Control Panel</span>
                </div>
            </div>
            <div id="admin-sidebar-menu-container" class="flex-1 overflow-y-auto admin-sidebar-scroll">
                <nav class="py-4 space-y-1 text-base font-semibold select-none">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 w-full transition-colors rounded-none {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white font-semibold dark:bg-white/10 dark:text-white' : 'text-slate-700 hover:bg-slate-900 hover:text-white dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- KONTEN WEBSITE -->
                    @php
                    $isKontenOpen = request()->routeIs('admin.profil-sekolah.*') || request()->routeIs('admin.publikasi.*') || request()->routeIs('admin.pengumuman.*') || request()->routeIs('admin.agenda.*') || request()->routeIs('admin.prestasi-siswa.*');
                    @endphp
                    <div class="space-y-1">
                        <button type="button" class="sidebar-menu-toggle w-full flex items-center justify-between gap-2 px-4 py-2 transition-colors rounded-none {{ $isKontenOpen ? 'bg-slate-900 text-white font-semibold dark:bg-white/10 dark:text-white' : 'text-slate-700 hover:bg-slate-900 hover:text-white dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white' }}" data-target="konten-submenu">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Konten Website</span>
                            </div>
                            <svg class="w-5 h-5 transition-transform duration-200 {{ $isKontenOpen ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <div id="konten-submenu" class="space-y-0 pointer-events-auto {{ $isKontenOpen ? '' : 'hidden' }}">
                            <a href="{{ route('admin.profil-sekolah.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.profil-sekolah.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Profil Sekolah</span>
                            </a>
                            <a href="{{ route('admin.publikasi.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.publikasi.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Publikasi</span>
                            </a>
                            <a href="{{ route('admin.pengumuman.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.pengumuman.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Pengumuman</span>
                            </a>
                            <a href="{{ route('admin.agenda.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.agenda.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Agenda</span>
                            </a>
                            <a href="{{ route('admin.prestasi-siswa.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.prestasi-siswa.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Prestasi Siswa</span>
                            </a>
                        </div>
                    </div>

                    <!-- MEDIA -->
                    @php
                    $isMediaOpen = request()->routeIs('admin.foto-kegiatan.*');
                    @endphp
                    <div class="space-y-1">
                        <button type="button" class="sidebar-menu-toggle w-full flex items-center justify-between gap-2 px-4 py-2 transition-colors rounded-none {{ $isMediaOpen ? 'bg-slate-900 text-white dark:bg-white/10 dark:text-white' : 'text-slate-700 hover:bg-slate-900 hover:text-white dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white' }}" data-target="media-submenu">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                </svg>
                                <span>Media</span>
                            </div>
                            <svg class="w-5 h-5 transition-transform duration-200 {{ $isMediaOpen ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <div id="media-submenu" class="space-y-0 pointer-events-auto {{ $isMediaOpen ? '' : 'hidden' }}">
                            <a href="{{ route('admin.foto-kegiatan.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.foto-kegiatan.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Foto Kegiatan</span>
                            </a>
                        </div>
                    </div>

                    <!-- INTERAKSI -->
                    @php
                    $isInteraksiOpen = request()->routeIs('admin.comments.*');
                    @endphp
                    <div class="space-y-1">
                        <button type="button" class="sidebar-menu-toggle w-full flex items-center justify-between gap-2 px-4 py-2 transition-colors rounded-none {{ $isInteraksiOpen ? 'bg-slate-900 text-white dark:bg-white/10 dark:text-white' : 'text-slate-700 hover:bg-slate-900 hover:text-white dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white' }}" data-target="interaksi-submenu">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>Interaksi</span>
                            </div>
                            <svg class="w-5 h-5 transition-transform duration-200 {{ $isInteraksiOpen ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <div id="interaksi-submenu" class="space-y-0 pointer-events-auto {{ $isInteraksiOpen ? '' : 'hidden' }}">
                            <a href="{{ route('admin.comments.index') }}" class="flex items-center justify-between gap-2 pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.comments.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Komentar</span>
                                @php
                                $unreadCount = \App\Models\Comment::where('is_read', false)->count();
                                @endphp
                                @if($unreadCount > 0)
                                <span class="px-2 py-0.5 text-xs font-bold text-white bg-red-600" title="{{ $unreadCount }} komentar belum dibaca">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- PENGATURAN -->
                    @php
                    $isPengaturanOpen = request()->routeIs('admin.tampilan-web.*') || request()->routeIs('admin.info-kontak.*');
                    @endphp
                    <div class="space-y-1">
                        <button type="button" class="sidebar-menu-toggle w-full flex items-center justify-between gap-2 px-4 py-2 transition-colors rounded-none {{ $isPengaturanOpen ? 'bg-slate-900 text-white dark:bg-white/10 dark:text-white' : 'text-slate-700 hover:bg-slate-900 hover:text-white dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white' }}" data-target="pengaturan-submenu">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Pengaturan</span>
                            </div>
                            <svg class="w-5 h-5 transition-transform duration-200 {{ $isPengaturanOpen ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <div id="pengaturan-submenu" class="space-y-0 pointer-events-auto {{ $isPengaturanOpen ? '' : 'hidden' }}">
                            <a href="{{ route('admin.tampilan-web.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.tampilan-web.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Tampilan Web</span>
                            </a>
                            <a href="{{ route('admin.info-kontak.index') }}" class="block pl-12 pr-4 py-1.5 text-base font-medium transition-colors cursor-pointer select-none pointer-events-auto {{ request()->routeIs('admin.info-kontak.*') ? 'text-slate-950 dark:text-white dark:drop-shadow-md' : 'text-slate-500 hover:text-slate-900 dark:text-slate-500 dark:hover:text-white dark:hover:drop-shadow-md' }}">
                                <span>Info Kontak</span>
                            </a>
                        </div>
                    </div>
            </div>
            </nav>
    </div>
    </aside>

    <div class="flex-1 flex flex-col lg:ml-64">
        <header class="sticky top-0 z-40 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 px-3 sm:px-6 h-[72px] overflow-hidden">
            <div class="h-full flex flex-nowrap items-center justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    <button type="button" id="sidebar-toggle-btn" class="inline-flex items-center justify-center w-10 h-10 bg-white dark:bg-slate-900 rounded-lg shrink-0 lg:hidden" aria-label="Buka menu sidebar" aria-controls="admin-sidebar" aria-expanded="false">
                        <svg class="w-6 h-6 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="min-w-0 hidden sm:block">
                        <p class="text-base font-bold tracking-tight text-slate-900 dark:text-white truncate">
                            @yield('title', 'Control Panel')
                        </p>
                    </div>
                </div>

                <div class="flex flex-nowrap items-center justify-end gap-1 overflow-x-auto admin-sidebar-scroll whitespace-nowrap">
                    <a href="{{ route('admin.change-username') }}" data-spa-link class="inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden sm:inline">Ubah Username</span>
                    </a>
                    <a href="{{ route('admin.change-password') }}" class="inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="hidden sm:inline">Ubah Password</span>
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Bantuan</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="ml-2">
                        @csrf
                        <button type="button" id="logout-btn" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors">
                            <svg class="w-4 h-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 sm:px-6 py-6">
            @if(session('status'))
            <div class="mb-6 bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 px-4 py-3 rounded-lg">
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

    <!-- Modal Konfirmasi Logout -->
    <div id="logout-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Konfirmasi Keluar</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Apakah Anda yakin ingin keluar dari control panel?</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="logout-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                    <button type="button" id="logout-confirm-btn" class="px-6 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors min-w-[100px]">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.__adminSidebarInit) return;
            window.__adminSidebarInit = true;

            const sidebarOpenKey = 'admin_sidebar_open_menus';

            function readOpenMenus() {
                try {
                    const raw = localStorage.getItem(sidebarOpenKey);
                    const parsed = raw ? JSON.parse(raw) : [];
                    return Array.isArray(parsed) ? parsed : [];
                } catch (e) {
                    return [];
                }
            }

            function writeOpenMenus(openMenus) {
                try {
                    localStorage.setItem(sidebarOpenKey, JSON.stringify(openMenus));
                } catch (e) {
                    // ignore
                }
            }

            function setMenuOpen(targetId, shouldOpen) {
                const submenu = document.getElementById(targetId);
                const toggle = document.querySelector(`.sidebar-menu-toggle[data-target="${targetId}"]`);
                const arrow = toggle ? toggle.querySelector('svg:last-child') : null;
                if (!submenu) return;

                submenu.classList.toggle('hidden', !shouldOpen);
                if (arrow) {
                    arrow.classList.toggle('rotate-90', shouldOpen);
                }
            }

            const openFromBlade = Array.from(document.querySelectorAll('aside#admin-sidebar [id$="-submenu"]'))
                .filter(el => !el.classList.contains('hidden'))
                .map(el => el.id);

            const openFromStorage = readOpenMenus();
            const mergedOpen = Array.from(new Set([...openFromStorage, ...openFromBlade]));
            mergedOpen.forEach(id => setMenuOpen(id, true));
            writeOpenMenus(mergedOpen);
            try {
                delete document.documentElement.dataset.sidebarState;
            } catch (e) {
                /* ignore */
            }

            // Sidebar sub-menu toggle
            document.addEventListener('click', function(e) {
                const toggle = e.target.closest('.sidebar-menu-toggle');
                if (!toggle) return;
                const targetId = toggle.getAttribute('data-target');
                if (!targetId) return;
                const submenu = document.getElementById(targetId);
                const arrow = toggle.querySelector('svg:last-child');
                if (submenu) {
                    submenu.classList.toggle('hidden');
                    if (arrow) {
                        arrow.classList.toggle('rotate-90');
                    }

                    const isOpen = !submenu.classList.contains('hidden');
                    const openMenus = readOpenMenus();
                    const nextOpenMenus = isOpen ?
                        Array.from(new Set([...openMenus, targetId])) :
                        openMenus.filter(id => id !== targetId);
                    writeOpenMenus(nextOpenMenus);
                }
            });

            // Mobile sidebar toggle
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                if (!sidebar || !overlay) return;
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (!sidebar || !overlay) return;
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
                if (sidebarToggleBtn) sidebarToggleBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            if (sidebarToggleBtn && sidebar && overlay) {
                sidebarToggleBtn.addEventListener('click', function() {
                    const isOpen = !sidebar.classList.contains('-translate-x-full');
                    if (isOpen) closeSidebar();
                    else openSidebar();
                });

                overlay.addEventListener('click', function() {
                    closeSidebar();
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeSidebar();
                    }
                });
            }

            // Logout modal
            const logoutBtn = document.getElementById('logout-btn');
            const logoutModal = document.getElementById('logout-modal');
            const logoutCancelBtn = document.getElementById('logout-cancel-btn');
            const logoutConfirmBtn = document.getElementById('logout-confirm-btn');
            const logoutForm = document.getElementById('logout-form');

            if (logoutBtn && logoutModal && logoutCancelBtn && logoutConfirmBtn && logoutForm) {
                // Tampilkan modal saat tombol logout diklik
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    logoutModal.classList.remove('hidden');
                    logoutModal.classList.add('flex');
                });

                // Tutup modal saat klik Batal
                logoutCancelBtn.addEventListener('click', function() {
                    logoutModal.classList.add('hidden');
                    logoutModal.classList.remove('flex');
                });

                // Submit form saat klik Keluar
                logoutConfirmBtn.addEventListener('click', function() {
                    try {
                        localStorage.removeItem('publikasi_view_preference');
                    } catch (e) {
                        // ignore
                    }
                    logoutForm.submit();
                });

                // Tutup modal saat klik di luar modal
                logoutModal.addEventListener('click', function(e) {
                    if (e.target === logoutModal) {
                        logoutModal.classList.add('hidden');
                        logoutModal.classList.remove('flex');
                    }
                });
            }
        });

    </script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    @stack('scripts')

    <script>
        // Global function untuk image preview (digunakan di banner dan lainnya)
        window.openImagePreview = function(imageSrc, imageAlt) {
            let modal = document.getElementById('imagePreviewModal');
            if (!modal) {
                // Create modal if doesn't exist
                modal = document.createElement('div');
                modal.id = 'imagePreviewModal';
                modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/30 dark:bg-black/50 backdrop-blur-md';
                modal.innerHTML = `
                    <div class="relative w-full h-full flex items-center justify-center p-3" onclick="event.stopPropagation()">
                        <img id="previewImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain pointer-events-none">
                        <button type="button" class="close-modal-btn fixed top-4 right-4 w-10 h-10 flex items-center justify-center text-white hover:text-slate-200 transition-colors z-10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);
            }

            if (modal && modal.dataset.previewInitialized !== '1') {
                modal.dataset.previewInitialized = '1';

                const closeBtn = modal.querySelector('.close-modal-btn');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        window.closeImagePreview(e);
                        return false;
                    }, true);
                }

                const imgEl = modal.querySelector('#previewImage');
                if (imgEl) {
                    imgEl.addEventListener('click', function(e) {
                        if (this.dataset.zoomEnabled !== '1') return;
                        e.preventDefault();
                        e.stopPropagation();

                        const isZoomed = this.dataset.zoomed === '1';
                        if (isZoomed) {
                            this.style.transform = 'scale(1)';
                            this.dataset.zoomed = '0';
                            this.classList.remove('cursor-zoom-out');
                            this.classList.add('cursor-zoom-in');
                        } else {
                            this.style.transform = 'scale(2)';
                            this.dataset.zoomed = '1';
                            this.classList.remove('cursor-zoom-in');
                            this.classList.add('cursor-zoom-out');
                        }
                    }, true);
                }

                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        e.preventDefault();
                        e.stopPropagation();
                        window.closeImagePreview(e);
                        return false;
                    }
                }, true);
            }

            const img = document.getElementById('previewImage');
            img.src = imageSrc;
            img.alt = imageAlt || 'Preview';

            img.style.transform = 'scale(1)';
            img.dataset.zoomed = '0';

            // Jika banner promosi, tampilkan dengan ukuran yang sesuai
            if (imageAlt && imageAlt.toLowerCase().includes('promosi')) {
                img.dataset.zoomEnabled = '1';
                img.className = 'max-w-full max-h-[90vh] object-contain cursor-zoom-in transition-transform duration-300 pointer-events-auto';
                img.style.width = '';
                img.style.height = '';
                img.style.maxWidth = '';
                img.style.maxHeight = '';
                img.style.objectFit = '';
            } else {
                // Untuk banner biasa, tampilkan full size
                img.dataset.zoomEnabled = '0';
                img.className = 'max-w-full max-h-[90vh] object-contain pointer-events-none';
                img.style.width = '';
                img.style.height = '';
                img.style.maxWidth = '';
                img.style.maxHeight = '';
                img.style.objectFit = '';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        };

        window.closeImagePreview = function(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const modal = document.getElementById('imagePreviewModal');
            if (modal) {
                const img = document.getElementById('previewImage');
                if (img) {
                    img.style.transform = 'scale(1)';
                    img.dataset.zoomed = '0';
                    img.dataset.zoomEnabled = '0';
                    img.classList.remove('cursor-zoom-in', 'cursor-zoom-out', 'transition-transform', 'duration-300');
                    img.classList.add('pointer-events-none');
                }
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
            return false;
        };

        // Handle ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('imagePreviewModal');
                if (modal && !modal.classList.contains('hidden')) {
                    window.closeImagePreview(e);
                }
            }
        });

    </script>

    <script>
        // Sidebar Menu Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua tombol menu utama
            const menuToggles = document.querySelectorAll('.sidebar-menu-toggle');

            menuToggles.forEach(button => {
                // Tambahkan cursor pointer ke semua button menu utama
                button.style.cursor = 'pointer';
            });
        });

        // Function untuk update counter karakter (tanpa mengubah warna)
        function updateCharCount(fieldId, maxLength) {
            const field = document.getElementById(fieldId);
            if (!field) return;

            const countElement = document.getElementById(fieldId + '-count');
            if (!countElement) return;

            const currentLength = field.value.length;
            countElement.textContent = currentLength;

            // Pastikan class warna selalu tetap (tidak berubah menjadi merah)
            // Hapus semua kemungkinan class warna merah/amber
            const colorClasses = ['text-red-600', 'text-red-400', 'text-red-700', 'text-red-300', 'text-red-500', 'text-red-800', 'text-amber-600', 'text-amber-500', 'font-semibold'];
            colorClasses.forEach(cls => countElement.classList.remove(cls));

            // Pastikan class warna default selalu ada
            countElement.classList.remove('text-slate-400', 'dark:text-slate-500', 'text-slate-500');
            countElement.classList.add('text-slate-400', 'dark:text-slate-500');

            // Pastikan tidak ada style inline yang mengubah warna
            countElement.style.color = '';
            countElement.style.removeProperty('color');
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

        // Reset sidebar scroll position to 0 on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('aside');
            if (sidebar) {
                sidebar.scrollTop = 0;
                // Clear any saved scroll position
                sessionStorage.removeItem('admin_sidebar_scroll_position');
            }
        });

        // SPA Navigation removed - Using default Laravel navigation

        // Auto-reload setelah berhasil menyimpan/publish/edit berita/artikel
        document.addEventListener('DOMContentLoaded', function() {
            const statusMessage = @json(session('status'));
            const shouldReload = @json(session('reload', false));

            if (statusMessage) {
                // Cek apakah pesan sukses untuk berita/artikel
                const isPostSuccess = /berhasil (dipublikasikan|disimpan|diperbarui|dinonaktifkan|dihapus)/i.test(statusMessage) &&
                    (/berita|artikel/i.test(statusMessage));

                // Cek apakah pesan sukses untuk banner promosi
                const isPromosiSuccess = /banner promosi berhasil/i.test(statusMessage);

                // Cek apakah pesan sukses untuk pengumuman
                const isPengumumanSuccess = /pengumuman berhasil/i.test(statusMessage);

                if (isPostSuccess || (isPromosiSuccess && shouldReload) || (isPengumumanSuccess && shouldReload)) {
                    // Reload otomatis setelah 1.5 detik
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                }
            }

            // Jika ada flag reload dari session, reload halaman
            @if(session('reload'))
            setTimeout(function() {
                window.location.reload();
            }, 1500);
            @endif
        });

    </script>
</body>
</html>
