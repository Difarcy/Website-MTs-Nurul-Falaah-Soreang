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

        // Ticker otomatis - ambil 4 item terbaru dari berbagai sumber
        $tickerItems = collect();
        
        // Ambil berita terbaru
        $beritaTicker = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(2)
            ->get()
            ->map(fn($item) => ['text' => $item->title, 'date' => $item->published_at]);
        
        // Ambil artikel terbaru
        $artikelTicker = Post::published()
            ->ofType('artikel')
            ->latest('published_at')
            ->take(2)
            ->get()
            ->map(fn($item) => ['text' => $item->title, 'date' => $item->published_at]);
        
        // Ambil pengumuman terbaru
        $pengumumanTicker = Pengumuman::active()
            ->latest('tanggal')
            ->take(2)
            ->get()
            ->map(fn($item) => ['text' => $item->judul, 'date' => $item->tanggal]);
        
        // Ambil agenda terbaru yang akan datang
        $agendaTicker = Agenda::active()
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai')
            ->take(2)
            ->get()
            ->map(fn($item) => ['text' => $item->judul, 'date' => $item->tanggal_mulai]);
        
        // Gabungkan semua, urutkan berdasarkan tanggal terbaru, ambil 4 item terbaru
        $tickerItems = $beritaTicker
            ->concat($artikelTicker)
            ->concat($pengumumanTicker)
            ->concat($agendaTicker)
            ->filter() // Hapus item kosong
            ->sortByDesc('date') // Urutkan dari terbaru
            ->take(4)
            ->pluck('text') // Ambil hanya teksnya
            ->filter(); // Hapus item kosong lagi setelah pluck

        // Ambil banner promosi
        $bannerPromosi = BannerSetting::first();
        $promosiBannerPath = $bannerPromosi?->promosi_banner_path;

        return view('home', compact('banners', 'latestNews', 'latestArticles', 'fotoKegiatan', 'prestasiSiswa', 'infoTerkini', 'agendaTerbaru', 'lastPostUpdate', 'tickerItems', 'promosiBannerPath'));
    }
}

