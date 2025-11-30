<?php

namespace App\Http\Controllers;

use App\Models\PrestasiSiswa;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('tentang-sekolah');
    }

    public function informasiSekolah()
    {
        return view('profil.informasi-sekolah');
    }

    public function visiMisi()
    {
        return view('profil.visi-misi');
    }

    public function sejarah()
    {
        return view('profil.sejarah');
    }

    public function strukturOrganisasi()
    {
        return view('profil.struktur-organisasi');
    }

    public function kepalaSekolahGuru()
    {
        return view('profil.kepala-sekolah-guru');
    }

    public function prestasi()
    {
        $prestasi = PrestasiSiswa::active()->ordered()->paginate(12);
        return view('profil.prestasi', compact('prestasi'));
    }
}

