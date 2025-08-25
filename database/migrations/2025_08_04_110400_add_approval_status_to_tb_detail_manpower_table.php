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

        Schema::table('users', function(Blueprint $table){
            $table->boolean('status_approval')->after('status')->default(0);
        });

        Schema::table('tb_detail_manpower', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cawangan')->after('key_reference')->nullable();
            $table->string('nama_pencadang', 110)->after('id_cawangan')->nullable();
            $table->string('nama_peyokong', 110)->after('nama_pencadang')->nullable();

            $table->timestamp('approve_at_cawangan')->after('nama_peyokong')->nullable();
            $table->timestamp('approve_at_ketua_bahagian')->after('approve_at_cawangan')->nullable();
            $table->timestamp('approve_at_admin_pusat')->after('approve_at_ketua_bahagian')->nullable();

            $table->enum('status_approval_cawangan', ['APPROVE', 'REJECT', 'PENDING'])->after('approve_at_admin_pusat')->default('PENDING');
            $table->enum('status_approval_ketua_bahagian', ['APPROVE', 'REJECT', 'PENDING'])->after('status_approval_cawangan')->default('PENDING');
            $table->enum('status_approval_admin_pusat', ['APPROVE', 'REJECT', 'PENDING'])->after('status_approval_ketua_bahagian')->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_manpower', function (Blueprint $table) {
            $table->dropColumn('id_cawangan');
            $table->dropColumn('nama_pencadang');
            $table->dropColumn('nama_peyokong');
            $table->dropColumn('approve_at_cawangan');
            $table->dropColumn('approve_at_ketua_bahagian');
            $table->dropColumn('approve_at_admin_pusat');
        });
    }
};
