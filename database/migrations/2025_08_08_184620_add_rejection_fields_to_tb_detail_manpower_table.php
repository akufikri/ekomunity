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
        Schema::table('tb_detail_manpower', function (Blueprint $table) {
            $table->text('rejection_reason_cawangan')->nullable()->after('status_approval_cawangan');
            $table->text('rejection_reason_ketua_bahagian')->nullable()->after('status_approval_ketua_bahagian');
            $table->text('rejection_reason_admin_pusat')->nullable()->after('status_approval_admin_pusat');
            
            $table->unsignedBigInteger('id_approve_by_ketua_bahagian')->after('id_cawangan')->nullable();
            $table->unsignedBigInteger('id_approve_by_admin_pusat')->after('id_approve_by_ketua_bahagian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_manpower', function (Blueprint $table) {
            $table->dropColumn(['rejection_reason_cawangan', 'rejection_reason_ketua_bahagian', 'rejection_reason_admin_pusat']);
        });
    }
};
