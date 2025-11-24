<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UnderConstructionController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\AuthController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

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

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/foto-kegiatan', [GaleriController::class, 'fotoKegiatan'])->name('galeri.foto-kegiatan');
Route::get('/galeri/dokumentasi', [GaleriController::class, 'dokumentasi'])->name('galeri.dokumentasi');
Route::get('/galeri/prestasi-siswa', [GaleriController::class, 'prestasiSiswa'])->name('galeri.prestasi-siswa');

// Kontak
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/daftar', [AuthController::class, 'register'])->name('register');
Route::get('/lupa-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

// Under Construction
Route::get('/under-construction', [UnderConstructionController::class, 'index'])->name('under-construction');
Route::get('/social-media-unavailable', [UnderConstructionController::class, 'socialMediaUnavailable'])->name('social-media-unavailable');
