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
        Schema::table('tb_detail_company', function (Blueprint $table) {
           $table->unsignedBigInteger('id_bahagian')->after('id_pegawai_daerah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_company', function (Blueprint $table) {
            $table->dropColumn('id_bahagian');
        });
    }
};
