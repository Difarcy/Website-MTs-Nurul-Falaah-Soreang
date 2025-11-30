<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Banner;
use App\Models\FotoKegiatan;
use App\Models\PrestasiSiswa;
use Illuminate\Support\Facades\Storage;

class ClearAdminData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:clear-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengosongkan semua data dari admin panel (banners, foto kegiatan, prestasi siswa)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('Apakah Anda yakin ingin mengosongkan semua data? Data yang sudah ada akan dihapus permanen!')) {
            $this->info('Operasi dibatalkan.');
            return 0;
        }

        $this->info('Menghapus data...');

        // Hapus banners
        $banners = Banner::all();
        foreach ($banners as $banner) {
            if ($banner->gambar) {
                Storage::disk('public')->delete($banner->gambar);
            }
        }
        Banner::truncate();
        $this->info('✓ Banners dihapus');

        // Hapus foto kegiatan
        $fotos = FotoKegiatan::all();
        foreach ($fotos as $foto) {
            if ($foto->gambar) {
                Storage::disk('public')->delete($foto->gambar);
            }
        }
        FotoKegiatan::truncate();
        $this->info('✓ Foto Kegiatan dihapus');

        // Hapus prestasi siswa
        $prestasi = PrestasiSiswa::all();
        foreach ($prestasi as $item) {
            if ($item->gambar) {
                Storage::disk('public')->delete($item->gambar);
            }
        }
        PrestasiSiswa::truncate();
        $this->info('✓ Prestasi Siswa dihapus');

        $this->info('');
        $this->info('✓ Semua data berhasil dikosongkan!');
        $this->info('Sekarang semua konten default akan menggunakan default-backgrounds.png');

        return 0;
    }
}
