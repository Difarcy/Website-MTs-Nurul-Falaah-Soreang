@extends('layouts.auth')

@section('title', 'Masuk - MTs Nurul Falaah Soreang')

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
                    src="{{ asset('img/sample1.jpg') }}?v={{ filemtime(public_path('img/sample1.jpg')) }}"
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

            <!-- Kanan: Form Login -->
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
                        <h1 class="text-lg font-bold text-gray-900 mb-1.5">Masuk ke Akun Anda</h1>
                        <p class="text-sm text-gray-600">Gunakan akun Anda untuk mengakses layanan administrasi dan informasi MTs Nurul Falaah Soreang.</p>
                    </div>

                    <!-- Header Desktop -->
                    <div class="hidden lg:block mb-4 text-center">
                        <h1 class="text-xl font-bold text-gray-900 mb-1.5">Masuk ke Akun Anda</h1>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Gunakan akun Anda untuk mengakses layanan administrasi dan informasi MTs Nurul Falaah Soreang.
                        </p>
                    </div>

                    <!-- Form (Tanpa Card) -->
                    <div class="space-y-4">
                        <!-- Login via Google -->
                        <a href="{{ route('under-construction') }}" class="w-full flex items-center justify-center gap-2 bg-white border-2 border-gray-300 text-gray-700 font-bold py-1 px-4 rounded hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-sm">Google</span>
                        </a>

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-3 bg-gray-50 text-gray-500">atau lanjutkan dengan</span>
                            </div>
                        </div>

                        <!-- Form Login -->
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            <!-- Email/Username -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Email/akun pengguna <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    required
                                    class="w-full px-4 py-1.5 border-2 border-gray-300 rounded focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition-colors text-xs"
                                    placeholder="Masukkan Email"
                                >
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        class="w-full px-4 py-1.5 pr-10 border-2 border-gray-300 rounded focus:ring-2 focus:ring-green-700 focus:border-green-700 outline-none transition-colors text-xs"
                                        placeholder="Masukkan password"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                    >
                                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Forgot Password -->
                            <div class="flex justify-end">
                                <a href="{{ route('forgot-password') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                    Lupa kata sandi?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded transition-colors duration-200 text-sm"
                            >
                                Masuk
                            </button>
                        </form>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-green-700 hover:text-green-800 font-semibold transition-colors">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
@endsection
