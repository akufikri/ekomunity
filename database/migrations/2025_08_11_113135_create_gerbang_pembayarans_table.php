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
        Schema::create('tb_gerbang_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->double('price_pusat', 10, 2)->default(0);
            $table->double('price_cawangan', 10, 2)->default(0);
            $table->double('price_ketua_bahagian', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_gerbang_pembayaran');
    }
};
