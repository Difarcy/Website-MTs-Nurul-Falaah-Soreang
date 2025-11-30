<!-- Agenda Terbaru -->
<div class="bg-white border border-gray-200 overflow-hidden mt-6">
    <div class="p-4">
        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Agenda Terbaru
        </h3>
        @php
            $agendaData = isset($agendaTerbaru) && $agendaTerbaru->count() > 0 ? $agendaTerbaru : collect();
        @endphp
        <div class="space-y-3 min-h-[200px]">
            @if($agendaData->count() > 0)
                @foreach($agendaData->take(5) as $item)
                <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
                    <a href="{{ route('informasi.agenda') }}" class="block hover:text-green-700 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 bg-green-700 text-white rounded-lg p-2 text-center min-w-[50px]">
                                <div class="text-xs font-bold">{{ $item->tanggal_mulai->format('d') }}</div>
                                <div class="text-[10px] uppercase">{{ $item->tanggal_mulai->format('M') }}</div>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-xs sm:text-sm font-semibold text-gray-900 mb-1 line-clamp-2 hover:text-green-700">
                                    {{ $item->judul }}
                                </h4>
                                <p class="text-xs text-gray-500">
                                    @if($item->waktu)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $item->waktu }} WIB
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @else
                <div class="flex items-center justify-center" style="min-height: 200px;">
                    <p class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-300 text-center">
                        Belum Ada Agenda
                    </p>
                </div>
            @endif
        </div>
        <div class="mt-2 text-center">
            <a href="{{ route('informasi.agenda') }}" class="inline-flex items-center gap-1 text-green-700 hover:text-green-800 font-semibold text-xs sm:text-sm transition-colors duration-300 group">
                Selengkapnya
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>

