<?php

namespace App\Http\Controllers;

use App\Models\FotoKegiatan;
use App\Models\PrestasiSiswa;

class GaleriController extends Controller
{
    public function index()
    {
        return view('galeri');
    }

    public function fotoKegiatan()
    {
        $fotos = FotoKegiatan::active()->ordered()->paginate(12);
        return view('galeri.foto-kegiatan', compact('fotos'));
    }

    public function dokumentasi()
    {
        return view('galeri.dokumentasi');
    }

    public function prestasiSiswa()
    {
        $prestasi = PrestasiSiswa::active()->ordered()->paginate(12);
        return view('galeri.prestasi-siswa', compact('prestasi'));
    }
}

