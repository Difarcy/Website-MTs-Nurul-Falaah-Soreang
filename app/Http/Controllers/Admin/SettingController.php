<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function logo()
    {
        $settings = SiteSetting::first();
        return view('admin.settings.logo', compact('settings'));
    }

    public function updateLogo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
        ]);

        $settings = SiteSetting::first() ?? new SiteSetting();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $path = $request->file('logo')->store('site', 'public');
            $settings->logo_path = $path;
        }

        $settings->save();

        return redirect()
            ->route('admin.settings.logo')
            ->with('status', 'Logo berhasil diperbarui. Semua halaman akan menggunakan logo baru.');
    }
}


