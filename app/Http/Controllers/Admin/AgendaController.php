<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::ordered()->paginate(10);
        return view('admin.agenda.index', compact('agenda'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'nullable|string|max:255',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')
            ->with('status', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'nullable|string|max:255',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? $agenda->urutan;

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')
            ->with('status', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();
        return redirect()->route('admin.agenda.index')
            ->with('status', 'Agenda berhasil dihapus.');
    }
}
