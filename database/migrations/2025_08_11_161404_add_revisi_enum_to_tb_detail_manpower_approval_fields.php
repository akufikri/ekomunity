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
            $table->enum('status_approval_cawangan', ['APPROVE', 'REJECT', 'PENDING', 'REVISI'])->default('PENDING')->change();
            $table->enum('status_approval_ketua_bahagian', ['APPROVE', 'REJECT', 'PENDING', 'REVISI'])->default('PENDING')->change();
            $table->enum('status_approval_admin_pusat', ['APPROVE', 'REJECT', 'PENDING', 'REVISI'])->default('PENDING')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_manpower', function (Blueprint $table) {
            $table->enum('status_approval_cawangan', ['APPROVE', 'REJECT', 'PENDING'])->default('PENDING')->change();
            $table->enum('status_approval_ketua_bahagian', ['APPROVE', 'REJECT', 'PENDING'])->default('PENDING')->change();
            $table->enum('status_approval_admin_pusat', ['APPROVE', 'REJECT', 'PENDING'])->default('PENDING')->change();
        });
    }
};
