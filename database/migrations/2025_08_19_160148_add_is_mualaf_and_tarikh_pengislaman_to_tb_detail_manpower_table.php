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
            $table->boolean('is_mualaf')->default(0)->comment('Status Mualaf: 1=Ya, 0=Tidak')->after('reason_cawangan');
            $table->date('tarikh_pengislaman')->nullable()->comment('Tarikh Pengislaman jika Mualaf')->after('is_mualaf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_manpower', function (Blueprint $table) {
            $table->dropColumn('is_mualaf');
            $table->dropColumn('tarikh_pengislaman');
        });
    }
};
