@extends('layouts.app')

@section('title', 'Kontak - MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-8 sm:py-12">
        <!-- Header Section -->
        <div class="mb-8">
            <x-page-title title="Kontak" />
        </div>

        <!-- Informasi Kontak dan Peta Lokasi dalam 1 Container -->
        <div class="space-y-8">
            <!-- Informasi Kontak -->
            <div>
                @if($kontaks->count() > 0)
                    <div class="space-y-4">
                        @foreach($kontaks as $kontak)
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    @if($kontak->icon)
                                        <span class="text-lg">{{ $kontak->icon }}</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-700 mb-1">{{ $kontak->label }}</p>
                                    @if($kontak->jenis == 'email')
                                        <a href="mailto:{{ $kontak->nilai }}" class="text-xs sm:text-sm text-green-700 hover:text-green-800 font-medium transition-colors">
                                            {{ $kontak->nilai }}
                                        </a>
                                    @elseif($kontak->jenis == 'whatsapp')
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak->nilai) }}" target="_blank" rel="noopener noreferrer" class="text-xs sm:text-sm text-green-700 hover:text-green-800 font-medium transition-colors">
                                            {{ $kontak->nilai }}
                                        </a>
                                    @else
                                        <p class="text-xs sm:text-sm text-gray-900 leading-relaxed">{{ $kontak->nilai }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <p class="text-sm text-gray-500">Belum ada informasi kontak</p>
                    </div>
                @endif
            </div>

            <!-- Peta Lokasi -->
            <div>
                <h2 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <span class="w-px h-6 sm:h-8 bg-green-700"></span>
                    Peta Lokasi
                </h2>
                
                <div class="w-full aspect-square overflow-hidden rounded-lg border border-gray-300">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.1234567890123!2d107.5368!3d-7.0339!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDInMDIuMCJTIDEwN8KwMzInMTIuNSJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full"
                    ></iframe>
                </div>
                
                <div class="mt-4 text-center">
                    <a 
                        href="https://www.google.com/maps/search/?api=1&query=-7.0339,107.5368" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors duration-300 group"
                    >
                        Buka di Google Maps
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
