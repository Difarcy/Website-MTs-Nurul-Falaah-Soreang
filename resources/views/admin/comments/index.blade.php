@extends('layouts.admin')

@section('title', 'Komentar')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Komentar</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola komentar dari pengunjung website.</p>
            </div>
            <div class="flex items-center gap-3">
                @if($unreadComments > 0)
                    <form action="{{ route('admin.comments.mark-all-read') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Komentar</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-slate-100 mt-1">{{ $totalComments }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $pendingComments }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum Dibaca</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $unreadComments }}</p>
            </div>
        </div>

        <!-- Toolbar: Pencarian, Filter Status, Filter Read, Clear -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3 flex-1 flex-wrap">
                <!-- Pencarian -->
                <form method="GET" action="{{ route('admin.comments.index') }}" id="search-form" class="flex-1 max-w-md">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="q" 
                            id="search-input"
                            value="{{ request('q') }}" 
                            placeholder="Cari nama, email, atau komentar..." 
                            class="w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-green-600 focus:border-green-600"
                            onkeypress="if(event.key === 'Enter') { event.preventDefault(); submitSearch(); }"
                            oninput="autoSearch()"
                        >
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('read'))
                            <input type="hidden" name="read" value="{{ request('read') }}">
                        @endif
                    </div>
                </form>
                
                <!-- Filter Status -->
                <div class="relative">
                    <select id="filter-status" onchange="applyFilter()" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pr-8 text-sm font-semibold focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer min-w-[140px]">
                        <option value="">Semua Status</option>
                        <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                        <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Filter Read -->
                <div class="relative">
                    <select id="filter-read" onchange="applyFilter()" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg px-4 py-2 pr-8 text-sm font-semibold focus:ring-2 focus:ring-green-600 focus:border-green-600 appearance-none cursor-pointer min-w-[140px]">
                        <option value="">Tampilkan Semua</option>
                        <option value="unread" @selected(request('read') === 'unread')>Belum Dibaca</option>
                        <option value="read" @selected(request('read') === 'read')>Sudah Dibaca</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @php
                    $hasActiveFilters = request()->hasAny(['q', 'status', 'read']);
                @endphp
                @if($hasActiveFilters)
                    <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hapus Filter
                    </a>
                @endif
            </div>
        </div>

        <!-- Comments List -->
        <div id="comments-content">
        @if($comments->total() > 0)
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-900 border-b border-gray-200 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Komentar</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Post</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($comments as $comment)
                                <tr class="hover:bg-slate-200 dark:hover:bg-slate-700/50 {{ !$comment->is_read ? 'bg-yellow-50 dark:bg-yellow-900/10' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $comment->name }}</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $comment->email }}</p>
                                                <p class="text-sm text-slate-700 dark:text-slate-300 mt-2 line-clamp-2">{{ $comment->comment }}</p>
                                            </div>
                                            @if(!$comment->is_read)
                                                <span class="px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full">Baru</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('informasi.show', ['type' => $comment->post->type, 'slug' => $comment->post->slug]) }}" target="_blank" class="text-sm text-green-700 dark:text-green-400 hover:underline">
                                            {{ str()->limit($comment->post->title, 40) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($comment->is_approved)
                                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-full">Disetujui</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $comment->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 align-bottom">
                                        <div class="flex flex-col items-end gap-2">
                                            @if(!$comment->is_read)
                                                <form action="{{ route('admin.comments.read', $comment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 text-xs font-semibold text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 whitespace-nowrap">
                                                        Dibaca
                                                    </button>
                                                </form>
                                            @endif
                                            @if(!$comment->is_approved)
                                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 text-xs font-semibold text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/50 whitespace-nowrap">
                                                        Setujui
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 text-xs font-semibold text-yellow-700 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/50 whitespace-nowrap">
                                                        Tolak
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/30 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 whitespace-nowrap">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $comments->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-12 text-center">
                @if(request('q'))
                    {{-- Jika ada pencarian (q) --}}
                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Komentar Tidak Ditemukan</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        Tidak ada komentar yang sesuai dengan pencarian "<strong>{{ request('q') }}</strong>"
                    </p>
                    <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 dark:bg-slate-700 text-white font-bold rounded-lg hover:bg-slate-800 dark:hover:bg-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Kosongkan Pencarian
                    </a>
                @elseif(request()->hasAny(['status', 'read']))
                    {{-- Jika hanya filter status atau read (tanpa pencarian) --}}
                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Komentar</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                        @if(request('status'))
                            Belum ada komentar dengan status "<strong>{{ request('status') === 'approved' ? 'Disetujui' : 'Menunggu' }}</strong>"
                        @elseif(request('read'))
                            Belum ada komentar dengan status "<strong>{{ request('read') === 'read' ? 'Sudah Dibaca' : 'Belum Dibaca' }}</strong>"
                        @endif
                    </p>
                    <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 dark:bg-slate-700 text-white font-bold rounded-lg hover:bg-slate-800 dark:hover:bg-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Kosongkan Filter
                    </a>
                @else
                    {{-- Jika tidak ada filter sama sekali --}}
                    <svg class="w-16 h-16 text-gray-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum Ada Komentar</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada komentar dari pengunjung website.</p>
                @endif
            </div>
        @endif
        </div>
    </div>

    <script>
        let searchTimeout;
        let searchInput = document.getElementById('search-input');

        function autoSearch() {
            if (!searchInput) return;
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (searchInput.value.length === 0 || searchInput.value.length >= 2) {
                    submitSearch();
                }
            }, 500);
        }

        function submitSearch() {
            if (!searchInput) return;
            
            const status = document.getElementById('filter-status')?.value || '';
            const read = document.getElementById('filter-read')?.value || '';
            const search = searchInput.value;
            
            const url = new URL(window.location.href);
            url.searchParams.delete('status');
            url.searchParams.delete('read');
            url.searchParams.delete('q');
            
            if (status) {
                url.searchParams.set('status', status);
            }
            if (read) {
                url.searchParams.set('read', read);
            }
            if (search) {
                url.searchParams.set('q', search);
            }
            
            // AJAX request untuk update content tanpa reload
            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                // Parse HTML response
                const parser = new DOMParser();
                const doc = parser.parseFromString(data.html, 'text/html');
                
                // Update comments content section
                const newCommentsContent = doc.querySelector('#comments-content');
                const currentCommentsContent = document.querySelector('#comments-content');
                
                if (newCommentsContent && currentCommentsContent) {
                    currentCommentsContent.innerHTML = newCommentsContent.innerHTML;
                }
                
                // Update statistics
                const newStats = doc.querySelectorAll('.grid.grid-cols-1.sm\\:grid-cols-3.gap-4 > div');
                if (newStats.length > 0) {
                    const currentStats = document.querySelectorAll('.grid.grid-cols-1.sm\\:grid-cols-3.gap-4 > div');
                    newStats.forEach((stat, index) => {
                        if (currentStats[index]) {
                            currentStats[index].outerHTML = stat.outerHTML;
                        }
                    });
                }
                
                // Update URL tanpa reload
                window.history.pushState({}, '', url.toString());
                
                // Keep input focused
                if (searchInput) {
                    searchInput.focus();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback to full page reload
                window.location.href = url.toString();
            });
        }

        function applyFilter() {
            const status = document.getElementById('filter-status')?.value || '';
            const read = document.getElementById('filter-read')?.value || '';
            const search = searchInput?.value || '';
            
            const url = new URL(window.location.href);
            url.searchParams.delete('status');
            url.searchParams.delete('read');
            url.searchParams.delete('q');
            
            if (status) {
                url.searchParams.set('status', status);
            }
            if (read) {
                url.searchParams.set('read', read);
            }
            if (search) {
                url.searchParams.set('q', search);
            }
            
            window.location.href = url.toString();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.addEventListener('input', autoSearch);
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitSearch();
                    }
                });
            }
        });
    </script>
@endsection

