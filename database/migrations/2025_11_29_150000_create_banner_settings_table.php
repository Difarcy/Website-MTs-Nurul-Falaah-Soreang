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
        if (!Schema::hasTable('banner_settings')) {
            Schema::create('banner_settings', function (Blueprint $table) {
                $table->id();
                $table->string('tagline')->nullable();
                $table->string('judul')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('link')->nullable();
                $table->string('button_text')->nullable();
                $table->boolean('show_logo')->default(true);
                $table->boolean('show_tagline')->default(true);
                $table->boolean('show_title')->default(true);
                $table->boolean('show_description')->default(true);
                $table->boolean('show_button')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_settings');
    }
};


