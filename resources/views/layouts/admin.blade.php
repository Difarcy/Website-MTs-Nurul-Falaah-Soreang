<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin')</title>

    <!-- Favicon Admin - Selalu menggunakan icon default, tidak mengikuti logo yang diupload -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23ffffff' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">
    <link rel="icon" type="image/svg+xml" media="(prefers-color-scheme: light)" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000000' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    
    @stack('styles')

    <style>
        body {
            font-family: 'Archivo Narrow', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 15px;
            font-weight: 600;
        }

        /* Custom scrollbar untuk sidebar - benar-benar tersembunyi tapi tetap bisa scroll */
        aside {
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none; /* Firefox - hide scrollbar */
            -ms-overflow-style: none; /* IE dan Edge - hide scrollbar */
        }

        /* Webkit browsers (Chrome, Safari, Edge) - hide scrollbar tapi tetap bisa scroll */
        aside::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Edge - completely hide scrollbar */
            width: 0px;
            background: transparent;
        }

        /* Pastikan header tidak ikut scroll */
        aside > div:first-child {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Summernote dark mode support - Comprehensive */
        @media (prefers-color-scheme: dark) {
            /* Editor Frame */
            .note-editor.note-frame {
                background-color: #0f172a !important;
                border-color: #1f2937 !important;
            }
            
            /* Editing Area */
            .note-editor.note-frame .note-editing-area {
                background-color: #0f172a !important;
            }
            
            .note-editor.note-frame .note-editing-area .note-editable {
                background-color: #0f172a !important;
                color: #e2e8f0 !important;
            }
            
            .note-editor.note-frame .note-editing-area .note-editable:focus {
                background-color: #0f172a !important;
                color: #e2e8f0 !important;
            }
            
            /* Toolbar */
            .note-editor.note-frame .note-toolbar {
                background-color: #0b1220 !important;
                border-color: #1f2937 !important;
                border-bottom-color: #1f2937 !important;
            }
            
            .note-editor.note-frame .note-toolbar .note-btn {
                color: #e2e8f0 !important;
                background-color: transparent !important;
                border-color: transparent !important;
            }
            
            .note-editor.note-frame .note-toolbar .note-btn:hover,
            .note-editor.note-frame .note-toolbar .note-btn:focus {
                background-color: #1e293b !important;
                border-color: #334155 !important;
            }
            
            .note-editor.note-frame .note-toolbar .note-btn.active {
                background-color: #1e293b !important;
                border-color: #10b981 !important;
            }
            
            .note-editor.note-frame .note-toolbar .note-btn-group {
                border-color: #1f2937 !important;
            }
            
            .note-editor.note-frame .note-toolbar .note-btn-group .note-btn {
                border-color: #1f2937 !important;
            }
            
            /* Dropdown Menu */
            .note-dropdown-menu {
                background-color: #0b1220 !important;
                border-color: #1f2937 !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5) !important;
            }
            
            .note-dropdown-menu > li > a {
                color: #e2e8f0 !important;
            }
            
            .note-dropdown-menu > li > a:hover,
            .note-dropdown-menu > li > a:focus {
                background-color: #1e293b !important;
                color: #e2e8f0 !important;
            }
            
            .note-dropdown-menu > li.divider {
                background-color: #1f2937 !important;
            }
            
            /* Modal - Insert Image/Video */
            .note-modal {
                background-color: #0f172a !important;
                border-color: #1f2937 !important;
            }
            
            .note-modal .modal-header {
                background-color: #0b1220 !important;
                border-bottom-color: #1f2937 !important;
                color: #e2e8f0 !important;
            }
            
            .note-modal .modal-header .close {
                color: #e2e8f0 !important;
                opacity: 0.8;
            }
            
            .note-modal .modal-header .close:hover {
                opacity: 1;
                color: #ffffff !important;
            }
            
            .note-modal .modal-body {
                background-color: #0f172a !important;
                color: #e2e8f0 !important;
            }
            
            .note-modal .modal-footer {
                background-color: #0b1220 !important;
                border-top-color: #1f2937 !important;
            }
            
            /* Form Controls in Modal */
            .note-modal .form-control,
            .note-modal input[type="text"],
            .note-modal input[type="url"],
            .note-modal input[type="file"],
            .note-modal textarea,
            .note-modal select {
                background-color: #1e293b !important;
                border-color: #334155 !important;
                color: #e2e8f0 !important;
            }
            
            .note-modal .form-control:focus,
            .note-modal input[type="text"]:focus,
            .note-modal input[type="url"]:focus,
            .note-modal textarea:focus,
            .note-modal select:focus {
                background-color: #1e293b !important;
                border-color: #10b981 !important;
                color: #e2e8f0 !important;
                box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
            }
            
            .note-modal .form-control::placeholder {
                color: #64748b !important;
            }
            
            /* Buttons in Modal */
            .note-modal .btn {
                background-color: #1e293b !important;
                border-color: #334155 !important;
                color: #e2e8f0 !important;
            }
            
            .note-modal .btn:hover,
            .note-modal .btn:focus {
                background-color: #334155 !important;
                border-color: #475569 !important;
                color: #e2e8f0 !important;
            }
            
            .note-modal .btn-primary {
                background-color: #10b981 !important;
                border-color: #10b981 !important;
                color: white !important;
            }
            
            .note-modal .btn-primary:hover,
            .note-modal .btn-primary:focus {
                background-color: #059669 !important;
                border-color: #059669 !important;
                color: white !important;
            }
            
            .note-modal .btn-secondary {
                background-color: #475569 !important;
                border-color: #475569 !important;
                color: #e2e8f0 !important;
            }
            
            .note-modal .btn-secondary:hover {
                background-color: #64748b !important;
                border-color: #64748b !important;
            }
            
            /* Labels in Modal */
            .note-modal label {
                color: #e2e8f0 !important;
            }
            
            /* Help Text */
            .note-modal .help-block,
            .note-modal .help-block-note {
                color: #94a3b8 !important;
            }
            
            /* Code View */
            .note-editor.note-frame .note-editing-area .note-codable {
                background-color: #0f172a !important;
                color: #e2e8f0 !important;
            }
            
            /* Popover */
            .note-popover {
                background-color: #0b1220 !important;
                border-color: #1f2937 !important;
            }
            
            .note-popover .popover-content {
                background-color: #0b1220 !important;
                color: #e2e8f0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 h-screen fixed left-0 top-0 overflow-y-auto">
            <div class="px-4 py-2 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
                <div class="flex items-center gap-1.5">
                    <div class="flex items-center justify-center w-12 h-12 bg-white dark:bg-slate-900 rounded-lg">
                        <svg class="w-7 h-7 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Panel Admin</p>
                    </div>
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 text-base font-semibold">
                     <a href="{{ route('admin.dashboard') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Dashboard</span>
                </a>
                     <a href="{{ route('admin.berita.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.berita.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Berita</span>
                </a>
                     <a href="{{ route('admin.artikel.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.artikel.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Artikel</span>
                </a>
                     <a href="{{ route('admin.pengumuman.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.pengumuman.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Pengumuman</span>
                </a>
                     <a href="{{ route('admin.agenda.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.agenda.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Agenda</span>
                </a>
                     <a href="{{ route('admin.foto-kegiatan.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.foto-kegiatan.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Galeri</span>
                </a>
                     <a href="{{ route('admin.prestasi-siswa.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.prestasi-siswa.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Prestasi</span>
                </a>
                     <a href="{{ route('admin.comments.index') }}"
                         class="flex items-center justify-between gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.comments.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Komentar</span>
                    @php
                        $unreadCount = \App\Models\Comment::where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full" title="{{ $unreadCount }} komentar belum dibaca">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>
                     <a href="{{ route('admin.info-sekolah.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.info-sekolah.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Profil Sekolah</span>
                </a>
                     <a href="{{ route('admin.kontak.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.kontak.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Kontak</span>
                </a>
                     <a href="{{ route('admin.banners.index') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Banner</span>
                </a>
                     <a href="{{ route('admin.settings.logo') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.logo') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Logo</span>
                </a>
                     <a href="{{ route('admin.settings.top-bar') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.settings.top-bar*') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Top Bar</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col lg:ml-64">
            <header class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 px-4 sm:px-6 py-4 flex items-center justify-between">
                <div class="lg:hidden flex items-center gap-1.5">
                    <div class="flex items-center justify-center w-12 h-12 bg-white dark:bg-slate-900 rounded-lg">
                        <svg class="w-7 h-7 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-bold tracking-tight dark:text-white">Panel Admin</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('admin.change-username') }}" data-spa-link class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Ubah Username
                    </a>
                    <a href="{{ route('admin.change-password') }}" data-spa-link class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Ubah Password
                    </a>
                    <a href="#" data-spa-link class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Bantuan
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:block" id="logout-form">
                        @csrf
                        <button type="button" id="logout-btn" class="inline-flex items-center justify-center px-4 py-1.5 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors">
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

    <!-- Modal Konfirmasi Logout -->
    <div id="logout-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Konfirmasi Keluar</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Apakah Anda yakin ingin keluar dari panel admin?</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="logout-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                    <button type="button" id="logout-confirm-btn" class="px-6 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors min-w-[100px]">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                });

                // Submit form saat klik Keluar
                logoutConfirmBtn.addEventListener('click', function() {
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
                    <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation()">
                        <img id="previewImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain pointer-events-none">
                        <button type="button" class="close-modal-btn fixed top-4 right-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors z-10 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);

                // Setup event listeners
                const closeBtn = modal.querySelector('.close-modal-btn');
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.closeImagePreview(e);
                    return false;
                }, true);

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

            // Jika banner promosi, tampilkan dengan ukuran yang sesuai
            if (imageAlt && imageAlt.toLowerCase().includes('promosi')) {
                img.className = 'pointer-events-none';
                img.style.width = '1920px';
                img.style.height = '600px';
                img.style.maxWidth = '1920px';
                img.style.maxHeight = '600px';
                img.style.objectFit = 'cover';
            } else {
                // Untuk banner biasa, tampilkan full size
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

        // Simpan dan pulihkan posisi scroll sidebar
        (function() {
            const SIDEBAR_SCROLL_KEY = 'admin_sidebar_scroll_position';
            const sidebar = document.querySelector('aside');

            if (!sidebar) return;

            // Fungsi untuk menyimpan posisi scroll
            function saveScrollPosition() {
                sessionStorage.setItem(SIDEBAR_SCROLL_KEY, sidebar.scrollTop.toString());
            }

            // Pulihkan posisi scroll saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                const savedScrollPosition = sessionStorage.getItem(SIDEBAR_SCROLL_KEY);
                if (savedScrollPosition !== null) {
                    // Gunakan requestAnimationFrame untuk memastikan DOM sudah selesai render
                    requestAnimationFrame(function() {
                        sidebar.scrollTop = parseInt(savedScrollPosition, 10);
                    });
                }
            });

            // Simpan posisi scroll sebelum navigasi (untuk semua link di sidebar)
            const sidebarNav = sidebar.querySelector('nav');
            if (sidebarNav) {
                // Handle klik pada semua link
                sidebarNav.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (link && link.href && !link.href.includes('#')) {
                        // Simpan posisi scroll sebelum navigasi
                        saveScrollPosition();
                    }
                }, true); // Gunakan capture phase untuk menangkap sebelum event lain
            }

            // Simpan posisi scroll saat user scroll (update real-time)
            let scrollTimeout;
            sidebar.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function() {
                    saveScrollPosition();
                }, 150); // Debounce untuk performa
            });

            // Simpan posisi scroll saat sebelum unload (backup)
            window.addEventListener('beforeunload', function() {
                saveScrollPosition();
            });
        })();

        // SPA Navigation System (Next.js style)
        (function() {
            let isNavigating = false;
            let currentPath = window.location.pathname + window.location.search;

            // Function to show loading state
            function showLoading() {
                // No loading overlay - instant navigation
            }

            // Function to hide loading state
            function hideLoading() {
                // No loading overlay to hide
            }

            // Function to load content via AJAX
            async function loadContent(url) {
                if (isNavigating) return;
                isNavigating = true;

                try {
                    showLoading();

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                            'Cache-Control': 'no-cache'
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const html = await response.text();

                    // Parse the HTML to extract the content
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update page title
                    const newTitle = doc.querySelector('title');
                    if (newTitle) {
                        document.title = newTitle.textContent;
                    }

                    // Update main content
                    const newMainContent = doc.querySelector('.admin-main');
                    const currentMainContent = document.querySelector('.admin-main');

                    if (newMainContent && currentMainContent) {
                        // Preserve any existing event listeners by doing a more careful replacement
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = newMainContent.innerHTML;

                        // Copy over the content
                        currentMainContent.innerHTML = tempDiv.innerHTML;

                        // Re-initialize any scripts that might be in the content
                        const scripts = currentMainContent.querySelectorAll('script');
                        scripts.forEach(script => {
                            if (script.textContent) {
                                try {
                                    // Execute script in global context
                                    (function() {
                                        eval(script.textContent);
                                    }).call(window);
                                } catch (e) {
                                    console.warn('Error executing inline script:', e);
                                }
                            } else if (script.src) {
                                // Handle external scripts by creating a new script element
                                const newScript = document.createElement('script');
                                newScript.src = script.src;
                                newScript.async = false; // Ensure synchronous loading for proper initialization
                                document.head.appendChild(newScript);
                            }
                        });
                    }

                    // Update URL without reloading
                    window.history.pushState({ path: url }, '', url);
                    currentPath = url;

                    // Update active menu state
                    updateActiveMenuState(url);

                    // Scroll to top of content
                    window.scrollTo(0, 0);

                    // Re-initialize dynamic elements
                    initializeDynamicElements();

                } catch (error) {
                    console.error('Error loading content:', error);
                    // Fallback to normal navigation
                    window.location.href = url;
                } finally {
                    hideLoading();
                    isNavigating = false;
                }
            }

            // Function to update active menu state
            function updateActiveMenuState(currentUrl) {
                try {
                    const sidebarLinks = document.querySelectorAll('aside nav a');

                    // Remove active state from all links
                    sidebarLinks.forEach(link => {
                        if (link && link.classList) {
                            link.classList.remove('bg-slate-200', 'text-slate-900', 'font-semibold', 'dark:bg-slate-700', 'dark:text-white');
                            link.classList.add('text-slate-900', 'hover:bg-slate-200', 'dark:text-slate-400', 'dark:hover:bg-slate-700', 'dark:hover:text-white');
                        }
                    });

                    // Find and activate the current link
                    sidebarLinks.forEach(link => {
                        if (link && link.href && link.classList) {
                            try {
                                const linkUrl = new URL(link.href);
                                const currentUrlObj = new URL(currentUrl);

                                // Check if the link matches the current URL
                                if (linkUrl.pathname === currentUrlObj.pathname) {
                                    link.classList.remove('text-slate-900', 'hover:bg-slate-200', 'dark:text-slate-400', 'dark:hover:bg-slate-700', 'dark:hover:text-white');
                                    link.classList.add('bg-slate-200', 'text-slate-900', 'font-semibold', 'dark:bg-slate-700', 'dark:text-white');
                                }
                            } catch (urlError) {
                                console.warn('Error parsing URL in updateActiveMenuState:', urlError);
                            }
                        }
                    });
                } catch (error) {
                    console.warn('Error in updateActiveMenuState:', error);
                }
            }

            // Function to initialize dynamic elements after content load
            function initializeDynamicElements() {
                try {
                    // Re-initialize character counters
                    document.querySelectorAll('[maxlength]').forEach(function(field) {
                        if (field) {
                            const fieldId = field.id;
                            const maxLength = parseInt(field.getAttribute('maxlength'));

                            if (fieldId && maxLength && !field.hasAttribute('data-char-counter-initialized')) {
                                field.setAttribute('data-char-counter-initialized', 'true');
                                field.addEventListener('input', function() {
                                    updateCharCount(fieldId, maxLength);
                                });
                            }
                        }
                    });

                    // Re-initialize any modal handlers or other dynamic content
                    // Add more initialization code here as needed
                } catch (error) {
                    console.warn('Error in initializeDynamicElements:', error);
                }
            }

            // Handle SPA navigation clicks (sidebar and header buttons)
            document.addEventListener('click', function(e) {
                try {
                    // Check for sidebar navigation links
                    const sidebarLink = e.target.closest('aside nav a');
                    // Check for header SPA links
                    const headerLink = e.target.closest('[data-spa-link]');

                    const link = sidebarLink || headerLink;

                    if (link && link.href && !link.href.includes('#')) {
                        // Check if it's an external link or different domain
                        const linkUrl = new URL(link.href);
                        const currentUrl = new URL(window.location.href);

                        if (linkUrl.origin === currentUrl.origin) {
                            e.preventDefault();

                            // Save sidebar scroll position before navigation (only for sidebar links)
                            if (sidebarLink) {
                                const sidebar = document.querySelector('aside');
                                if (sidebar) {
                                    sessionStorage.setItem('admin_sidebar_scroll_position', sidebar.scrollTop.toString());
                                }
                            }

                            loadContent(link.href);
                        }
                    }
                } catch (error) {
                    console.warn('Error in SPA navigation click handler:', error);
                    // Continue with default behavior if SPA navigation fails
                }
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.path) {
                    loadContent(e.state.path);
                } else {
                    // Update active state for current URL
                    updateActiveMenuState(window.location.href);
                }
            });

            // Handle form submissions that should trigger SPA navigation
            document.addEventListener('submit', function(e) {
                const form = e.target;
                const action = form.action || window.location.href;

                // Only intercept forms that are GET requests (navigation forms)
                if (form.method.toUpperCase() === 'GET') {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData);
                    const url = action + (params.toString() ? '?' + params.toString() : '');
                    loadContent(url);
                }
            });

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                initializeDynamicElements();
                updateActiveMenuState(window.location.href);
            });
        })();

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
