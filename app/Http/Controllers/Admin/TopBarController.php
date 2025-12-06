<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopBarSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopBarController extends Controller
{
    public function index()
    {
        $settings = TopBarSetting::first();

        if (!$settings) {
            $settings = new TopBarSetting([
                'phone' => '0852 2017 7167',
                'email' => 'info@mtsnurulfalaahsoreang.sch.id',
            ]);
        }

        return view('admin.settings.top-bar', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'facebook_url' => 'nullable|url|max:150',
            'instagram_url' => 'nullable|url|max:150',
            'youtube_url' => 'nullable|url|max:150',
            'tiktok_url' => 'nullable|url|max:150',
        ]);

        $settings = TopBarSetting::first();

        if (!$settings) {
            $settings = new TopBarSetting();
        }

        $settings->fill($validated);
        $settings->save();

        // Redirect ke URL yang diminta jika ada, atau ke halaman top bar
        $redirectUrl = $request->input('_redirect_after_save');
        if ($redirectUrl) {
            return redirect($redirectUrl)
                ->with('status', 'Informasi top bar berhasil diperbarui.');
        }

        return redirect()
            ->route('admin.settings.top-bar')
            ->with('status', 'Informasi top bar berhasil diperbarui.');
    }
}
