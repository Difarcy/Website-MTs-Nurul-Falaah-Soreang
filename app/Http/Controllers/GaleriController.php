<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        return view('galeri');
    }

    public function fotoKegiatan()
    {
        return view('galeri.foto-kegiatan');
    }

    public function dokumentasi()
    {
        return view('galeri.dokumentasi');
    }

    public function prestasiSiswa()
    {
        return view('galeri.prestasi-siswa');
    }
}

