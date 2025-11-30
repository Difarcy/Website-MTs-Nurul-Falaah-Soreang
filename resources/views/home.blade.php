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

            // Cek apakah halaman terlihat (user tidak minimize tab)
            document.addEventListener('visibilitychange', function() {
                isPageVisible = !document.hidden;
                if (isPageVisible) {
                    startAutoRefresh();
                } else {
                    stopAutoRefresh();
                }
            });

            function checkForNewPosts() {
                if (!isPageVisible) return;

                fetch('{{ route('api.posts.last-update') }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    cache: 'no-cache'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.timestamp && data.timestamp > lastUpdateTimestamp) {
                        // Ada berita baru, reload halaman
                        lastUpdateTimestamp = data.timestamp;
                        location.reload();
                    }
                })
                .catch(error => {
                    console.log('Error checking for new posts:', error);
                });
            }

            function startAutoRefresh() {
                if (refreshInterval) return;
                // Cek setiap 5 detik untuk responsifitas lebih cepat
                refreshInterval = setInterval(checkForNewPosts, 5000);
            }

            // Cek segera setelah halaman dimuat (tidak perlu tunggu 5 detik pertama)
            setTimeout(checkForNewPosts, 2000);

            function stopAutoRefresh() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                    refreshInterval = null;
                }
            }

            // Mulai auto-refresh saat halaman dimuat
            if (isPageVisible) {
                startAutoRefresh();
            }

            // Cleanup saat halaman ditutup
            window.addEventListener('beforeunload', stopAutoRefresh);
        })();
    </script>
@endpush

@section('content')
    @include('home.sections.banner', ['banners' => $banners ?? collect()])
    @include('home.sections.info-bar')
    @include('home.sections.berita-terbaru', [
        'latestNews' => $latestNews,
        'latestArticles' => $latestArticles,
        'infoTerkini' => $infoTerkini ?? collect(),
        'agendaTerbaru' => $agendaTerbaru ?? collect(),
        'prestasiSiswa' => $prestasiSiswa ?? collect(),
        'fotoKegiatan' => $fotoKegiatan ?? collect(),
    ])
@endsection
