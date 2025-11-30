<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update data yang urutan 0 menjadi 1
        DB::table('banners')->where('urutan', 0)->update(['urutan' => 1]);
        
        // Ubah default value di database
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('urutan')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan default ke 0
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('urutan')->default(0)->change();
        });
        
        // Update data yang urutan 1 menjadi 0 (hanya yang sebelumnya 0)
        // Note: Ini tidak sempurna karena tidak tahu mana yang sebelumnya 0
        // Tapi untuk rollback sederhana, kita biarkan saja
    }
};
