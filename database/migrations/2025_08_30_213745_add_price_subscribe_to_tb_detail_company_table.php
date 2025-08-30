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
            $table->decimal('price_subscribe', 10, 0)->after('tnc')->default(0);
            $table->integer('year_expired_subscribe')->after('amount_subscribe')->default(0);
            $table->integer('valid_subscribe')->after('year_expired_subscribe')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_detail_company', function (Blueprint $table) {
            //
        });
    }
};
