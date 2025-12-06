<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RunningText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RunningTextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $runningTexts = RunningText::ordered()->get();
        return view('admin.running-texts.index', compact('runningTexts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:500'],
        ], [
            'text.required' => 'Text berjalan wajib diisi.',
            'text.max' => 'Text berjalan maksimal 500 karakter.',
        ]);

        // Hitung urutan berikutnya
        $maxUrutan = RunningText::max('urutan') ?? 0;
        $newUrutan = $maxUrutan + 1;

        RunningText::create([
            'text' => $validated['text'],
            'urutan' => $newUrutan,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.running-texts.index')
            ->with('status', 'Text berjalan berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RunningText $runningText): RedirectResponse
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:500'],
        ], [
            'text.required' => 'Text berjalan wajib diisi.',
            'text.max' => 'Text berjalan maksimal 500 karakter.',
        ]);

        $runningText->update($validated);

        return redirect()
            ->route('admin.running-texts.index')
            ->with('status', 'Text berjalan berhasil diperbarui.');
    }

    /**
     * Update running text order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:running_texts,id',
            'order.*.urutan' => 'required|integer|min:1',
        ]);

        foreach ($request->order as $item) {
            RunningText::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle running text active status
     */
    public function toggle(RunningText $runningText): RedirectResponse
    {
        $runningText->update([
            'is_active' => !$runningText->is_active,
        ]);

        $status = $runningText->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->route('admin.running-texts.index')
            ->with('status', "Text berjalan berhasil {$status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RunningText $runningText): RedirectResponse
    {
        $runningText->delete();

        return redirect()
            ->route('admin.running-texts.index')
            ->with('status', 'Text berjalan berhasil dihapus.');
    }
}
