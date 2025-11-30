<!-- Prestasi Siswa -->
<div class="mt-6">
    <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
        <span class="w-px h-6 sm:h-8 bg-green-700"></span>
        Prestasi Siswa
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 md:gap-5 min-h-[200px]">
            @if(isset($prestasiSiswa) && $prestasiSiswa->count() > 0)
                @foreach($prestasiSiswa as $index => $item)
                @php $i = $index + 1; @endphp
            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105">
                <div class="w-full aspect-[4/5] overflow-hidden relative">
                    <img
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/default-backgrounds.png') }}"
                        alt="{{ $item->judul }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    >
                    <!-- Overlay dengan badge -->
                    <div class="absolute top-3 right-3 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                        Prestasi
                    </div>
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <!-- Judul Prestasi -->
                    <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-sm sm:text-base font-bold text-white line-clamp-2">
                            {{ $item->judul }}
                        </h3>
                    </div>
                </div>
            </div>
                @endforeach
            @else
                <div class="col-span-full flex items-center justify-center py-12">
                    <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                        Belum Ada Prestasi
                    </p>
                </div>
        @endif
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('profil.prestasi') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
            Lihat Semua Prestasi
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>

