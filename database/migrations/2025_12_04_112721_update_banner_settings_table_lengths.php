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
        Schema::table('banner_settings', function (Blueprint $table) {
            $table->string('tagline', 150)->nullable()->change();
            $table->string('judul', 150)->nullable()->change();
            $table->string('link', 150)->nullable()->change();
            $table->string('button_text', 150)->nullable()->change();
            // Deskripsi tetap text karena bisa lebih panjang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            $table->string('tagline')->nullable()->change();
            $table->string('judul')->nullable()->change();
            $table->string('link')->nullable()->change();
            $table->string('button_text')->nullable()->change();
        });
    }
};
