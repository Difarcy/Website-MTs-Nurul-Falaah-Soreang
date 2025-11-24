<!-- Info Bar dengan Tanggal, Waktu, dan Text Berjalan -->
<section class="bg-white py-2 sm:py-3 shadow-md border-b border-gray-200">
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl">
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
                <div class="marquee-container bg-white border border-gray-400 px-3 py-1.5 h-full flex items-center">
                    <div class="marquee-content text-black text-xs sm:text-sm font-semibold">
                        <span class="inline-block mr-8">
                            PPDB Tahun Pelajaran 2025/2026 sudah dibuka! Informasi lengkap dan formulir pendaftaran dapat diakses melalui menu “Program” → “Akademik”.
                        </span>
                        <span class="inline-block mr-8">
                            Hubungi WhatsApp resmi MTs Nurul Falaah Soreang di +62 812-3456-7890 untuk konsultasi beasiswa, layanan administrasi, dan informasi kegiatan terbaru.
                        </span>
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

.marquee-content {
    display: inline-block;
    animation: marquee 30s linear infinite;
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.marquee-content:hover {
    animation-play-state: paused;
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

    // Update waktu setiap detik
    setInterval(updateTime, 1000);
    
    // Update tanggal setiap menit (untuk memastikan tanggal berubah jika lewat tengah malam)
    setInterval(updateDate, 60000);
});
</script>

