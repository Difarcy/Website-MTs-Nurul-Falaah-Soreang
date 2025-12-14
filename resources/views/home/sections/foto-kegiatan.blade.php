<!-- Galeri Foto Kegiatan -->
<div class="mt-6">
    <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
        <span class="w-px h-6 sm:h-8 bg-green-700"></span>
        Kegiatan Sekolah
    </h2>
    <div class="grid grid-cols-3 gap-4 min-h-[320px]">
            @if(isset($fotoKegiatan) && $fotoKegiatan->count() > 0)
                @foreach($fotoKegiatan as $index => $item)
                @php $i = $index + 1; @endphp
            <div class="relative overflow-hidden rounded-lg">
                <div class="w-full aspect-[4/3] overflow-hidden relative">
                    <img
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('img/default-backgrounds.png') }}"
                        alt="{{ $item->judul ?? 'Foto Kegiatan ' . $i }}"
                        class="w-full h-full object-cover"
                    >
                </div>
            </div>
                @endforeach
            @else
                <div class="col-span-full flex items-center justify-center py-12">
                    <p class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-300 text-center">
                        Belum Ada Foto Kegiatan
                    </p>
                </div>
        @endif
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('galeri.foto-kegiatan') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
</div>

