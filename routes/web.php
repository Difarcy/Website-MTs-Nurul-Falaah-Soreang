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
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\ChatbotController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/posts/last-update', function () {
    try {
        $lastPost = \App\Models\Post::published()->orderBy('updated_at', 'desc')->first();
        if ($lastPost && $lastPost->updated_at) {
            return response()->json([
                'timestamp' => $lastPost->updated_at->timestamp,
                'datetime' => $lastPost->updated_at->toDateTimeString(),
            ]);
        }
        return response()->json([
            'timestamp' => time(),
            'datetime' => now()->toDateTimeString(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'timestamp' => time(),
            'datetime' => now()->toDateTimeString(),
            'error' => 'Failed to get last update'
        ], 500);
    }
})->name('api.posts.last-update');

Route::get('/api/tags/suggestions', function () {
    $query = request('q', '');

    // Get all unique tags from all posts (published and draft)
    $allTags = \App\Models\Post::whereNotNull('tags')
        ->get()
        ->pluck('tags')
        ->flatten()
        ->filter()
        ->map(fn($tag) => trim($tag))
        ->unique()
        ->values();

    // Filter by query if provided
    if ($query) {
        $allTags = $allTags->filter(function ($tag) use ($query) {
            return stripos($tag, $query) !== false;
        });
    }

    // Return top 10 suggestions (sinkron dengan maksimal tag per posting)
    return response()->json($allTags->take(10)->values()->toArray());
})->name('api.tags.suggestions');

Route::get('/api/search', function () {
    $query = request('q', '');

    if (empty(trim($query))) {
        return response()->json([]);
    }

    // Cari di berita dan artikel yang published
    $results = \App\Models\Post::published()
        ->search($query)
        ->latest('published_at')
        ->take(10)
        ->get()
        ->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'type' => $post->type,
                'excerpt' => $post->excerpt,
                'thumbnail_path' => $post->thumbnail_path,
                'published_at' => $post->published_at?->format('d M Y'),
            ];
        });

    return response()->json($results->toArray());
})->name('api.search');

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
Route::get('/informasi/tag/{tag}', [InformasiController::class, 'byTag'])->name('informasi.tag');
Route::get('/pengumuman', [InformasiController::class, 'pengumuman'])->name('informasi.pengumuman');
Route::get('/informasi/agenda', [InformasiController::class, 'agenda'])->name('informasi.agenda');
Route::get('/informasi/{type}/{slug}', [InformasiController::class, 'show'])->name('informasi.show');
Route::post('/informasi/{type}/{slug}/comment', [CommentController::class, 'store'])->name('comments.store');

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/foto-kegiatan', [GaleriController::class, 'fotoKegiatan'])->name('galeri.foto-kegiatan');
Route::get('/galeri/dokumentasi', [GaleriController::class, 'dokumentasi'])->name('galeri.dokumentasi');
Route::get('/galeri/prestasi-siswa', [GaleriController::class, 'prestasiSiswa'])->name('galeri.prestasi-siswa');

// Kontak
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Chatbot
Route::post('/api/chatbot/query', [ChatbotController::class, 'query'])->name('chatbot.query');

// Auth Umum (Tidak digunakan sekarang - untuk masa depan jika website membutuhkan login/daftar publik)
// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/daftar', [AuthController::class, 'register'])->name('register');
// Route::get('/lupa-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
// Route::post('/login', [AuthController::class, 'authenticate'])->name('login.attempt');
// Route::post('/daftar', [AuthController::class, 'store'])->name('register.store');

// Logout (digunakan oleh admin panel)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auth Admin Panel (Yang digunakan sekarang)
Route::get('/cpanel/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::post('/cpanel/login', [AuthController::class, 'adminAuthenticate'])->name('admin.login.attempt');

// Under Construction
Route::get('/under-construction', [UnderConstructionController::class, 'index'])->name('under-construction');
Route::get('/social-media-unavailable', [UnderConstructionController::class, 'socialMediaUnavailable'])->name('social-media-unavailable');

// Admin CMS
Route::middleware('auth')->prefix('cpanel')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.update');
    Route::get('/change-username', [AuthController::class, 'showChangeUsername'])->name('change-username');
    Route::post('/change-username', [AuthController::class, 'changeUsername'])->name('change-username.update');
    // Publikasi (gabungan Berita dan Artikel)
    Route::get('publikasi', [\App\Http\Controllers\Admin\PublikasiController::class, 'index'])->name('publikasi.index');

    // Berita (legacy - keep for backward compatibility)
    Route::get('berita', function (\Illuminate\Http\Request $request) {
        $params = $request->query();
        $params['type'] = 'berita';
        return redirect()->route('admin.publikasi.index', $params);
    })->name('berita.index');
    Route::get('berita/create', [PostController::class, 'create'])->name('berita.create');
    Route::post('berita', [PostController::class, 'store'])->name('berita.store');
    Route::get('berita/{post}/edit', [PostController::class, 'edit'])->name('berita.edit');
    Route::put('berita/{post}', [PostController::class, 'update'])->name('berita.update');
    Route::patch('berita/{post}', [PostController::class, 'update'])->name('berita.update');
    Route::delete('berita/{post}', [PostController::class, 'destroy'])->name('berita.destroy');

    // Artikel (legacy - keep for backward compatibility)
    Route::get('artikel', function (\Illuminate\Http\Request $request) {
        $params = $request->query();
        $params['type'] = 'artikel';
        return redirect()->route('admin.publikasi.index', $params);
    })->name('artikel.index');
    Route::get('artikel/create', [PostController::class, 'create'])->name('artikel.create');
    Route::post('artikel', [PostController::class, 'store'])->name('artikel.store');
    Route::get('artikel/{post}/edit', [PostController::class, 'edit'])->name('artikel.edit');
    Route::put('artikel/{post}', [PostController::class, 'update'])->name('artikel.update');
    Route::patch('artikel/{post}', [PostController::class, 'update'])->name('artikel.update');
    Route::delete('artikel/{post}', [PostController::class, 'destroy'])->name('artikel.destroy');
    Route::post('banners/settings', [BannerController::class, 'updateSettings'])->name('banners.settings.update');
    Route::post('banners/upload', [BannerController::class, 'upload'])->name('banners.upload');
    Route::post('banners/upload-promosi', [BannerController::class, 'uploadPromosi'])->name('banners.upload-promosi');
    Route::delete('banners/delete-promosi', [BannerController::class, 'deletePromosi'])->name('banners.delete-promosi');
    Route::patch('banners/update-order', [BannerController::class, 'updateOrder'])->name('banners.update-order');
    Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
    Route::resource('banners', BannerController::class)->only(['index', 'destroy']);
    Route::resource('foto-kegiatan', FotoKegiatanController::class);
    // Editor image upload (used by Summernote)
    Route::post('uploads/images', [ImageUploadController::class, 'store'])->name('uploads.images');
    Route::resource('prestasi-siswa', PrestasiSiswaController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('agenda', AgendaController::class);
    Route::resource('kontak', KontakController::class);
    Route::resource('info-sekolah', InfoSekolahController::class);
    // Profil Sekolah (gabungan)
    Route::get('profil-sekolah', [\App\Http\Controllers\Admin\ProfilSekolahController::class, 'index'])->name('profil-sekolah.index');
    Route::put('profil-sekolah', [\App\Http\Controllers\Admin\ProfilSekolahController::class, 'update'])->name('profil-sekolah.update');
    // Profil (legacy - keep for backward compatibility)
    Route::get('profil/visi-misi', [AdminProfilController::class, 'visiMisi'])->name('profil.visi-misi');
    Route::put('profil/visi-misi', [AdminProfilController::class, 'updateVisiMisi'])->name('profil.visi-misi.update');
    Route::get('profil/tujuan', [AdminProfilController::class, 'tujuan'])->name('profil.tujuan');
    Route::put('profil/tujuan', [AdminProfilController::class, 'updateTujuan'])->name('profil.tujuan.update');
    Route::get('profil/kepala-madrasah', [AdminProfilController::class, 'kepalaMadrasah'])->name('profil.kepala-madrasah');
    Route::put('profil/kepala-madrasah', [AdminProfilController::class, 'updateKepalaMadrasah'])->name('profil.kepala-madrasah.update');
    // Tampilan Web (gabungan Banner, Logo, Top Bar)
    Route::get('tampilan-web', [\App\Http\Controllers\Admin\TampilanWebController::class, 'index'])->name('tampilan-web.index');
    Route::put('tampilan-web', [\App\Http\Controllers\Admin\TampilanWebController::class, 'update'])->name('tampilan-web.update');

    // Info Kontak (gabungan Kontak dan Footer)
    Route::get('info-kontak', [\App\Http\Controllers\Admin\InfoKontakController::class, 'index'])->name('info-kontak.index');
    Route::put('info-kontak', [\App\Http\Controllers\Admin\InfoKontakController::class, 'update'])->name('info-kontak.update');

    // Site settings (legacy - keep for backward compatibility)
    Route::get('settings/logo', [SettingController::class, 'logo'])->name('settings.logo');
    Route::post('settings/logo', [SettingController::class, 'updateLogo'])->name('settings.logo.update');
    Route::get('settings/top-bar', [TopBarController::class, 'index'])->name('settings.top-bar');
    Route::put('settings/top-bar', [TopBarController::class, 'update'])->name('settings.top-bar.update');
    // Comments
    Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
    Route::patch('comments/{comment}/read', [AdminCommentController::class, 'markAsRead'])->name('comments.read');
    Route::post('comments/mark-all-read', [AdminCommentController::class, 'markAllAsRead'])->name('comments.mark-all-read');
    Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});
