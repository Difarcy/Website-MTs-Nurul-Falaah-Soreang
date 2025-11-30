@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Ganti Password</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Ubah password akun admin Anda</p>
    </div>

    @if(session('status'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6">
        <form action="{{ route('admin.change-password.update') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="current_password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Password Saat Ini
                </label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                    class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                    placeholder="Masukkan password saat ini"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Password Baru
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                    placeholder="Masukkan password baru (min. 8 karakter)"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Konfirmasi Password Baru
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                    placeholder="Ulangi password baru"
                >
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors"
                >
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
@endsection

