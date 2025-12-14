<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // Visi & Misi
    public function visiMisi()
    {
        $visi = InfoText::where('key', 'visi')->first();
        $misi = InfoText::where('key', 'misi')->first();
        
        return view('admin.profil.visi-misi', compact('visi', 'misi'));
    }

    public function updateVisiMisi(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        InfoText::updateOrCreate(
            ['key' => 'visi'],
            ['value' => $validated['visi'], 'deskripsi' => 'Visi MTs Nurul Falaah Soreang']
        );

        InfoText::updateOrCreate(
            ['key' => 'misi'],
            ['value' => $validated['misi'], 'deskripsi' => 'Misi MTs Nurul Falaah Soreang']
        );

        return redirect()->route('admin.profil.visi-misi')
            ->with('status', 'Visi & Misi berhasil diperbarui.');
    }

    // Tujuan
    public function tujuan()
    {
        $tujuan = InfoText::where('key', 'tujuan')->first();
        
        return view('admin.profil.tujuan', compact('tujuan'));
    }

    public function updateTujuan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tujuan' => 'required|string',
        ]);

        InfoText::updateOrCreate(
            ['key' => 'tujuan'],
            ['value' => $validated['tujuan'], 'deskripsi' => 'Tujuan MTs Nurul Falaah Soreang']
        );

        return redirect()->route('admin.profil.tujuan')
            ->with('status', 'Tujuan berhasil diperbarui.');
    }

    // Kepala Madrasah
    public function kepalaMadrasah()
    {
        $kepalaMadrasah = InfoText::where('key', 'kepala_madrasah')->first();
        $sambutan = InfoText::where('key', 'sambutan_kepala_madrasah')->first();
        
        return view('admin.profil.kepala-madrasah', compact('kepalaMadrasah', 'sambutan'));
    }

    public function updateKepalaMadrasah(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'sambutan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update nama kepala madrasah
        InfoText::updateOrCreate(
            ['key' => 'kepala_madrasah'],
            ['value' => $validated['nama'], 'deskripsi' => 'Nama Kepala Madrasah']
        );

        // Update sambutan
        InfoText::updateOrCreate(
            ['key' => 'sambutan_kepala_madrasah'],
            ['value' => $validated['sambutan'], 'deskripsi' => 'Sambutan Kepala Madrasah']
        );

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('public/kepala-madrasah');
            $fotoUrl = str_replace('public/', '', $fotoPath);
            
            // Delete old foto if exists
            $oldFoto = InfoText::where('key', 'foto_kepala_madrasah')->first();
            if ($oldFoto && $oldFoto->value) {
                Storage::delete('public/' . $oldFoto->value);
            }
            
            InfoText::updateOrCreate(
                ['key' => 'foto_kepala_madrasah'],
                ['value' => $fotoUrl, 'deskripsi' => 'Foto Kepala Madrasah']
            );
        }

        return redirect()->route('admin.profil.kepala-madrasah')
            ->with('status', 'Data Kepala Madrasah berhasil diperbarui.');
    }
}

