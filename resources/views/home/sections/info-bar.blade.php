<!-- Info Bar dengan Tanggal, Waktu, dan Text Berjalan -->
<section class="bg-white dark:bg-slate-900 py-2 sm:py-3 shadow-md">
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl">
        <div class="flex items-stretch">
            <!-- Tanggal (Kiri) -->
            <div class="flex items-center gap-2 shrink-0 bg-green-800 text-white px-3 py-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="current-date" class="text-xs sm:text-sm font-semibold whitespace-nowrap"></span>
            </div>

            <!-- Text Berjalan (Tengah) -->
            <div class="flex-1 overflow-hidden">
                <div class="marquee-container bg-white dark:bg-slate-800 border border-gray-400 dark:border-slate-600 px-3 py-1.5 h-full flex items-center">
                    @php
                        $hasTicker = isset($tickerItems) && $tickerItems->count() > 0;
                        
                        if ($hasTicker) {
                            // Ticker otomatis dari data terbaru dengan pemisah profesional
                            $tickerText = $tickerItems->map(fn($item) => trim($item))->filter()->implode(' • ');
                            $tickerClass = '';
                        } else {
                            // Default: Ticker kosong
                            $tickerText = 'Tidak ada informasi terbaru';
                            $tickerClass = 'opacity-80 italic';
                        }
                    @endphp
                    <div class="marquee-wrapper">
                        <div class="marquee-content text-black dark:text-white text-xs sm:text-sm font-semibold {{ $tickerClass }}">
                            <span class="marquee-item">{{ $tickerText }}</span>
                            <span class="marquee-item" aria-hidden="true">{{ $tickerText }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Waktu (Kanan) -->
            <div class="flex items-center gap-2 shrink-0 bg-green-800 text-white px-3 py-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span id="current-time" class="text-xs sm:text-sm font-semibold whitespace-nowrap"></span>
            </div>
        </div>
    </div>
</section>

<style>
.marquee-container {
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    display: flex;
    align-items: center;
}

.marquee-wrapper {
    width: 100%;
    overflow: hidden;
}

.marquee-content {
    display: inline-flex;
    white-space: nowrap;
    animation: marquee 40s linear infinite;
    will-change: transform;
}

.marquee-item {
    display: inline-block;
    padding-right: 4rem; /* Spacing antara duplikat untuk seamless loop */
    white-space: nowrap;
    flex-shrink: 0;
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(calc(-50% - 2rem)); /* Offset untuk spacing */
    }
}

.marquee-content:hover {
    animation-play-state: paused;
}

/* Smooth transition untuk dark mode */
.marquee-content {
    transition: color 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update Tanggal
    function updateDate() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const dateString = now.toLocaleDateString('id-ID', options);
        document.getElementById('current-date').textContent = dateString;
    }

    // Update Waktu
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds} WIB`;
    }

    // Update awal
    updateDate();
    updateTime();

    // Store interval IDs untuk cleanup
    let timeInterval = null;
    let dateInterval = null;

    // Update waktu setiap detik
    timeInterval = setInterval(updateTime, 1000);
    
    // Update tanggal setiap menit (untuk memastikan tanggal berubah jika lewat tengah malam)
    dateInterval = setInterval(updateDate, 60000);
    
    // Cleanup saat halaman tidak aktif
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (timeInterval) {
                clearInterval(timeInterval);
                timeInterval = null;
            }
            if (dateInterval) {
                clearInterval(dateInterval);
                dateInterval = null;
            }
        } else {
            // Restart intervals saat halaman aktif kembali
            if (!timeInterval) {
                timeInterval = setInterval(updateTime, 1000);
            }
            if (!dateInterval) {
                dateInterval = setInterval(updateDate, 60000);
            }
        }
    });
    
    window.addEventListener('pagehide', function() {
        if (timeInterval) {
            clearInterval(timeInterval);
            timeInterval = null;
        }
        if (dateInterval) {
            clearInterval(dateInterval);
            dateInterval = null;
        }
    });
});
</script>

