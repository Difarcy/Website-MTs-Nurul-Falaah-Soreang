@php
    $siteSettings = \App\Models\SiteSetting::first();
    $logoPath = $siteSettings && $siteSettings->logo_path ? ('storage/' . $siteSettings->logo_path) : 'img/logo.png';
    // Cache busting: untuk storage gunakan updated_at, untuk file default gunakan filemtime
    if ($siteSettings && $siteSettings->logo_path) {
        $logoVersion = $siteSettings->updated_at ? $siteSettings->updated_at->timestamp : time();
    } else {
        $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
    }
    $logoSrc = asset($logoPath) . ($logoVersion ? '?v=' . $logoVersion : '');
@endphp
<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl">
        <!-- Header Normal -->
        <div id="header-normal" class="flex items-center justify-between h-28">
            <!-- Logo dan Nama Sekolah -->
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <img
                        src="{{ $logoSrc }}"
                        alt="Logo MTs Nurul Falaah Soreang"
                        class="h-12 w-12 sm:h-14 sm:w-14 object-contain shrink-0"
                    >
                    <div class="flex flex-col">
                        <span class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight whitespace-nowrap" style="font-family: 'Dosis', sans-serif;">MTs Nurul Falaah</span>
                        <span class="text-xl sm:text-2xl font-bold text-gray-900 whitespace-nowrap" style="font-family: 'Dosis', sans-serif;">Soreang</span>
                    </div>
                </a>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex items-center gap-2 sm:gap-3 md:gap-4 lg:gap-5" style="font-family: 'Dosis', sans-serif;">
                <a
                    href="{{ route('home') }}"
                    class="text-gray-700 hover:text-green-700 transition-colors duration-200 font-bold px-2 sm:px-3 py-2 text-xs sm:text-sm uppercase {{ request()->routeIs('home') ? 'text-green-700 border-b-2 border-green-700' : 'hover:border-b-2 hover:border-green-700' }}"
                >
                    BERANDA
                </a>
                <!-- Menu PROFIL dengan Dropdown -->
                <div class="relative group" id="profil-dropdown">
                    <button
                        class="text-gray-700 hover:text-green-700 transition-colors duration-200 font-bold px-2 sm:px-3 py-2 text-xs sm:text-sm uppercase flex items-center gap-1 {{ (request()->routeIs('profil.*') || request()->routeIs('profil')) && !request()->routeIs('profil.kepala-sekolah-guru') ? 'text-green-700 border-b-2 border-green-700' : 'hover:border-b-2 hover:border-green-700' }}"
                        id="profil-toggle"
                    >
                        PROFIL
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="profil-dropdown-menu" class="absolute top-full left-0 mt-2 w-56 md:w-64 bg-white dark:bg-slate-800 shadow-lg border border-gray-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible md:group-hover:opacity-100 md:group-hover:visible transition-all duration-200 z-50" style="border-radius: 0;">
                        <div class="py-2">
                            <a href="{{ route('profil') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('profil') && !request()->routeIs('profil.*') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Tentang Sekolah
                            </a>
                            <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('profil.visi-misi') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Visi & Misi
                            </a>
                            <a href="{{ route('profil.struktur-organisasi') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('profil.struktur-organisasi') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Struktur Organisasi
                            </a>
                            <a href="{{ route('profil.prestasi') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('profil.prestasi') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Prestasi Siswa
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Menu INFORMASI dengan Dropdown -->
                <div class="relative group" id="informasi-dropdown">
                    <button
                        class="text-gray-700 hover:text-green-700 transition-colors duration-200 font-bold px-2 sm:px-3 py-2 text-xs sm:text-sm uppercase flex items-center gap-1 {{ request()->routeIs('informasi.*') || request()->routeIs('pengumuman') ? 'text-green-700 border-b-2 border-green-700' : 'hover:border-b-2 hover:border-green-700' }}"
                        id="informasi-toggle"
                    >
                        INFORMASI
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="informasi-dropdown-menu" class="absolute top-full left-0 mt-2 w-56 md:w-64 bg-white dark:bg-slate-800 shadow-lg border border-gray-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible md:group-hover:opacity-100 md:group-hover:visible transition-all duration-200 z-50" style="border-radius: 0;">
                        <div class="py-2">
                            <a href="{{ route('informasi.berita') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('informasi.berita') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Berita
                            </a>
                            <a href="{{ route('informasi.artikel') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('informasi.artikel') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Artikel
                            </a>
                            <a href="{{ route('informasi.pengumuman') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('informasi.pengumuman') || request()->routeIs('pengumuman') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Pengumuman
                            </a>
                            <a href="{{ route('informasi.agenda') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('informasi.agenda') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Agenda
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Menu GALERI dengan Dropdown -->
                <div class="relative group" id="galeri-dropdown">
                    <button
                        class="text-gray-700 hover:text-green-700 transition-colors duration-200 font-bold px-2 sm:px-3 py-2 text-xs sm:text-sm uppercase flex items-center gap-1 {{ request()->routeIs('galeri.*') || request()->routeIs('galeri') ? 'text-green-700 border-b-2 border-green-700' : 'hover:border-b-2 hover:border-green-700' }}"
                        id="galeri-toggle"
                    >
                        GALERI
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="galeri-dropdown-menu" class="absolute top-full left-0 mt-2 w-56 md:w-64 bg-white dark:bg-slate-800 shadow-lg border border-gray-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible md:group-hover:opacity-100 md:group-hover:visible transition-all duration-200 z-50" style="border-radius: 0;">
                        <div class="py-2">
                            <a href="{{ route('galeri.foto-kegiatan') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('galeri.foto-kegiatan') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Foto Kegiatan
                            </a>
                            <a href="{{ route('galeri.prestasi-siswa') }}" class="block px-4 py-2 text-sm font-bold text-slate-900 dark:text-white hover:bg-green-700 hover:text-white dark:hover:bg-green-700 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('galeri.prestasi-siswa') ? 'bg-green-700 text-white dark:bg-green-700 dark:text-white' : '' }}">
                                Prestasi Siswa
                            </a>
                        </div>
                    </div>
                </div>
                <a
                    href="{{ route('contact') }}"
                    class="text-gray-700 hover:text-green-700 transition-colors duration-200 font-bold px-2 sm:px-3 py-2 text-xs sm:text-sm uppercase {{ request()->routeIs('contact') ? 'text-green-700 border-b-2 border-green-700' : 'hover:border-b-2 hover:border-green-700' }}"
                >
                    KONTAK
                </a>
                <!-- Icon Search -->
                <button
                    id="search-toggle"
                    class="text-gray-700 dark:text-slate-300 hover:text-green-700 dark:hover:text-green-400 transition-colors duration-200 font-bold p-2 rounded-full"
                    aria-label="Cari"
                >
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </nav>
        </div>

        <!-- Header Search Mode -->
        <div id="header-search" class="hidden flex items-center justify-between h-28">
            <!-- Logo dan Nama Sekolah -->
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <img
                        src="{{ $logoSrc }}"
                        alt="Logo MTs Nurul Falaah Soreang"
                        class="h-12 w-12 sm:h-14 sm:w-14 object-contain shrink-0"
                    >
                    <div class="flex flex-col">
                        <span class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight whitespace-nowrap" style="font-family: 'Dosis', sans-serif;">MTs Nurul Falaah</span>
                        <span class="text-xl sm:text-2xl font-bold text-gray-900 whitespace-nowrap" style="font-family: 'Dosis', sans-serif;">Soreang</span>
                    </div>
                </a>
            </div>

            <!-- Form Pencarian -->
            <div class="flex items-center">
                <div class="relative">
                    <div class="flex items-center gap-1" style="width: 600px; max-width: 90vw;">
                        <div class="flex-1 relative">
                            <input
                                type="text"
                                id="search-input"
                                name="q"
                                placeholder="Cari artikel, berita, atau informasi..."
                                class="w-full px-4 py-2 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-green-700 focus:outline-none text-sm sm:text-base"
                                style="font-family: 'Dosis', sans-serif;"
                                autofocus
                                autocomplete="off"
                            >
                            <!-- Dropdown Hasil Pencarian -->
                            <div id="search-results" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg max-h-96 overflow-y-auto hidden" style="border-radius: 0;">
                                <div id="search-results-list" class="py-1"></div>
                            </div>
                        </div>
                        <button
                            type="button"
                            id="search-close"
                            class="text-gray-700 dark:text-slate-300 hover:text-white dark:hover:text-white p-2 hover:bg-green-700 dark:hover:bg-green-600 rounded-full transition-colors duration-200"
                            aria-label="Tutup pencarian"
                        >
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const headerNormal = document.getElementById('header-normal');
    const headerSearch = document.getElementById('header-search');
    const searchToggle = document.getElementById('search-toggle');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-input');

    // Toggle ke mode search
    searchToggle.addEventListener('click', function() {
        headerNormal.classList.add('hidden');
        headerSearch.classList.remove('hidden');
        // Focus ke input setelah transisi
        setTimeout(function() {
            searchInput.focus();
        }, 100);
    });

    // Kembali ke header normal
    searchClose.addEventListener('click', function() {
        headerSearch.classList.add('hidden');
        headerNormal.classList.remove('hidden');
        searchInput.value = '';
        if (searchResults) {
            searchResults.classList.add('hidden');
        }
        if (searchResultsList) {
            searchResultsList.innerHTML = '';
        }
    });

    // ESC key untuk menutup search
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !headerSearch.classList.contains('hidden')) {
            searchClose.click();
        }
    });

    // Auto-search dengan debounce
    let searchTimeout = null;
    let isSearching = false;
    const searchResults = document.getElementById('search-results');
    const searchResultsList = document.getElementById('search-results-list');

    function performSearch(query) {
        if (!query || query.trim() === '') {
            searchResults.classList.add('hidden');
            searchResultsList.innerHTML = '';
            return;
        }

        if (isSearching) return;
        isSearching = true;

        fetch('{{ route('api.search') }}?q=' + encodeURIComponent(query), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            isSearching = false;
            displaySearchResults(data, query);
        })
        .catch(error => {
            console.error('Search error:', error);
            isSearching = false;
            searchResults.classList.add('hidden');
        });
    }

    function displaySearchResults(results, query) {
        if (!results || results.length === 0) {
            searchResultsList.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada hasil ditemukan</div>';
            searchResults.classList.remove('hidden');
            return;
        }

        let html = '';
        results.forEach(function(item) {
            const typeLabel = item.type === 'berita' ? 'Berita' : 'Artikel';
            const typeColor = item.type === 'berita' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300';
            const url = '{{ url('/informasi') }}/' + item.type + '/' + item.slug;
            const thumbnail = item.thumbnail_path ? '{{ asset('storage') }}/' + item.thumbnail_path : '{{ asset('img/banner1.jpg') }}';
            
            html += `
                <a href="${url}" class="block px-4 py-3 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors border-b border-gray-100 dark:border-slate-700 last:border-b-0">
                    <div class="flex items-start gap-3">
                        <div class="w-16 h-16 flex-shrink-0 overflow-hidden" style="border-radius: 0;">
                            <img src="${thumbnail}" alt="${item.title}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded ${typeColor}" style="border-radius: 0;">
                                    ${typeLabel}
                                </span>
                                <span class="text-xs text-gray-500">${item.published_at || ''}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-1 line-clamp-1">${item.title}</h4>
                            ${item.excerpt ? `<p class="text-xs text-gray-600 dark:text-slate-400 line-clamp-2">${item.excerpt}</p>` : ''}
                        </div>
                    </div>
                </a>
            `;
        });

        searchResultsList.innerHTML = html;
        searchResults.classList.remove('hidden');
    }

        // Auto-search saat mengetik
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                // Clear timeout sebelumnya
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                
                // Jika query kosong, tutup dropdown
                if (query === '') {
                    if (searchResults) {
                        searchResults.classList.add('hidden');
                    }
                    if (searchResultsList) {
                        searchResultsList.innerHTML = '';
                    }
                    return;
                }
                
                // Set timeout baru (500ms setelah user berhenti mengetik)
                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 500);
            });

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (searchResults && !searchResults.classList.contains('hidden')) {
                const searchContainer = document.querySelector('#header-search .relative');
                if (searchContainer && !searchContainer.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            }
        });

        // Tutup dropdown saat ESC
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchResults.classList.add('hidden');
            }
        });
    }

    // Dropdown PROFIL untuk mobile (klik toggle)
    const profilDropdown = document.getElementById('profil-dropdown');
    const profilToggle = document.getElementById('profil-toggle');
    const profilDropdownMenu = document.getElementById('profil-dropdown-menu');
    
    // Toggle dropdown untuk mobile
    if (profilToggle && profilDropdownMenu) {
        profilToggle.addEventListener('click', function(e) {
            // Hanya toggle di mobile (screen kecil)
            if (window.innerWidth < 768) {
                e.preventDefault();
                e.stopPropagation();
                const isOpen = profilDropdownMenu.classList.contains('opacity-100') && profilDropdownMenu.classList.contains('visible');
                if (isOpen) {
                    profilDropdownMenu.classList.remove('opacity-100', 'visible');
                    profilDropdownMenu.classList.add('opacity-0', 'invisible');
                } else {
                    profilDropdownMenu.classList.remove('opacity-0', 'invisible');
                    profilDropdownMenu.classList.add('opacity-100', 'visible');
                }
            }
        });
    }

    // Tutup dropdown saat klik di luar (mobile)
    if (profilDropdown && profilDropdownMenu) {
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768 && !profilDropdown.contains(e.target)) {
                profilDropdownMenu.classList.remove('opacity-100', 'visible');
                profilDropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
    }

    // Dropdown PROGRAM untuk mobile (klik toggle)
    const programDropdown = document.getElementById('program-dropdown');
    const programToggle = document.getElementById('program-toggle');
    const programDropdownMenu = document.getElementById('program-dropdown-menu');
    
    // Toggle dropdown untuk mobile
    if (programToggle && programDropdownMenu) {
        programToggle.addEventListener('click', function(e) {
            // Hanya toggle di mobile (screen kecil)
            if (window.innerWidth < 768) {
                e.preventDefault();
                e.stopPropagation();
                const isOpen = programDropdownMenu.classList.contains('opacity-100') && programDropdownMenu.classList.contains('visible');
                if (isOpen) {
                    programDropdownMenu.classList.remove('opacity-100', 'visible');
                    programDropdownMenu.classList.add('opacity-0', 'invisible');
                } else {
                    programDropdownMenu.classList.remove('opacity-0', 'invisible');
                    programDropdownMenu.classList.add('opacity-100', 'visible');
                }
            }
        });
    }

    // Tutup dropdown saat klik di luar (mobile)
    if (programDropdown && programDropdownMenu) {
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768 && !programDropdown.contains(e.target)) {
                programDropdownMenu.classList.remove('opacity-100', 'visible');
                programDropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
    }

    // Dropdown GALERI untuk mobile (klik toggle)
    const galeriDropdown = document.getElementById('galeri-dropdown');
    const galeriToggle = document.getElementById('galeri-toggle');
    const galeriDropdownMenu = document.getElementById('galeri-dropdown-menu');
    
    // Toggle dropdown untuk mobile
    if (galeriToggle && galeriDropdownMenu) {
        galeriToggle.addEventListener('click', function(e) {
            // Hanya toggle di mobile (screen kecil)
            if (window.innerWidth < 768) {
                e.preventDefault();
                e.stopPropagation();
                const isOpen = galeriDropdownMenu.classList.contains('opacity-100') && galeriDropdownMenu.classList.contains('visible');
                if (isOpen) {
                    galeriDropdownMenu.classList.remove('opacity-100', 'visible');
                    galeriDropdownMenu.classList.add('opacity-0', 'invisible');
                } else {
                    galeriDropdownMenu.classList.remove('opacity-0', 'invisible');
                    galeriDropdownMenu.classList.add('opacity-100', 'visible');
                }
            }
        });
    }

    // Tutup dropdown saat klik di luar (mobile)
    if (galeriDropdown && galeriDropdownMenu) {
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768 && !galeriDropdown.contains(e.target)) {
                galeriDropdownMenu.classList.remove('opacity-100', 'visible');
                galeriDropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
    }

    // Dropdown INFORMASI untuk mobile (klik toggle)
    const informasiDropdown = document.getElementById('informasi-dropdown');
    const informasiToggle = document.getElementById('informasi-toggle');
    const informasiDropdownMenu = document.getElementById('informasi-dropdown-menu');
    
    // Toggle dropdown untuk mobile
    if (informasiToggle && informasiDropdownMenu) {
        informasiToggle.addEventListener('click', function(e) {
            // Hanya toggle di mobile (screen kecil)
            if (window.innerWidth < 768) {
                e.preventDefault();
                e.stopPropagation();
                const isOpen = informasiDropdownMenu.classList.contains('opacity-100') && informasiDropdownMenu.classList.contains('visible');
                if (isOpen) {
                    informasiDropdownMenu.classList.remove('opacity-100', 'visible');
                    informasiDropdownMenu.classList.add('opacity-0', 'invisible');
                } else {
                    informasiDropdownMenu.classList.remove('opacity-0', 'invisible');
                    informasiDropdownMenu.classList.add('opacity-100', 'visible');
                }
            }
        });
    }

    // Tutup dropdown saat klik di luar (mobile)
    if (informasiDropdown && informasiDropdownMenu) {
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768 && !informasiDropdown.contains(e.target)) {
                informasiDropdownMenu.classList.remove('opacity-100', 'visible');
                informasiDropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
    }
});
</script>

