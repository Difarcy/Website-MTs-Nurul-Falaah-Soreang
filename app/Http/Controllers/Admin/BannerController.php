<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::ordered()->get();
        $settings = BannerSetting::first();

        if (! $settings) {
            $settings = new BannerSetting([
                'show_logo' => true,
                'show_tagline' => true,
                'show_title' => true,
                'show_description' => true,
                'show_button' => true,
            ]);
        }

        return view('admin.banners.index', compact('banners', 'settings'));
    }

    /**
     * Update global banner information (used by all slides).
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tagline' => 'nullable|string|max:150',
            'judul' => 'nullable|string|max:150',
            'deskripsi' => 'nullable|string|max:200',
            'link' => 'nullable|url|max:150',
            'button_text' => 'nullable|string|max:150',
            'show_logo' => 'boolean',
            'show_tagline' => 'boolean',
            'show_title' => 'boolean',
            'show_description' => 'boolean',
            'show_button' => 'boolean',
        ]);

        $validated['show_logo'] = $request->has('show_logo');
        $validated['show_tagline'] = $request->has('show_tagline');
        $validated['show_title'] = $request->has('show_title');
        $validated['show_description'] = $request->has('show_description');
        $validated['show_button'] = $request->has('show_button');

        $settings = BannerSetting::first();

        if (! $settings) {
            $settings = new BannerSetting();
        }

        $settings->fill($validated);
        $settings->save();

        // Redirect ke URL yang diminta jika ada, atau ke halaman banner
        $redirectUrl = $request->input('_redirect_after_save');
        if ($redirectUrl) {
            return redirect($redirectUrl)
                ->with('status', 'Informasi banner berhasil disimpan.');
        }

        return redirect()
            ->route('admin.banners.index')
            ->with('status', 'Informasi banner berhasil disimpan.');
    }

    /**
     * Upload banner image (single file)
     */
    public function upload(Request $request): RedirectResponse
    {
        try {
            // Validasi file upload
            $validated = $request->validate([
                'gambar' => 'required|array|min:1',
                'gambar.*' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            ], [
                'gambar.required' => 'Silakan pilih file gambar terlebih dahulu.',
                'gambar.array' => 'Format file tidak valid.',
                'gambar.*.required' => 'File gambar tidak boleh kosong.',
                'gambar.*.image' => 'File harus berupa gambar.',
                'gambar.*.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
                'gambar.*.max' => 'Ukuran file terlalu besar! Maksimal 5MB. Silakan kompres atau pilih file lain.',
            ]);

            $file = $request->file('gambar')[0];
            if (!$file || !$file->isValid()) {
                return redirect()
                    ->route('admin.banners.index')
                    ->with('error', 'File gambar tidak valid atau rusak.');
            }

            // Simpan file
            $gambarPath = $file->store('banners', 'public');
            if (!$gambarPath) {
                return redirect()
                    ->route('admin.banners.index')
                    ->with('error', 'Gagal menyimpan file gambar.');
            }

            // Hitung urutan berikutnya
            $maxUrutan = Banner::max('urutan') ?? 0;
            $newUrutan = $maxUrutan + 1;

            // Simpan ke database
            $banner = Banner::create([
                'gambar' => $gambarPath,
                'urutan' => $newUrutan,
                'is_active' => true,
            ]);

            if (!$banner) {
                // Jika gagal, hapus file yang sudah diupload
                Storage::disk('public')->delete($gambarPath);
                return redirect()
                    ->route('admin.banners.index')
                    ->with('error', 'Gagal menyimpan data banner ke database.');
            }

            return redirect()
                ->route('admin.banners.index')
                ->with('status', 'Banner berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('admin.banners.index')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Banner upload error: ' . $e->getMessage());
            return redirect()
                ->route('admin.banners.index')
                ->with('error', 'Terjadi kesalahan saat mengupload gambar: ' . $e->getMessage());
        }
    }

    /**
     * Update banner order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:banners,id',
            'order.*.urutan' => 'required|integer|min:1',
        ]);

        foreach ($request->order as $item) {
            Banner::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle banner active status
     */
    public function toggle(Banner $banner): RedirectResponse
    {
        $banner->update([
            'is_active' => !$banner->is_active,
        ]);

        $status = $banner->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->route('admin.banners.index')
            ->with('status', "Banner berhasil {$status}.");
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $deletedUrutan = $banner->urutan;
        
        if ($banner->gambar) {
            Storage::disk('public')->delete($banner->gambar);
        }
        $banner->delete();

        // Geser urutan banner yang lebih besar ke atas
        Banner::where('urutan', '>', $deletedUrutan)
            ->decrement('urutan');

        return redirect()
            ->route('admin.banners.index')
            ->with('status', 'Gambar banner berhasil dihapus.');
    }

    /**
     * Upload banner promosi
     */
    public function uploadPromosi(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'promosi_banner' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            ], [
                'promosi_banner.required' => 'Silakan pilih file gambar terlebih dahulu.',
                'promosi_banner.image' => 'File harus berupa gambar.',
                'promosi_banner.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
                'promosi_banner.max' => 'Ukuran file terlalu besar! Maksimal 5MB.',
            ]);

            $file = $request->file('promosi_banner');
            if (!$file || !$file->isValid()) {
                return redirect()
                    ->route('admin.banners.index')
                    ->with('error', 'File gambar tidak valid atau rusak.');
            }

            // Hapus banner promosi lama jika ada
            $settings = BannerSetting::first();
            if ($settings && $settings->promosi_banner_path) {
                Storage::disk('public')->delete($settings->promosi_banner_path);
            }

            // Simpan file baru
            $promosiPath = $file->store('banners/promosi', 'public');
            if (!$promosiPath) {
                return redirect()
                    ->route('admin.banners.index')
                    ->with('error', 'Gagal menyimpan file gambar.');
            }

            // Update atau create settings
            if (!$settings) {
                $settings = new BannerSetting([
                    'show_logo' => true,
                    'show_tagline' => true,
                    'show_title' => true,
                    'show_description' => true,
                    'show_button' => true,
                ]);
            }
            $settings->promosi_banner_path = $promosiPath;
            $settings->save();
            
            // Log untuk debugging
            \Log::info('Banner promosi uploaded: ' . $promosiPath);

            // Redirect dengan parameter untuk auto-reload
            return redirect()
                ->route('admin.banners.index')
                ->with('status', 'Banner promosi berhasil diupload.')
                ->with('reload', true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('admin.banners.index')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Promosi banner upload error: ' . $e->getMessage());
            return redirect()
                ->route('admin.banners.index')
                ->with('error', 'Terjadi kesalahan saat mengupload gambar: ' . $e->getMessage());
        }
    }

    /**
     * Hapus banner promosi
     */
    public function deletePromosi(): RedirectResponse
    {
        $settings = BannerSetting::first();
        if ($settings && $settings->promosi_banner_path) {
            Storage::disk('public')->delete($settings->promosi_banner_path);
            $settings->promosi_banner_path = null;
            $settings->save();
        }

        return redirect()
            ->route('admin.banners.index')
            ->with('status', 'Banner promosi berhasil dihapus.')
            ->with('reload', true);
    }
}
