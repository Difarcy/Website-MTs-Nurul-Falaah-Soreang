@extends('layouts.admin')

@section('title', 'Ubah Username')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Ubah Username</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">Ubah username akun admin Anda</p>
    </div>

    @if(session('status') && str_contains(session('status'), 'Username berhasil diubah'))
        <script>
            setTimeout(function() {
                // Logout dan redirect ke login
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('logout') }}';
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }, 2000);
        </script>
    @endif

    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-6">
        <form action="{{ route('admin.change-username.update') }}" method="POST" class="space-y-6" id="changeUsernameForm">
            @csrf

            <div>
                <label for="current_password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Kata Sandi Saat Ini
                </label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                    autocomplete="current-password"
                    class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                    placeholder="Masukkan kata sandi saat ini untuk verifikasi"
                    oninvalid="this.setCustomValidity('Kata sandi saat ini wajib diisi.')"
                    oninput="this.setCustomValidity('')"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Username Baru
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username', Auth::user()->username) }}"
                    required
                    maxlength="50"
                    pattern="[a-zA-Z0-9_\-]+"
                    autocomplete="username"
                    class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-700 focus:border-green-700 dark:bg-slate-700 dark:text-white"
                    placeholder="Masukkan username baru (huruf, angka, underscore, dan dash)"
                    oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Username baru wajib diisi.' : 'Username baru hanya boleh menggunakan huruf, angka, underscore (_), dan dash (-).')"
                    oninput="this.setCustomValidity('')"
                >
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Hanya boleh menggunakan huruf, angka, underscore (_), dan dash (-). Maksimal 50 karakter.</p>
                @error('username')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
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
                    Ubah Username
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

