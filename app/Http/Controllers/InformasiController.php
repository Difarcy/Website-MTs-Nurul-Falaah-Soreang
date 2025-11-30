<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Pengumuman;
use App\Models\Agenda;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function berita(Request $request)
    {
        $posts = Post::published()
            ->ofType('berita')
            ->search($request->input('q'))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $sidebarArticles = Post::published()
            ->ofType('artikel')
            ->latest('published_at')
            ->take(4)
            ->get();

        $infoTerkini = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('informasi.berita', compact('posts', 'sidebarArticles', 'infoTerkini'));
    }

    public function artikel(Request $request)
    {
        $posts = Post::published()
            ->ofType('artikel')
            ->search($request->input('q'))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $sidebarNews = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(4)
            ->get();

        $infoTerkini = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('informasi.artikel', compact('posts', 'sidebarNews', 'infoTerkini'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::active()->ordered()->paginate(10);
        return view('pengumuman', compact('pengumuman'));
    }

    public function agenda()
    {
        $agenda = Agenda::active()->ordered()->get();
        return view('informasi.agenda', compact('agenda'));
    }

    public function show(string $type, string $slug)
    {
        abort_unless(in_array($type, ['berita', 'artikel']), 404);

        $post = Post::published()
            ->ofType($type)
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::published()
            ->ofType($type)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('informasi.detail', compact('post', 'related'));
    }
}

