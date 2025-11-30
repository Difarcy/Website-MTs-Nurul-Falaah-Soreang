<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UnderConstructionController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\FotoKegiatanController;
use App\Http\Controllers\Admin\PrestasiSiswaController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\InfoSekolahController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TopBarController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/posts/last-update', function() {
    $lastUpdate = \App\Models\Post::published()->max('updated_at');
    return response()->json([
        'timestamp' => $lastUpdate ? $lastUpdate->timestamp : time(),
        'datetime' => $lastUpdate ? $lastUpdate->toDateTimeString() : now()->toDateTimeString(),
    ]);
})->name('api.posts.last-update');

// Profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/profil/informasi-sekolah', [ProfilController::class, 'informasiSekolah'])->name('profil.informasi-sekolah');
Route::get('/profil/visi-misi', [ProfilController::class, 'visiMisi'])->name('profil.visi-misi');
Route::get('/profil/sejarah', [ProfilController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/profil/struktur-organisasi', [ProfilController::class, 'strukturOrganisasi'])->name('profil.struktur-organisasi');
Route::get('/profil/kepala-sekolah-guru', [ProfilController::class, 'kepalaSekolahGuru'])->name('profil.kepala-sekolah-guru');
Route::get('/profil/prestasi', [ProfilController::class, 'prestasi'])->name('profil.prestasi');

// Informasi
Route::get('/informasi/berita', [InformasiController::class, 'berita'])->name('informasi.berita');
Route::get('/informasi/artikel', [InformasiController::class, 'artikel'])->name('informasi.artikel');
Route::get('/pengumuman', [InformasiController::class, 'pengumuman'])->name('informasi.pengumuman');
Route::get('/informasi/agenda', [InformasiController::class, 'agenda'])->name('informasi.agenda');
Route::get('/informasi/{type}/{slug}', [InformasiController::class, 'show'])->name('informasi.show');

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/foto-kegiatan', [GaleriController::class, 'fotoKegiatan'])->name('galeri.foto-kegiatan');
Route::get('/galeri/dokumentasi', [GaleriController::class, 'dokumentasi'])->name('galeri.dokumentasi');
Route::get('/galeri/prestasi-siswa', [GaleriController::class, 'prestasiSiswa'])->name('galeri.prestasi-siswa');

// Kontak
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Auth Umum (Tidak digunakan sekarang - untuk masa depan jika website membutuhkan login/daftar publik)
// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/daftar', [AuthController::class, 'register'])->name('register');
// Route::get('/lupa-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
// Route::post('/login', [AuthController::class, 'authenticate'])->name('login.attempt');
// Route::post('/daftar', [AuthController::class, 'store'])->name('register.store');

// Logout (digunakan oleh admin panel)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auth Admin Panel (Yang digunakan sekarang)
Route::get('/ap/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::post('/ap/login', [AuthController::class, 'adminAuthenticate'])->name('admin.login.attempt');

// Under Construction
Route::get('/under-construction', [UnderConstructionController::class, 'index'])->name('under-construction');
Route::get('/social-media-unavailable', [UnderConstructionController::class, 'socialMediaUnavailable'])->name('social-media-unavailable');

// Admin CMS
Route::middleware('auth')->prefix('ap')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.update');
    Route::resource('posts', PostController::class)->except(['show']);
    Route::post('banners/settings', [BannerController::class, 'updateSettings'])->name('banners.settings.update');
    Route::post('banners/upload', [BannerController::class, 'upload'])->name('banners.upload');
    Route::patch('banners/update-order', [BannerController::class, 'updateOrder'])->name('banners.update-order');
    Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
    Route::resource('banners', BannerController::class)->only(['index', 'destroy']);
    Route::resource('foto-kegiatan', FotoKegiatanController::class);
    Route::resource('prestasi-siswa', PrestasiSiswaController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('agenda', AgendaController::class);
    Route::resource('kontak', KontakController::class);
    Route::resource('info-sekolah', InfoSekolahController::class);
    // Site settings
    Route::get('settings/logo', [SettingController::class, 'logo'])->name('settings.logo');
    Route::post('settings/logo', [SettingController::class, 'updateLogo'])->name('settings.logo.update');
    Route::get('settings/top-bar', [TopBarController::class, 'index'])->name('settings.top-bar');
    Route::put('settings/top-bar', [TopBarController::class, 'update'])->name('settings.top-bar.update');
});
