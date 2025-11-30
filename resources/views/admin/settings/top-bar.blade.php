@extends('layouts.admin')

@section('title', 'Top Bar')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Top Bar</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi kontak dan link sosial media yang ditampilkan di bar atas website</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6">
            <form action="{{ route('admin.settings.top-bar.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Informasi Kontak -->
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Informasi Kontak</h2>
                        
                        <div class="space-y-4">
                            <!-- Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Nomor Telepon
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $settings->phone ?? '') }}" maxlength="50" placeholder="Masukkan nomor telepon" inputmode="numeric" onkeypress="return isNumberKey(event)" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Hanya angka dan spasi yang dapat diinput</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $settings->email ?? '') }}" maxlength="100" placeholder="Masukkan email" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            </div>
                        </div>
                    </div>

                    <!-- Link Sosial Media -->
                    <div class="border-t border-gray-200 dark:border-slate-700 pt-6">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4">Link Sosial Media</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Masukkan URL lengkap untuk setiap platform sosial media (contoh: https://facebook.com/username)</p>
                        
                        <div class="space-y-4">
                            <!-- Facebook -->
                            <div>
                                <label for="facebook_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Facebook URL
                                </label>
                                <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}" maxlength="500" placeholder="Masukkan URL Facebook" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Instagram URL
                                </label>
                                <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings->instagram_url ?? '') }}" maxlength="500" placeholder="Masukkan URL Instagram" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            </div>

                            <!-- YouTube -->
                            <div>
                                <label for="youtube_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    YouTube URL
                                </label>
                                <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $settings->youtube_url ?? '') }}" maxlength="500" placeholder="Masukkan URL YouTube" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            </div>

                            <!-- TikTok -->
                            <div>
                                <label for="tiktok_url" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    TikTok URL
                                </label>
                                <input type="url" name="tiktok_url" id="tiktok_url" value="{{ old('tiktok_url', $settings->tiktok_url ?? '') }}" maxlength="500" placeholder="Masukkan URL TikTok" class="w-full bg-white dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 rounded-lg px-4 py-3 text-base text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Validasi input hanya angka (0-9) dan spasi
        function isNumberKey(event) {
            const char = String.fromCharCode(event.which);
            // Izinkan angka (0-9) dan spasi
            if ((char >= '0' && char <= '9') || char === ' ') {
                return true;
            }
            event.preventDefault();
            return false;
        }

        // Validasi saat paste (hanya angka dan spasi)
        document.getElementById('phone').addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            // Hanya izinkan angka dan spasi
            const cleaned = paste.replace(/[^0-9 ]/g, '');
            this.value = cleaned;
        });

        // Validasi saat input (hanya angka dan spasi)
        document.getElementById('phone').addEventListener('input', function(e) {
            // Hapus semua karakter yang bukan angka atau spasi
            this.value = this.value.replace(/[^0-9 ]/g, '');
        });
    </script>
@endsection

