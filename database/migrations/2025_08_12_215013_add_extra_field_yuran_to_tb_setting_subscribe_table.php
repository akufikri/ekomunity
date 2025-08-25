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
        Schema::table('tb_setting_subscribe', function (Blueprint $table) {
            $table->decimal('price_pusat', 10,2)->after('price')->default(0);
            $table->decimal('price_cawangan', 10,2)->after('price_pusat')->default(0);
            $table->decimal('price_ketua_bahagian', 10,2)->after('price_cawangan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_setting_subscribe', function (Blueprint $table) {
            $table->dropColumn('price_pusat');
            $table->dropColumn('price_cawangan');
            $table->dropColumn('price_ketua_bahagian');
        });
    }
};
