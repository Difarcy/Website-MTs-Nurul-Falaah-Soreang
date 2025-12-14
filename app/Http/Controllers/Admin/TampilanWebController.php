<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Models\SiteSetting;
use App\Models\TopBarSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TampilanWebController extends Controller
{
    public function index(): View
    {
        $banners = Banner::ordered()->get();
        $bannerSettings = BannerSetting::first();
        if (!$bannerSettings) {
            $bannerSettings = new BannerSetting([
                'show_logo' => true,
                'show_tagline' => true,
                'show_title' => true,
                'show_description' => true,
                'show_button' => true,
            ]);
        }

        $siteSettings = SiteSetting::first();
        $topBarSettings = TopBarSetting::first();
        if (!$topBarSettings) {
            $topBarSettings = new TopBarSetting([
                'phone' => '0852 2017 7167',
                'email' => 'info@mtsnurulfalaahsoreang.sch.id',
            ]);
        }

        return view('admin.tampilan-web.index', compact('banners', 'bannerSettings', 'siteSettings', 'topBarSettings'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Update Banner Settings
        if ($request->has('banner_settings')) {
            $bannerValidated = $request->validate([
                'banner_settings.tagline' => 'nullable|string|max:150',
                'banner_settings.judul' => 'nullable|string|max:150',
                'banner_settings.deskripsi' => 'nullable|string|max:200',
                'banner_settings.link' => 'nullable|url|max:150',
                'banner_settings.button_text' => 'nullable|string|max:150',
                'banner_settings.show_logo' => 'boolean',
                'banner_settings.show_tagline' => 'boolean',
                'banner_settings.show_title' => 'boolean',
                'banner_settings.show_description' => 'boolean',
                'banner_settings.show_button' => 'boolean',
            ]);

            $bannerSettings = BannerSetting::first();
            if (!$bannerSettings) {
                $bannerSettings = new BannerSetting();
            }
            $bannerSettings->fill($bannerValidated['banner_settings']);
            $bannerSettings->save();
        }

        // Update Logo
        if ($request->hasFile('logo')) {
            $logoValidated = $request->validate([
                'logo' => 'required|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
            ]);

            $siteSettings = SiteSetting::first() ?? new SiteSetting();
            if ($siteSettings->logo_path) {
                Storage::disk('public')->delete($siteSettings->logo_path);
            }
            $path = $request->file('logo')->store('site', 'public');
            $siteSettings->logo_path = $path;
            $siteSettings->save();
        }

        // Update Top Bar Settings
        if ($request->has('top_bar')) {
            $topBarValidated = $request->validate([
                'top_bar.phone' => 'nullable|string|max:20',
                'top_bar.email' => 'nullable|email|max:50',
                'top_bar.facebook_url' => 'nullable|url|max:150',
                'top_bar.instagram_url' => 'nullable|url|max:150',
                'top_bar.youtube_url' => 'nullable|url|max:150',
                'top_bar.tiktok_url' => 'nullable|url|max:150',
            ]);

            $topBarSettings = TopBarSetting::first();
            if (!$topBarSettings) {
                $topBarSettings = new TopBarSetting();
            }
            $topBarSettings->fill($topBarValidated['top_bar']);
            $topBarSettings->save();
        }

        return redirect()->route('admin.tampilan-web.index')
            ->with('status', 'Pengaturan tampilan web berhasil diperbarui.');
    }
}

