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
        Schema::table('tb_log_payment_cawangan', function (Blueprint $table) {
            $table->enum('status_approval', ['APPROVE', 'PENDING','REJECT'])->after('status')->default('PENDING');
            $table->text('resit')->after('status_approval')->nullable();
        });
        Schema::table('tb_log_payment_ketua_bahagian', function (Blueprint $table) {
            $table->enum('status_approval', ['APPROVE', 'PENDING','REJECT'])->after('status')->default('PENDING');
            $table->text('resit')->after('status_approval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_log_payment_cawangan', function (Blueprint $table) {
            $table->dropColumn('status_approval');
            $table->dropColumn('resit');
        });
        Schema::table('tb_log_payment_ketua_bahagian', function (Blueprint $table) {
            $table->dropColumn('status_approval');
            $table->dropColumn('resit');
        });
    }
};
