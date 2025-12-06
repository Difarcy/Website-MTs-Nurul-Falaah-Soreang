<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Banner;
use App\Models\FotoKegiatan;
use App\Models\PrestasiSiswa;
use App\Models\Pengumuman;
use App\Models\Agenda;
use App\Models\Kontak;
use App\Models\InfoText;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_berita' => Post::where('type', 'berita')->count(),
            'published_berita' => Post::where('type', 'berita')->published()->count(),
            'total_artikel' => Post::where('type', 'artikel')->count(),
            'published_artikel' => Post::where('type', 'artikel')->published()->count(),
            'latest_posts' => Post::latest('updated_at')->take(5)->get(),
            'total_banners' => Banner::count(),
            'active_banners' => Banner::active()->count(),
            'total_fotos' => FotoKegiatan::count(),
            'active_fotos' => FotoKegiatan::active()->count(),
            'total_prestasi' => PrestasiSiswa::count(),
            'active_prestasi' => PrestasiSiswa::active()->count(),
            'total_pengumuman' => Pengumuman::count(),
            'active_pengumuman' => Pengumuman::active()->count(),
            'total_agenda' => Agenda::count(),
            'active_agenda' => Agenda::active()->count(),
            'total_kontak' => Kontak::count(),
            'active_kontak' => Kontak::active()->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
