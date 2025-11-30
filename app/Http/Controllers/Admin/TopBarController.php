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
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'tiktok_url' => 'nullable|url|max:500',
        ]);

        $settings = TopBarSetting::first();

        if (!$settings) {
            $settings = new TopBarSetting();
        }

        $settings->fill($validated);
        $settings->save();

        return redirect()
            ->route('admin.settings.top-bar')
            ->with('status', 'Informasi top bar berhasil diperbarui.');
    }
}
