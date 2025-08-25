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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_ros',100)->nullable()->after('registered_by')->comment('FOR KETUA BAHAGIAN & CAWANGAN')->index();
            $table->string('kod_bahagian', 100)->nullable()->after('no_ros')->comment('FOR KETUA BAHAGIAN & CAWANGAN')->index();
            $table->string('kod_cawangan', 100)->nullable()->after('kod_bahagian')->comment('FOR CAWANGAN')->index();
            $table->enum('status_ros', ['berdaftar', 'belum_berdaftar', 'penaja'])->default('belum_berdaftar')->after('kod_cawangan')->comment('FOR KETUA BAHAGIAN & CAWANGAN')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no_ros');
            $table->dropColumn('kod_bahagian');
        });
    }
};
