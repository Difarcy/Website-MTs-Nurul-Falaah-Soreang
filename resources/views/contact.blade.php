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
                <div class="space-y-4">
                    <!-- Alamat -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm text-gray-900 leading-relaxed">
                                Jalan Soreang Banjaran, Kampung Ciwaru RT. 01/RW. 16, Kelurahan Soreang, Kecamatan Soreang, Kabupaten Bandung, Provinsi Jawa Barat 40911, Indonesia
                            </p>
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm text-gray-900">(022) 1234-5678</p>
                        </div>
                    </div>

                    <!-- Nomor Whatsapp -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="text-xs sm:text-sm text-green-700 hover:text-green-800 font-medium transition-colors">
                                +62 812-3456-7890
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <a href="mailto:info@mtsnurulfalaahsoreang.sch.id" class="text-xs sm:text-sm text-green-700 hover:text-green-800 font-medium transition-colors">
                                info@mtsnurulfalaahsoreang.sch.id
                            </a>
                        </div>
                    </div>

                    <!-- Koordinat Lokasi -->
                    <div class="flex items-start gap-3 pt-3 border-t border-gray-200">
                        <div class="flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="space-y-1">
                                <p class="text-xs sm:text-sm text-gray-900">
                                    <span class="font-semibold">Lintang:</span> 7° 2' 2.04" S
                                </p>
                                <p class="text-xs sm:text-sm text-gray-900">
                                    <span class="font-semibold">Bujur:</span> 107° 32' 12.48" E
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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
