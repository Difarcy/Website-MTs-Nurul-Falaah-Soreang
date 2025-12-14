<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoSekolah;
use App\Models\InfoText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilSekolahController extends Controller
{
    public function index(): View
    {
        // Get all data
        $infos = InfoSekolah::ordered()->get();
        $visi = InfoText::where('key', 'visi')->firstOrCreate(['key' => 'visi'], ['value' => '', 'deskripsi' => 'Visi Madrasah']);
        $misi = InfoText::where('key', 'misi')->firstOrCreate(['key' => 'misi'], ['value' => '', 'deskripsi' => 'Misi Madrasah']);
        $tujuan = InfoText::where('key', 'tujuan')->firstOrCreate(['key' => 'tujuan'], ['value' => '', 'deskripsi' => 'Tujuan Madrasah']);
        $kepalaMadrasahNama = InfoText::where('key', 'kepala_madrasah_nama')->firstOrCreate(['key' => 'kepala_madrasah_nama'], ['value' => '', 'deskripsi' => 'Nama Kepala Madrasah']);
        $kepalaMadrasahSambutan = InfoText::where('key', 'kepala_madrasah_sambutan')->firstOrCreate(['key' => 'kepala_madrasah_sambutan'], ['value' => '', 'deskripsi' => 'Sambutan Kepala Madrasah']);
        $kepalaMadrasahFoto = InfoText::where('key', 'kepala_madrasah_foto')->firstOrCreate(['key' => 'kepala_madrasah_foto'], ['value' => '', 'deskripsi' => 'Foto Kepala Madrasah']);
        $strukturOrganisasi = InfoText::where('key', 'struktur_organisasi')->firstOrCreate(['key' => 'struktur_organisasi'], ['value' => '', 'deskripsi' => 'Struktur Organisasi']);

        return view('admin.profil-sekolah.index', compact(
            'infos', 'visi', 'misi', 'tujuan', 
            'kepalaMadrasahNama', 'kepalaMadrasahSambutan', 'kepalaMadrasahFoto',
            'strukturOrganisasi'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Tentang Sekolah
            'info_sekolah' => 'nullable|array',
            'info_sekolah.*.id' => 'nullable|exists:info_sekolahs,id',
            'info_sekolah.*.key' => 'nullable|string|max:100',
            'info_sekolah.*.label' => 'nullable|string|max:255',
            'info_sekolah.*.value' => 'nullable|string',
            'info_sekolah.*.type' => 'nullable|in:text,textarea,image',
            'info_sekolah.*.urutan' => 'nullable|integer|min:0',
            
            // Visi & Misi
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            
            // Tujuan
            'tujuan' => 'nullable|string',
            
            // Kepala Madrasah
            'kepala_madrasah_nama' => 'nullable|string|max:255',
            'kepala_madrasah_sambutan' => 'nullable|string',
            'kepala_madrasah_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
            // Struktur Organisasi
            'struktur_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        // Update Info Sekolah
        if (isset($validated['info_sekolah'])) {
            foreach ($validated['info_sekolah'] as $info) {
                if (isset($info['id']) && $info['id']) {
                    $infoSekolah = InfoSekolah::find($info['id']);
                    if ($infoSekolah) {
                        $infoSekolah->update([
                            'key' => $info['key'] ?? $infoSekolah->key,
                            'label' => $info['label'] ?? $infoSekolah->label,
                            'value' => $info['value'] ?? $infoSekolah->value,
                            'type' => $info['type'] ?? $infoSekolah->type,
                            'urutan' => $info['urutan'] ?? $infoSekolah->urutan,
                        ]);
                    }
                }
            }
        }

        // Update Visi & Misi
        if (isset($validated['visi'])) {
            InfoText::updateOrCreate(['key' => 'visi'], ['value' => $validated['visi'], 'deskripsi' => 'Visi Madrasah']);
        }
        if (isset($validated['misi'])) {
            InfoText::updateOrCreate(['key' => 'misi'], ['value' => $validated['misi'], 'deskripsi' => 'Misi Madrasah']);
        }

        // Update Tujuan
        if (isset($validated['tujuan'])) {
            InfoText::updateOrCreate(['key' => 'tujuan'], ['value' => $validated['tujuan'], 'deskripsi' => 'Tujuan Madrasah']);
        }

        // Update Kepala Madrasah
        if (isset($validated['kepala_madrasah_nama'])) {
            InfoText::updateOrCreate(['key' => 'kepala_madrasah_nama'], ['value' => $validated['kepala_madrasah_nama'], 'deskripsi' => 'Nama Kepala Madrasah']);
        }
        if (isset($validated['kepala_madrasah_sambutan'])) {
            InfoText::updateOrCreate(['key' => 'kepala_madrasah_sambutan'], ['value' => $validated['kepala_madrasah_sambutan'], 'deskripsi' => 'Sambutan Kepala Madrasah']);
        }
        if ($request->hasFile('kepala_madrasah_foto')) {
            $fotoText = InfoText::where('key', 'kepala_madrasah_foto')->first();
            if ($fotoText && $fotoText->value) {
                Storage::disk('public')->delete($fotoText->value);
            }
            $path = $request->file('kepala_madrasah_foto')->store('profil', 'public');
            InfoText::updateOrCreate(['key' => 'kepala_madrasah_foto'], ['value' => $path, 'deskripsi' => 'Foto Kepala Madrasah']);
        }

        // Update Struktur Organisasi
        if ($request->hasFile('struktur_organisasi')) {
            $strukturText = InfoText::where('key', 'struktur_organisasi')->first();
            if ($strukturText && $strukturText->value) {
                Storage::disk('public')->delete($strukturText->value);
            }
            $path = $request->file('struktur_organisasi')->store('profil', 'public');
            InfoText::updateOrCreate(['key' => 'struktur_organisasi'], ['value' => $path, 'deskripsi' => 'Struktur Organisasi']);
        }

        return redirect()->route('admin.profil-sekolah.index')
            ->with('status', 'Profil Sekolah berhasil diperbarui.');
    }
}

