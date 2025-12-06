<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = \DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite tidak mendukung MODIFY COLUMN untuk enum
            // Kita akan menggunakan pendekatan yang berbeda
            // Karena SQLite menggunakan TEXT untuk enum, kita hanya perlu memastikan validasi di aplikasi
            // Tidak perlu mengubah struktur tabel untuk SQLite
        } else {
            // MySQL/MariaDB - Mengubah enum status untuk menambahkan opsi 'unpublished'
            \DB::statement("ALTER TABLE posts MODIFY COLUMN status ENUM('draft', 'published', 'unpublished') DEFAULT 'draft'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = \DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite - tidak perlu rollback karena tidak ada perubahan struktur
        } else {
            // MySQL/MariaDB - Kembalikan ke enum semula (hanya draft dan published)
            // Update data yang unpublished menjadi draft terlebih dahulu
            \DB::table('posts')->where('status', 'unpublished')->update(['status' => 'draft']);
            \DB::statement("ALTER TABLE posts MODIFY COLUMN status ENUM('draft', 'published') DEFAULT 'draft'");
        }
    }
};
