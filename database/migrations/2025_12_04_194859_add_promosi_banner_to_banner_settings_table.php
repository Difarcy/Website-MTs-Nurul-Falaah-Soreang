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
            if (!Schema::hasColumn('banner_settings', 'promosi_banner_path')) {
                $table->string('promosi_banner_path')->nullable()->after('show_button');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            if (Schema::hasColumn('banner_settings', 'promosi_banner_path')) {
                $table->dropColumn('promosi_banner_path');
            }
        });
    }
};
