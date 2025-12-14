@extends('layouts.app')

@section('title', 'Artikel - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-8 sm:py-12">
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('home')],
            ['label' => 'Artikel']
        ]" />
        <x-page-title title="Artikel" />

        <form method="GET" class="mt-6">
            <div class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari artikel inspiratif..."
                    autocomplete="off"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-700 focus:border-green-700"
                >
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg text-sm font-semibold hover:bg-green-800">
                    Cari Artikel
                </button>
            </div>
        </form>

        @php
            $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $fallbackImages = ['img/banner1.jpg', 'img/banner2.jpg', 'img/banner3.jpg'];

            // Helper function untuk formatting tanggal
            function formatDate($item, $monthNames) {
                $dateObj = $item->published_at ?? $item->created_at;
                $month = $monthNames[$dateObj->month - 1];
                return [
                    'date' => $dateObj->day . ' ' . $month . ', ' . $dateObj->year,
                    'time' => $dateObj->format('H:i')
                ];
            }
        @endphp

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 mt-8">
            <div class="w-full lg:w-[70%] space-y-4">
                @forelse($posts as $post)
                    @php
                        $image = $post->thumbnail_path
                            ? asset('storage/' . $post->thumbnail_path)
                            : asset($fallbackImages[$loop->index % count($fallbackImages)]);
                        $formattedDate = formatDate($post, $monthNames);
                    @endphp
                    <article class="bg-white border border-gray-200 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="flex flex-col sm:flex-row">
                            <div class="w-full sm:w-[38%] shrink-0">
                                <div class="w-full aspect-video bg-gray-100 overflow-hidden">
                                    <img src="{{ $image }}" alt="{{ $post->title }}" class="w-full h-full object-contain">
                                </div>
                            </div>
                            <div class="w-full sm:w-[62%] p-2.5 sm:p-3 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 line-clamp-2 hover:text-green-700 transition-colors">
                                        <a href="{{ route('informasi.show', ['type' => $post->type, 'slug' => $post->slug]) }}" class="hover:text-green-700 transition-colors">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    @if($post->excerpt)
                                        <p class="text-xs sm:text-sm text-gray-600 line-clamp-4 mb-2 text-justify">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-gray-500">
                                        {{ $formattedDate['date'] }} | {{ $formattedDate['time'] }}
                                    </p>
                                    <a href="{{ route('informasi.show', ['type' => $post->type, 'slug' => $post->slug]) }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                        Baca Artikel
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white border border-gray-200 rounded-xl p-10 text-center text-gray-400 font-semibold text-lg">
                        Belum ada artikel yang tersedia.
                    </div>
                @endforelse

                <div>
                    {{ $posts->links() }}
                </div>
            </div>


            <div class="w-full lg:w-[30%] space-y-6">
                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Berita Terbaru
                        </h3>
                        <div class="space-y-4 min-h-[300px]">
                            @forelse($sidebarNews as $news)
                                @php
                                    $formattedDate = formatDate($news, $monthNames);
                                @endphp
                                <article class="pb-4 last:pb-0">
                                    <a href="{{ route('informasi.show', ['type' => $news->type, 'slug' => $news->slug]) }}" class="block hover:text-green-700 transition-colors">
                                        <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-green-700">
                                            {{ $news->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $formattedDate['date'] }} | {{ $formattedDate['time'] }}
                                        </p>
                                    </a>
                                </article>
                            @empty
                                <div class="flex items-center justify-center" style="min-height: 300px;">
                                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-300 text-center">
                                        Belum Ada Berita
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pengumuman
                        </h3>
                        <div class="space-y-3 min-h-[300px]">
                            @forelse($infoTerkini as $info)
                                <div class="pb-3 last:pb-0">
                                    <a href="{{ route('informasi.show', ['type' => $info->type, 'slug' => $info->slug]) }}" class="block hover:text-green-700 transition-colors">
                                        <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700">
                                            {{ $info->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            {{ ($info->published_at ?? $info->created_at)->format('d M Y') }}
                                        </p>
                                    </a>
                                </div>
                            @empty
                                <div class="flex items-center justify-center" style="min-height: 300px;">
                                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-300 text-center">
                                        Belum Ada Info
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Agenda
                        </h3>
                        <div class="space-y-3">
                            @php
                                $agendaSidebar = [
                                    ['judul' => 'Rapat Koordinasi Guru dan Staf', 'tanggal' => '2025-01-20'],
                                    ['judul' => 'Kegiatan Outing Class Siswa Kelas 7', 'tanggal' => '2025-01-25'],
                                    ['judul' => 'Lomba Tahfidz Al-Qur\'an Tingkat Sekolah', 'tanggal' => '2025-02-01'],
                                ];
                            @endphp
                            @foreach($agendaSidebar as $item)
                                <div class="pb-3 last:pb-0">
                                    <a href="{{ route('informasi.agenda') }}" class="block hover:text-green-700 transition-colors">
                                        <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700">
                                            {{ $item['judul'] }}
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                            <div class="text-center mt-4">
                                <a href="{{ route('informasi.agenda') }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs transition-colors duration-300 group">
                                    Lihat Semua Agenda
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-refresh artikel tanpa reload halaman
        (function() {
            let lastUpdateTimestamp = {{ \App\Models\Post::published()->ofType('artikel')->max('updated_at')?->timestamp ?? time() }};
            let isPageVisible = true;
            let refreshInterval = null;
            let initialCheckTimeout = null;
            let activeControllers = []; // Store all active fetch controllers

            document.addEventListener('visibilitychange', function() {
                isPageVisible = !document.hidden;
                if (isPageVisible) {
                    startAutoRefresh();
                } else {
                    stopAutoRefresh();
                    // Cancel all active fetch requests
                    cancelAllActiveRequests();
                }
            });

            function checkForNewPosts() {
                if (!isPageVisible) return;

                // Create AbortController untuk timeout
                const controller = new AbortController();
                activeControllers.push(controller);
                const timeoutId = setTimeout(() => {
                    controller.abort();
                    removeController(controller);
                }, 5000); // Timeout 5 detik

                fetch('{{ route('api.posts.last-update') }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    cache: 'no-cache',
                    signal: controller.signal
                })
                .then(response => {
                    clearTimeout(timeoutId);
                    removeController(controller);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.timestamp && data.timestamp > lastUpdateTimestamp) {
                        lastUpdateTimestamp = data.timestamp;
                        location.reload();
                    }
                })
                .catch(error => {
                    clearTimeout(timeoutId);
                    removeController(controller);
                    // Ignore abort errors dan network errors (biasanya dari extension)
                    if (error.name === 'AbortError' || error.name === 'TypeError') {
                        return;
                    }
                    // Hanya log error yang benar-benar penting
                    if (error.message && !error.message.includes('Failed to fetch')) {
                    console.log('Error checking for new posts:', error);
                    }
                });
            }

            function removeController(controller) {
                const index = activeControllers.indexOf(controller);
                if (index > -1) {
                    activeControllers.splice(index, 1);
                }
            }

            function cancelAllActiveRequests() {
                activeControllers.forEach(controller => {
                    try {
                        controller.abort();
                    } catch (e) {
                        // Ignore errors
                    }
                });
                activeControllers = [];
            }

            function startAutoRefresh() {
                if (refreshInterval) return;
                // Cek setiap 3 detik untuk responsifitas lebih cepat
                refreshInterval = setInterval(checkForNewPosts, 3000);
            }

            function stopAutoRefresh() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                    refreshInterval = null;
                }
                if (initialCheckTimeout) {
                    clearTimeout(initialCheckTimeout);
                    initialCheckTimeout = null;
                }
            }

            if (isPageVisible) {
                startAutoRefresh();
            // Cek segera setelah halaman dimuat (tidak perlu tunggu 3 detik pertama)
                initialCheckTimeout = setTimeout(checkForNewPosts, 1000);
            }

            // Cleanup saat halaman ditutup atau tidak aktif
            window.addEventListener('beforeunload', function() {
                stopAutoRefresh();
                cancelAllActiveRequests();
            });

            window.addEventListener('pagehide', function() {
                stopAutoRefresh();
                cancelAllActiveRequests();
            });
        })();
    </script>
@endpush

