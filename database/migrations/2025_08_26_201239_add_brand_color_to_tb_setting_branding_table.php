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
        Schema::table('tb_setting_branding', function (Blueprint $table) {
            $table->string('brand_color')->after('description')->nullable();
            $table->text('cta')->after('brand_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_setting_branding', function (Blueprint $table) {
            //
        });
    }
};
