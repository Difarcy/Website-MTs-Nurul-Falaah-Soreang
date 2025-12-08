<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Models\FotoKegiatan;
use App\Models\PrestasiSiswa;
use App\Models\Pengumuman;
use App\Models\Agenda;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->ordered()->get();
        // Highlight news - trending/popular news (based on view count or recent)
        $highlightNews = Post::published()
            ->ofType('berita')
            ->orderBy('view_count', 'desc') // Prioritize by view count
            ->orderBy('published_at', 'desc') // Then by date
            ->take(5)
            ->get();

        $latestNews = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(4)
            ->get();

        $latestArticles = Post::published()
            ->ofType('artikel')
            ->latest('published_at')
            ->take(4)
            ->get();

        $fotoKegiatan = FotoKegiatan::active()->ordered()->take(6)->get();
        $prestasiSiswa = PrestasiSiswa::active()->ordered()->take(4)->get();

        $infoTerkini = Pengumuman::active()->ordered()->latest('tanggal')->take(4)->get();
        $agendaTerbaru = Agenda::active()->ordered()->where('tanggal_mulai', '>=', now())->orderBy('tanggal_mulai')->take(5)->get();

        // Timestamp terakhir update untuk auto-refresh
        $lastPostUpdate = Post::published()->max('updated_at')?->timestamp ?? time();

        // Ticker otomatis - 3 berita terbaru, 1 artikel, 1 pengumuman (total 5 item)
        $tickerItems = collect();

        // Ambil 3 berita terbaru
        $beritaTicker = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn($item) => ['text' => $item->title, 'date' => $item->published_at]);

        // Ambil 1 artikel terbaru
        $artikelTicker = Post::published()
            ->ofType('artikel')
            ->latest('published_at')
            ->take(1)
            ->get()
            ->map(fn($item) => ['text' => $item->title, 'date' => $item->published_at]);

        // Ambil 1 pengumuman terbaru
        $pengumumanTicker = Pengumuman::active()
            ->latest('tanggal')
            ->take(1)
            ->get()
            ->map(fn($item) => ['text' => $item->judul, 'date' => $item->tanggal]);

        // Gabungkan semua (3 berita + 1 artikel + 1 pengumuman = 5 total)
        $tickerItems = $beritaTicker
            ->concat($artikelTicker)
            ->concat($pengumumanTicker)
            ->filter() // Hapus item kosong
            ->sortByDesc('date') // Urutkan dari terbaru
            ->take(5) // Ambil 5 item terbaru
            ->pluck('text') // Ambil hanya teksnya
            ->filter(); // Hapus item kosong lagi setelah pluck

        // Ambil banner promosi
        $bannerPromosi = BannerSetting::first();
        $promosiBannerPath = $bannerPromosi?->promosi_banner_path;

        return view('home', compact('banners', 'highlightNews', 'latestNews', 'latestArticles', 'fotoKegiatan', 'prestasiSiswa', 'infoTerkini', 'agendaTerbaru', 'lastPostUpdate', 'tickerItems', 'promosiBannerPath'));
    }
}

