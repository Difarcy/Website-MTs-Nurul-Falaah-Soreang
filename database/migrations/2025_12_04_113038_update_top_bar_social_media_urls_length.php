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
        Schema::table('top_bar_settings', function (Blueprint $table) {
            $table->string('facebook_url', 150)->nullable()->change();
            $table->string('instagram_url', 150)->nullable()->change();
            $table->string('youtube_url', 150)->nullable()->change();
            $table->string('tiktok_url', 150)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_bar_settings', function (Blueprint $table) {
            $table->string('facebook_url')->nullable()->change();
            $table->string('instagram_url')->nullable()->change();
            $table->string('youtube_url')->nullable()->change();
            $table->string('tiktok_url')->nullable()->change();
        });
    }
};
