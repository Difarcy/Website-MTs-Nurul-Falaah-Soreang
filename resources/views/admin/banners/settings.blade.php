@extends('layouts.admin')

@section('title', 'Informasi Banner Global')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Informasi Banner Global</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Teks dan pengaturan di bawah ini akan dipakai untuk semua slide banner di halaman utama.
                </p>
            </div>
        </div>

        @if(session('status'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/40 border border-green-200 dark:border-green-700 px-4 py-3 text-sm text-green-800 dark:text-green-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 space-y-6">
            <form action="{{ route('admin.banners.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Tagline
                            <span class="text-xs font-normal text-slate-400">(opsional, teks kecil di atas judul)</span>
                        </label>
                        <input
                            type="text"
                            name="tagline"
                            id="tagline"
                            value="{{ old('tagline', $settings->tagline) }}"
                            maxlength="255"
                            placeholder="Masukkan tagline"
                            class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600"
                            oninput="updateCharCount('tagline', 255)"
                        >
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                            <span id="tagline-count">0</span>/255 karakter
                        </p>
                        @error('tagline') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Judul Banner
                            <span class="text-xs font-normal text-slate-400">(opsional, judul utama banner)</span>
                        </label>
                        <input
                            type="text"
                            name="judul"
                            id="judul"
                            value="{{ old('judul', $settings->judul) }}"
                            maxlength="255"
                            placeholder="Masukkan judul banner"
                            class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600"
                            oninput="updateCharCount('judul', 255)"
                        >
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                            <span id="judul-count">0</span>/255 karakter
                        </p>
                        @error('judul') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Deskripsi
                        <span class="text-xs font-normal text-slate-400">(opsional, usahakan singkat ±2 baris kalimat)</span>
                    </label>
                    <textarea
                        name="deskripsi"
                        id="deskripsi"
                        rows="3"
                        maxlength="220"
                        placeholder="Masukkan deskripsi banner"
                        class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600"
                        oninput="updateCharCount('deskripsi', 220)"
                    >{{ old('deskripsi', $settings->deskripsi) }}</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                        <span id="deskripsi-count">0</span>/220 karakter
                    </p>
                    @error('deskripsi') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Link
                            <span class="text-xs font-normal text-slate-400">(opsional, URL yang dibuka saat tombol diklik)</span>
                        </label>
                        <input
                            type="url"
                            name="link"
                            id="link"
                            value="{{ old('link', $settings->link) }}"
                            maxlength="500"
                            placeholder="Masukkan URL (contoh: https://example.com)"
                            class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600"
                            oninput="updateCharCount('link', 500)"
                        >
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                            <span id="link-count">0</span>/500 karakter
                        </p>
                        @error('link') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Teks Tombol
                            <span class="text-xs font-normal text-slate-400">(opsional, teks pada tombol jika ada link)</span>
                        </label>
                        <input
                            type="text"
                            name="button_text"
                            id="button_text"
                            value="{{ old('button_text', $settings->button_text) }}"
                            maxlength="100"
                            placeholder="Masukkan teks tombol"
                            class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600"
                            oninput="updateCharCount('button_text', 100)"
                        >
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-right">
                            <span id="button_text-count">0</span>/100 karakter
                        </p>
                        @error('button_text') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-slate-700 pt-4 mt-4">
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Kontrol Tampilan Elemen</h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="show_logo"
                                value="1"
                                {{ old('show_logo', $settings->show_logo ?? true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600"
                            >
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Logo</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="show_tagline"
                                value="1"
                                {{ old('show_tagline', $settings->show_tagline ?? true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600"
                            >
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Tagline</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="show_title"
                                value="1"
                                {{ old('show_title', $settings->show_title ?? true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600"
                            >
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Judul</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="show_description"
                                value="1"
                                {{ old('show_description', $settings->show_description ?? true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600"
                            >
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Deskripsi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="show_button"
                                value="1"
                                {{ old('show_button', $settings->show_button ?? true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-600"
                            >
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tampilkan Tombol Aksi</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('admin.banners.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                        Simpan Informasi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


