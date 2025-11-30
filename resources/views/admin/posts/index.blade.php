@extends('layouts.admin')

@section('title', 'Berita & Artikel')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Berita & Artikel</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tambah, ubah, dan kelola semua konten informasi sekolah.</p>
            </div>
            <div class="flex items-center gap-3">
                @if(request()->hasAny(['type', 'status', 'q', 'sort', 'order', 'view']))
                    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                @endif
                @if($posts->total() > 0)
                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800">
                        + Tambah Konten
                    </a>
                @endif
            </div>
        </div>

        <!-- Toolbar: Pencarian, Filter Tipe, Filter Status, Clear, Sort, View -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3 flex-1 flex-wrap">
                <!-- Pencarian -->
                <form method="GET" action="{{ route('admin.posts.index') }}" id="search-form" class="flex-1 max-w-md">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="q" 
                            id="search-input"
                            value="{{ request('q') }}" 
                            placeholder="Cari judul atau ringkasan..." 
                            class="w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-green-600 focus:border-green-600"
                            onkeypress="if(event.key === 'Enter') { event.preventDefault(); submitSearch(); }"
                            oninput="autoSearch()"
                        >
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request('view'))
                            <input type="hidden" name="view" value="{{ request('view') }}">
                        @endif
                        @if(request('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                    </div>
                </form>
                
                <!-- Filter Tipe -->
                <div class="relative">
                    <select id="filter-type" onchange="applyFilter()" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pr-8 text-sm font-semibold focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer min-w-[140px]">
                        <option value="">Semua Tipe</option>
                        <option value="berita" @selected(request('type') === 'berita')>Berita</option>
                        <option value="artikel" @selected(request('type') === 'artikel')>Artikel</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Filter Status -->
                <div class="relative">
                    <select id="filter-status" onchange="applyFilter()" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pr-8 text-sm font-semibold focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer min-w-[160px]">
                        <option value="">Semua Status</option>
                        <option value="published" @selected(request('status') === 'published')>Terpublikasi</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <!-- Sort Dropdown -->
                <div class="relative">
                    <select id="sort-select" onchange="applySort()" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pr-8 text-sm font-semibold focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer">
                        <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                        <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                        <option value="title_asc" @selected(request('sort') === 'title_asc')>Judul A-Z</option>
                        <option value="title_desc" @selected(request('sort') === 'title_desc')>Judul Z-A</option>
                        <option value="published_asc" @selected(request('sort') === 'published_asc')>Tanggal Publikasi (Awal)</option>
                        <option value="published_desc" @selected(request('sort') === 'published_desc')>Tanggal Publikasi (Akhir)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <!-- View Toggle -->
                <div class="flex items-center gap-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-1">
                    <button id="view-table" onclick="setView('table')" class="p-2 rounded {{ request('view', 'table') === 'table' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'text-slate-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }} transition-colors" title="Tampilan Tabel">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    <button id="view-grid" onclick="setView('grid')" class="p-2 rounded {{ request('view') === 'grid' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'text-slate-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700' }} transition-colors" title="Tampilan Grid">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <script>
            // Auto-search dengan debounce dan AJAX (tidak reload halaman)
            let searchTimeout = null;
            let isSubmitting = false;
            
            function autoSearch() {
                // Clear timeout sebelumnya
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                
                // Set timeout baru (500ms setelah user berhenti mengetik)
                searchTimeout = setTimeout(function() {
                    submitSearchAjax();
                }, 500);
            }
            
            function submitSearch() {
                // Submit dengan form (reload halaman) - untuk Enter key
                const form = document.getElementById('search-form');
                if (form && !isSubmitting) {
                    isSubmitting = true;
                    form.submit();
                }
            }
            
            function submitSearchAjax() {
                // Submit dengan AJAX (tidak reload halaman) - untuk auto-search
                const form = document.getElementById('search-form');
                const searchInput = document.getElementById('search-input');
                if (!form || !searchInput || isSubmitting) return;
                
                isSubmitting = true;
                
                // Build URL dengan semua parameter
                const formData = new FormData(form);
                const params = new URLSearchParams();
                
                // Add all form data
                for (const [key, value] of formData.entries()) {
                    if (value) {
                        params.set(key, value);
                    }
                }
                
                // Add current filter values
                const filterType = document.getElementById('filter-type');
                const filterStatus = document.getElementById('filter-status');
                const sortSelect = document.getElementById('sort-select');
                
                if (filterType && filterType.value) {
                    params.set('type', filterType.value);
                }
                if (filterStatus && filterStatus.value) {
                    params.set('status', filterStatus.value);
                }
                if (sortSelect && sortSelect.value) {
                    params.set('sort', sortSelect.value);
                }
                
                // Preserve view
                @if(request('view'))
                    params.set('view', '{{ request('view') }}');
                @endif
                
                // Fetch dengan AJAX
                const url = '{{ route('admin.posts.index') }}?' + params.toString();
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Parse HTML response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Update content area (posts container)
                    const newContent = doc.getElementById('posts-container');
                    const currentContent = document.getElementById('posts-container');
                    
                    if (newContent && currentContent) {
                        currentContent.innerHTML = newContent.innerHTML;
                    }
                    
                    // Update URL tanpa reload
                    window.history.pushState({}, '', url);
                    
                    isSubmitting = false;
                    
                    // Keep focus on input dan set cursor ke akhir
                    setTimeout(function() {
                        searchInput.focus();
                        const len = searchInput.value.length;
                        searchInput.setSelectionRange(len, len);
                    }, 10);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    isSubmitting = false;
                    // Fallback to form submit if AJAX fails
                    submitSearch();
                });
            }
            
            function applyFilter() {
                const typeValue = document.getElementById('filter-type').value;
                const statusValue = document.getElementById('filter-status').value;
                const url = new URL(window.location.href);
                
                if (typeValue) {
                    url.searchParams.set('type', typeValue);
                } else {
                    url.searchParams.delete('type');
                }
                
                if (statusValue) {
                    url.searchParams.set('status', statusValue);
                } else {
                    url.searchParams.delete('status');
                }
                
                // Preserve other parameters
                const searchInput = document.getElementById('search-input');
                if (searchInput && searchInput.value) {
                    url.searchParams.set('q', searchInput.value);
                } else {
                    url.searchParams.delete('q');
                }
                @if(request('sort'))
                    url.searchParams.set('sort', '{{ request('sort') }}');
                @endif
                @if(request('view'))
                    url.searchParams.set('view', '{{ request('view') }}');
                @endif
                
                window.location.href = url.toString();
            }

            function applySort() {
                const sortValue = document.getElementById('sort-select').value;
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortValue);
                // Preserve other parameters
                @if(request('q'))
                    url.searchParams.set('q', '{{ request('q') }}');
                @endif
                @if(request('type'))
                    url.searchParams.set('type', '{{ request('type') }}');
                @endif
                @if(request('status'))
                    url.searchParams.set('status', '{{ request('status') }}');
                @endif
                @if(request('view'))
                    url.searchParams.set('view', '{{ request('view') }}');
                @endif
                window.location.href = url.toString();
            }

            function setView(view) {
                const url = new URL(window.location.href);
                if (view === 'table') {
                    url.searchParams.delete('view');
                } else {
                    url.searchParams.set('view', view);
                }
                // Preserve other parameters
                @if(request('q'))
                    url.searchParams.set('q', '{{ request('q') }}');
                @endif
                @if(request('type'))
                    url.searchParams.set('type', '{{ request('type') }}');
                @endif
                @if(request('status'))
                    url.searchParams.set('status', '{{ request('status') }}');
                @endif
                @if(request('sort'))
                    url.searchParams.set('sort', '{{ request('sort') }}');
                @endif
                window.location.href = url.toString();
            }
        </script>

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden" id="posts-container">
            @if(request('view') === 'grid')
                <!-- Grid View -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($posts as $post)
                        <div class="bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            @if($post->thumbnail_path)
                                <div class="w-full h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $post->thumbnail_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $post->type === 'berita' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' }}">
                                        {{ ucfirst($post->type) }}
                                    </span>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $post->status === 'published' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' }}">
                                        {{ $post->status === 'published' ? 'Publikasi' : 'Draft' }}
                                    </span>
                                </div>
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 line-clamp-2">{{ $post->title }}</h3>
                                @if($post->excerpt)
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 line-clamp-2">{{ $post->excerpt }}</p>
                                @endif
                                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                                    {{ $post->published_at ? $post->published_at->format('d M Y') : 'Belum dijadwalkan' }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="flex-1 text-center px-3 py-2 text-xs font-semibold text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konten ini?');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-2 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                @if(request('q'))
                                    {{-- Jika ada pencarian (q) --}}
                                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Hasil Pencarian Tidak Ditemukan</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                                        Tidak ada konten yang sesuai dengan pencarian "<strong>{{ request('q') }}</strong>"
                                    </p>
                                    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 dark:bg-slate-700 text-white font-bold rounded-lg hover:bg-slate-800 dark:hover:bg-slate-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Kosongkan Pencarian
                                    </a>
                                @elseif(request()->hasAny(['type', 'status']))
                                    {{-- Jika hanya filter tipe atau status (tanpa pencarian) --}}
                                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Konten</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                                        @if(request('type'))
                                            Belum ada konten dengan tipe "<strong>{{ ucfirst(request('type')) }}</strong>"
                                        @elseif(request('status'))
                                            Belum ada konten dengan status "<strong>{{ request('status') === 'published' ? 'Terpublikasi' : 'Draft' }}</strong>"
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Konten
                                    </a>
                                @else
                                    {{-- Jika tidak ada filter sama sekali --}}
                                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Konten</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Mulai dengan menambahkan berita atau artikel baru</p>
                                    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Konten Pertama
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
            @else
                <!-- Table View -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-700 text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-700 text-left text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Dijadwalkan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($posts as $post)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $post->title }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $post->excerpt }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300 capitalize">{{ $post->type }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $post->status === 'published' ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' }}">
                                        {{ $post->status === 'published' ? 'Publikasi' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                    {{ $post->published_at ? $post->published_at->format('d M Y H:i') : 'Belum dijadwalkan' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-semibold text-blue-700 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Edit</a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konten ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12">
                                    <div class="text-center">
                                        @if(request('q'))
                                            {{-- Jika ada pencarian (q) --}}
                                            <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Hasil Pencarian Tidak Ditemukan</h3>
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                                                Tidak ada konten yang sesuai dengan pencarian "<strong>{{ request('q') }}</strong>"
                                            </p>
                                            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 dark:bg-slate-700 text-white font-bold rounded-lg hover:bg-slate-800 dark:hover:bg-slate-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Kosongkan Pencarian
                                            </a>
                                        @elseif(request()->hasAny(['type', 'status']))
                                            {{-- Jika hanya filter tipe atau status (tanpa pencarian) --}}
                                            <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Konten</h3>
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                                                @if(request('type'))
                                                    Belum ada konten dengan tipe "<strong>{{ ucfirst(request('type')) }}</strong>"
                                                @elseif(request('status'))
                                                    Belum ada konten dengan status "<strong>{{ request('status') === 'published' ? 'Terpublikasi' : 'Draft' }}</strong>"
                                                @endif
                                            </p>
                                            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Tambah Konten
                                            </a>
                                        @else
                                            {{-- Jika tidak ada filter sama sekali --}}
                                            <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Konten</h3>
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Mulai dengan menambahkan berita atau artikel baru</p>
                                            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Tambah Konten Pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            @endif
            <div class="px-4 py-3 border-t border-gray-100 dark:border-slate-700">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    @if(session('status') && str_contains(session('status'), 'dipublikasikan'))
        <script>
            // Auto-refresh admin panel setelah publish berhasil
            document.addEventListener('DOMContentLoaded', function() {
                // Tunggu 2 detik untuk menampilkan pesan sukses, lalu refresh
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            });
        </script>
    @endif
@endsection

