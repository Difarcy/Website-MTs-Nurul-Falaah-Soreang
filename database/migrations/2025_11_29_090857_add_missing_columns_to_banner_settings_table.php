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
            if (!Schema::hasColumn('banner_settings', 'tagline')) {
                $table->string('tagline')->nullable()->after('id');
            }
            if (!Schema::hasColumn('banner_settings', 'judul')) {
                $table->string('judul')->nullable()->after('tagline');
            }
            if (!Schema::hasColumn('banner_settings', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('banner_settings', 'link')) {
                $table->string('link')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('banner_settings', 'button_text')) {
                $table->string('button_text')->nullable()->after('link');
            }
            if (!Schema::hasColumn('banner_settings', 'show_logo')) {
                $table->boolean('show_logo')->default(true)->after('button_text');
            }
            if (!Schema::hasColumn('banner_settings', 'show_tagline')) {
                $table->boolean('show_tagline')->default(true)->after('show_logo');
            }
            if (!Schema::hasColumn('banner_settings', 'show_title')) {
                $table->boolean('show_title')->default(true)->after('show_tagline');
            }
            if (!Schema::hasColumn('banner_settings', 'show_description')) {
                $table->boolean('show_description')->default(true)->after('show_title');
            }
            if (!Schema::hasColumn('banner_settings', 'show_button')) {
                $table->boolean('show_button')->default(true)->after('show_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            $table->dropColumn([
                'tagline',
                'judul',
                'deskripsi',
                'link',
                'button_text',
                'show_logo',
                'show_tagline',
                'show_title',
                'show_description',
                'show_button',
            ]);
        });
    }
};
