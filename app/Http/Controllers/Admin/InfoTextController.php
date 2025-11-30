<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InfoTextController extends Controller
{
    public function index()
    {
        $infoTexts = InfoText::orderBy('key')->get();
        return view('admin.info-text.index', compact('infoTexts'));
    }

    public function create()
    {
        return view('admin.info-text.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:info_texts,key',
            'value' => 'required|string',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        InfoText::create($validated);

        return redirect()->route('admin.info-text.index')
            ->with('status', 'Info text berhasil ditambahkan.');
    }

    public function edit(InfoText $infoText)
    {
        return view('admin.info-text.edit', compact('infoText'));
    }

    public function update(Request $request, InfoText $infoText): RedirectResponse
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:info_texts,key,' . $infoText->id,
            'value' => 'required|string',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $infoText->update($validated);

        return redirect()->route('admin.info-text.index')
            ->with('status', 'Info text berhasil diperbarui.');
    }

    public function destroy(InfoText $infoText): RedirectResponse
    {
        $infoText->delete();
        return redirect()->route('admin.info-text.index')
            ->with('status', 'Info text berhasil dihapus.');
    }
}
