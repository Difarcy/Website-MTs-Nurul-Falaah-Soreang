@extends('layouts.app')

@section('title', 'Media Sosial Belum Tersedia | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-6 sm:px-8 lg:px-12 xl:px-16 max-w-7xl py-12 sm:py-16 md:py-20">
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
            <!-- Icon Social Media -->
            <div class="mb-6 sm:mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 sm:h-32 sm:w-32 md:h-40 md:w-40 text-green-700 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342c-.4 0-.816.04-1.236.08 2.897-.888 5.004-3.54 5.004-6.804 0-.6-.06-1.179-.17-1.723a4.37 4.37 0 001.447-.89 11.228 11.228 0 01-3.172 1.195 4.418 4.418 0 00-6.007-4.04 4.417 4.417 0 001.804 5.9 4.404 4.404 0 01-1.9-.523v.052a4.185 4.185 0 003.355 4.101 4.21 4.21 0 01-1.872.07 4.185 4.185 0 003.9 2.903A8.394 8.394 0 012 18.282a11.83 11.83 0 006.408 1.88c7.693 0 11.9-6.373 11.9-11.9 0-.18-.005-.362-.013-.54a8.497 8.497 0 002.092-2.164z" />
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 sm:mb-6">
                Media Sosial Belum Tersedia
            </h1>

            <!-- Description -->
            <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed">
                Maaf, akun media sosial kami saat ini belum tersedia. Kami sedang mempersiapkan akun media sosial resmi untuk memberikan informasi terbaru kepada Anda.
            </p>

            <!-- Alternative Text -->
            <p class="text-xs sm:text-sm text-gray-500 mb-8 sm:mb-10 max-w-xl mx-auto">
                Silakan kembali lagi nanti atau hubungi kami melalui kontak yang tersedia di halaman kontak.
            </p>

            <!-- Back Button -->
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-6 sm:px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection

