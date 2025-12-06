@extends('layouts.app')

@section('title', 'Halaman Dalam Pengembangan | MTs Nurul Falaah Soreang')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 max-w-7xl py-12 sm:py-16 md:py-20">
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
            <!-- Icon Construction -->
            <div class="mb-6 sm:mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 sm:h-32 sm:w-32 md:h-40 md:w-40 text-green-700 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 sm:mb-6">
                Halaman Dalam Pengembangan
            </h1>

            <!-- Description -->
            <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed">
                Maaf, halaman ini masih dalam tahap pengembangan. Kami sedang bekerja keras untuk menyediakan konten terbaik untuk Anda.
            </p>

            <!-- Alternative Text -->
            <p class="text-xs sm:text-sm text-gray-500 mb-8 sm:mb-10 max-w-xl mx-auto">
                Halaman ini belum dibuat atau masih dalam proses pembuatan.
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

