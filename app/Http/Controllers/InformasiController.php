<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function berita()
    {
        return view('informasi.berita');
    }

    public function artikel()
    {
        return view('informasi.artikel');
    }

    public function pengumuman()
    {
        return view('pengumuman');
    }

    public function agenda()
    {
        return view('informasi.agenda');
    }
}

