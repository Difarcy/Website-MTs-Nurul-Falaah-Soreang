<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $kontaks = Kontak::ordered()->paginate(10);
        return view('admin.kontak.index', compact('kontaks'));
    }

    public function create()
    {
        return view('admin.kontak.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'nilai' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Kontak::create($validated);

        return redirect()->route('admin.kontak.index')
            ->with('status', 'Kontak berhasil ditambahkan.');
    }

    public function edit(Kontak $kontak)
    {
        return view('admin.kontak.edit', compact('kontak'));
    }

    public function update(Request $request, Kontak $kontak): RedirectResponse
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'nilai' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? $kontak->urutan;

        $kontak->update($validated);

        return redirect()->route('admin.kontak.index')
            ->with('status', 'Kontak berhasil diperbarui.');
    }

    public function destroy(Kontak $kontak): RedirectResponse
    {
        $kontak->delete();
        return redirect()->route('admin.kontak.index')
            ->with('status', 'Kontak berhasil dihapus.');
    }
}
