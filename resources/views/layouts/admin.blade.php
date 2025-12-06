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

        /* Hide CKEditor "powered by" / external link if present (non-invasive CSS) */
        /* Ensure this is safe to remove; do not remove if using paid/hosted CKEditor services that require attribution */
        .ck a[href*="ckeditor.com"],
        .ck .ck-editor__branding,
        .ck .ck-powered-by,
        .ck .ck-editor__bottom {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 h-screen fixed left-0 top-0 overflow-y-auto">
            <div class="px-4 pt-3 pb-2 border-b border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800">
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
                     <a href="{{ route('admin.change-username') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.change-username') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Ubah Username</span>
                </a>
                     <a href="{{ route('admin.change-password') }}"
                         class="flex items-center gap-2 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.change-password') ? 'bg-slate-200 text-slate-900 font-semibold dark:bg-slate-700 dark:text-white' : 'text-slate-900 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white' }}">
                    <span>Ubah Password</span>
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
                <div class="flex items-center gap-4 ml-auto">
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
    <div id="logout-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50">
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
                    logoutModal.classList.remove('flex');
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

    @stack('scripts')

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

