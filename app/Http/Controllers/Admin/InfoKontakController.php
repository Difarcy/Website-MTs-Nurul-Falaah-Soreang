<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Models\InfoText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InfoKontakController extends Controller
{
    public function index(): View
    {
        $kontaks = Kontak::ordered()->get();
        
        // Get footer settings from InfoText
        $alamat = InfoText::where('key', 'footer_alamat')->firstOrCreate(['key' => 'footer_alamat'], ['value' => 'Jalan Soreang Banjaran, Kampung Ciwaru RT. 01/RW. 16, Kelurahan Soreang, Kecamatan Soreang, Kabupaten Bandung, Provinsi Jawa Barat 40911, Indonesia', 'deskripsi' => 'Alamat Footer']);
        $email = InfoText::where('key', 'footer_email')->firstOrCreate(['key' => 'footer_email'], ['value' => 'info@mtsnurulfalaahsoreang.sch.id', 'deskripsi' => 'Email Footer']);
        $whatsapp = InfoText::where('key', 'footer_whatsapp')->firstOrCreate(['key' => 'footer_whatsapp'], ['value' => '+62 812-3456-7890', 'deskripsi' => 'WhatsApp Footer']);
        $facebookUrl = InfoText::where('key', 'footer_facebook_url')->firstOrCreate(['key' => 'footer_facebook_url'], ['value' => '', 'deskripsi' => 'Facebook URL Footer']);
        $instagramUrl = InfoText::where('key', 'footer_instagram_url')->firstOrCreate(['key' => 'footer_instagram_url'], ['value' => '', 'deskripsi' => 'Instagram URL Footer']);
        $youtubeUrl = InfoText::where('key', 'footer_youtube_url')->firstOrCreate(['key' => 'footer_youtube_url'], ['value' => '', 'deskripsi' => 'YouTube URL Footer']);
        $tiktokUrl = InfoText::where('key', 'footer_tiktok_url')->firstOrCreate(['key' => 'footer_tiktok_url'], ['value' => '', 'deskripsi' => 'TikTok URL Footer']);

        return view('admin.info-kontak.index', compact('kontaks', 'alamat', 'email', 'whatsapp', 'facebookUrl', 'instagramUrl', 'youtubeUrl', 'tiktokUrl'));
    }

    public function update(Request $request): RedirectResponse
    {
        // Update Kontak
        if ($request->has('kontak')) {
            foreach ($request->input('kontak', []) as $kontakData) {
                if (isset($kontakData['id']) && $kontakData['id']) {
                    $kontak = Kontak::find($kontakData['id']);
                    if ($kontak) {
                        $kontak->update([
                            'jenis' => $kontakData['jenis'] ?? $kontak->jenis,
                            'label' => $kontakData['label'] ?? $kontak->label,
                            'nilai' => $kontakData['nilai'] ?? $kontak->nilai,
                            'icon' => $kontakData['icon'] ?? $kontak->icon,
                            'urutan' => $kontakData['urutan'] ?? $kontak->urutan,
                            'is_active' => isset($kontakData['is_active']),
                        ]);
                    }
                }
            }
        }

        // Update Footer Settings
        $validated = $request->validate([
            'footer_alamat' => 'nullable|string|max:500',
            'footer_email' => 'nullable|email|max:255',
            'footer_whatsapp' => 'nullable|string|max:50',
            'footer_facebook_url' => 'nullable|url|max:255',
            'footer_instagram_url' => 'nullable|url|max:255',
            'footer_youtube_url' => 'nullable|url|max:255',
            'footer_tiktok_url' => 'nullable|url|max:255',
        ]);

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                InfoText::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'deskripsi' => ucfirst(str_replace('_', ' ', $key))]
                );
            }
        }

        return redirect()->route('admin.info-kontak.index')
            ->with('status', 'Info kontak berhasil diperbarui.');
    }
}

