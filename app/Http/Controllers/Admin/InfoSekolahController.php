<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoSekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InfoSekolahController extends Controller
{
    public function index()
    {
        $infos = InfoSekolah::ordered()->get();
        return view('admin.info-sekolah.index', compact('infos'));
    }

    public function create()
    {
        return view('admin.info-sekolah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:info_sekolahs,key',
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,image',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        InfoSekolah::create($validated);

        return redirect()->route('admin.info-sekolah.index')
            ->with('status', 'Info sekolah berhasil ditambahkan.');
    }

    public function edit(InfoSekolah $infoSekolah)
    {
        return view('admin.info-sekolah.edit', compact('infoSekolah'));
    }

    public function update(Request $request, InfoSekolah $infoSekolah): RedirectResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:info_sekolahs,key,' . $infoSekolah->id,
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,image',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? $infoSekolah->urutan;

        $infoSekolah->update($validated);

        return redirect()->route('admin.info-sekolah.index')
            ->with('status', 'Info sekolah berhasil diperbarui.');
    }

    public function destroy(InfoSekolah $infoSekolah): RedirectResponse
    {
        $infoSekolah->delete();
        return redirect()->route('admin.info-sekolah.index')
            ->with('status', 'Info sekolah berhasil dihapus.');
    }
}
