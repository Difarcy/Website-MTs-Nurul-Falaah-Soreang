@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi - MTs Nurul Falaah Soreang')

@section('content')
    @php
        $logoPath = 'img/logo.png';
        $logoVersion = file_exists(public_path($logoPath)) ? filemtime(public_path($logoPath)) : null;
    @endphp
    <!-- Background Putih untuk Halaman -->
    <div class="w-full min-h-screen bg-white flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <!-- Card Kotak: Gambar dan Form dalam 1 Container -->
        <div class="w-full max-w-4xl bg-white border border-gray-200 rounded shadow-xl overflow-hidden flex flex-col lg:flex-row">
            <!-- Kiri: Gambar Background dengan Overlay Text -->
            <div class="hidden lg:flex lg:w-[60%] relative overflow-hidden">
                <!-- Background Image -->
                <img
                    src="{{ asset('img/default-backgrounds.png') }}@if(file_exists(public_path('img/default-backgrounds.png')))?v={{ filemtime(public_path('img/default-backgrounds.png')) }}@endif"
                    alt="MTs Nurul Falaah Soreang"
                    class="w-full h-full object-cover"
                >
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/50"></div>
                <!-- Pattern Overlay (Left Side) -->
                <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-gray-100/20 to-transparent" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,.05) 10px, rgba(255,255,255,.05) 20px);"></div>

                <!-- Text Overlay -->
                <div class="absolute inset-0 flex items-end p-6 xl:p-8">
                    <div class="text-white text-left w-full">
                        <p class="text-xl xl:text-2xl mb-0" style="font-family: 'Lato', sans-serif; font-weight: 300; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                            Selamat datang di Portal Informasi
                        </p>
                        <h1 class="text-xl xl:text-2xl font-bold" style="font-family: 'Dosis', sans-serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                            MTs Nurul Falaah Soreang
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Kanan: Form Lupa Password -->
            <div class="w-full lg:w-[40%] flex items-center justify-center p-3 sm:p-4 lg:p-5 xl:p-6 bg-gray-50 relative">
                <!-- Pattern Overlay (Right Side) -->
                <div class="hidden lg:block absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-100/20 to-transparent" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(0,0,0,.02) 10px, rgba(0,0,0,.02) 20px); pointer-events: none;"></div>

                <div class="w-full max-w-sm relative z-10">
                    <!-- Logo -->
                    <div class="flex justify-center mb-3">
                        <img
                            src="{{ asset($logoPath) }}@if($logoVersion)?v={{ $logoVersion }}@endif"
                            alt="Logo MTs Nurul Falaah Soreang"
                            class="h-14 w-14 sm:h-16 sm:w-16 object-contain"
                        >
                    </div>

                    <!-- Header Mobile -->
                    <div class="lg:hidden text-center mb-4">
                        <h1 class="text-lg font-bold text-gray-900 mb-1.5">Lupa Kata Sandi?</h1>
                        <p class="text-sm text-gray-600">Masukkan email Anda dan kami akan mengirimkan link untuk mereset kata sandi Anda.</p>
                    </div>

                    <!-- Header Desktop -->
                    <div class="hidden lg:block mb-4 text-center">
                        <h1 class="text-xl font-bold text-gray-900 mb-1.5">Lupa Kata Sandi?</h1>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Masukkan email Anda dan kami akan mengirimkan link untuk mereset kata sandi Anda.
                        </p>
                    </div>

                    <!-- Form (Tanpa Card) -->
                    <div class="space-y-4">
                        <!-- Form Forgot Password -->
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    class="w-full px-4 py-1.5 border-2 border-gray-300 rounded focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition-colors text-xs"
                                    placeholder="Masukkan Email"
                                >
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded transition-colors duration-200 text-sm"
                            >
                                Kirim Link Reset
                            </button>
                        </form>

                        <!-- Back to Login -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-green-700 hover:text-green-800 font-semibold text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali ke halaman masuk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
