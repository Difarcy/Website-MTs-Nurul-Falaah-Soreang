@extends('layouts.app')

@section('title', 'MTs Nurul Falaah Soreang')

@push('styles')
    @vite('resources/css/home.css')
@endpush

@push('scripts')
    @vite('resources/js/home.js')
    <script>
        // Auto-refresh berita terbaru tanpa reload halaman
        (function() {
            let lastUpdateTimestamp = {{ $lastPostUpdate ?? time() }};
            let isPageVisible = true;
            let refreshInterval = null;
            let initialCheckTimeout = null;
            let activeControllers = []; // Store all active fetch controllers

            // Cek apakah halaman terlihat (user tidak minimize tab)
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
                        // Ada berita baru, reload halaman
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

            // Mulai auto-refresh saat halaman dimuat
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

@section('content')
    @include('home.sections.banner', ['banners' => $banners ?? collect()])
    @include('home.sections.info-bar', ['runningTexts' => $runningTexts ?? collect()])
    @include('home.sections.berita-terbaru', [
        'latestNews' => $latestNews,
        'latestArticles' => $latestArticles,
        'infoTerkini' => $infoTerkini ?? collect(),
        'agendaTerbaru' => $agendaTerbaru ?? collect(),
        'prestasiSiswa' => $prestasiSiswa ?? collect(),
        'fotoKegiatan' => $fotoKegiatan ?? collect(),
    ])
@endsection
