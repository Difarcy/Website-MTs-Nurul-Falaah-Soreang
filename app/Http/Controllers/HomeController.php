<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Banner;
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

        return view('home', compact('banners', 'latestNews', 'latestArticles', 'fotoKegiatan', 'prestasiSiswa', 'infoTerkini', 'agendaTerbaru', 'lastPostUpdate'));
    }
}

