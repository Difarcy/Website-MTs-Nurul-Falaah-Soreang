<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FotoKegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoKegiatanController extends Controller
{
    public function index()
    {
        $fotos = FotoKegiatan::ordered()->paginate(12);
        return view('admin.foto-kegiatan.index', compact('fotos'));
    }

    public function create()
    {
        return view('admin.foto-kegiatan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:5120',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('foto-kegiatan', 'public');
        } else {
            $validated['gambar'] = null;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        FotoKegiatan::create($validated);

        return redirect()->route('admin.foto-kegiatan.index')
            ->with('status', 'Foto kegiatan berhasil ditambahkan.');
    }

    public function edit(FotoKegiatan $fotoKegiatan)
    {
        return view('admin.foto-kegiatan.edit', compact('fotoKegiatan'));
    }

    public function update(Request $request, FotoKegiatan $fotoKegiatan): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:5120',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($fotoKegiatan->gambar) {
                Storage::disk('public')->delete($fotoKegiatan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('foto-kegiatan', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? $fotoKegiatan->urutan;

        $fotoKegiatan->update($validated);

        return redirect()->route('admin.foto-kegiatan.index')
            ->with('status', 'Foto kegiatan berhasil diperbarui.');
    }

    public function destroy(FotoKegiatan $fotoKegiatan): RedirectResponse
    {
        if ($fotoKegiatan->gambar) {
            Storage::disk('public')->delete($fotoKegiatan->gambar);
        }
        $fotoKegiatan->delete();

        return redirect()->route('admin.foto-kegiatan.index')
            ->with('status', 'Foto kegiatan berhasil dihapus.');
    }
}
