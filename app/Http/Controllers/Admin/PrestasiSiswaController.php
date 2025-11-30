<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaController extends Controller
{
    public function index()
    {
        $prestasi = PrestasiSiswa::ordered()->paginate(12);
        return view('admin.prestasi-siswa.index', compact('prestasi'));
    }

    public function create()
    {
        return view('admin.prestasi-siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:5120',
            'kategori' => 'nullable|string|max:100',
            'tanggal_prestasi' => 'nullable|date',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('prestasi-siswa', 'public');
        } else {
            $validated['gambar'] = null;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        PrestasiSiswa::create($validated);

        return redirect()->route('admin.prestasi-siswa.index')
            ->with('status', 'Prestasi siswa berhasil ditambahkan.');
    }

    public function edit(PrestasiSiswa $prestasiSiswa)
    {
        return view('admin.prestasi-siswa.edit', compact('prestasiSiswa'));
    }

    public function update(Request $request, PrestasiSiswa $prestasiSiswa): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:5120',
            'kategori' => 'nullable|string|max:100',
            'tanggal_prestasi' => 'nullable|date',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($prestasiSiswa->gambar) {
                Storage::disk('public')->delete($prestasiSiswa->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('prestasi-siswa', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? $prestasiSiswa->urutan;

        $prestasiSiswa->update($validated);

        return redirect()->route('admin.prestasi-siswa.index')
            ->with('status', 'Prestasi siswa berhasil diperbarui.');
    }

    public function destroy(PrestasiSiswa $prestasiSiswa): RedirectResponse
    {
        if ($prestasiSiswa->gambar) {
            Storage::disk('public')->delete($prestasiSiswa->gambar);
        }
        $prestasiSiswa->delete();

        return redirect()->route('admin.prestasi-siswa.index')
            ->with('status', 'Prestasi siswa berhasil dihapus.');
    }
}
