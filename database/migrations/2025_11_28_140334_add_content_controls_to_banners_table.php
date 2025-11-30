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
        Schema::table('banners', function (Blueprint $table) {
            $table->string('tagline')->nullable()->after('judul');
            $table->string('button_text')->nullable()->after('link');
            $table->boolean('show_logo')->default(true)->after('is_active');
            $table->boolean('show_tagline')->default(true)->after('show_logo');
            $table->boolean('show_title')->default(true)->after('show_tagline');
            $table->boolean('show_description')->default(true)->after('show_title');
            $table->boolean('show_button')->default(true)->after('show_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'tagline',
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
