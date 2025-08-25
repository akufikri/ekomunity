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
        Schema::create('tb_log_payment_cawangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_payment');
            $table->unsignedBigInteger('id_user')->comment('@todo : refrence ke id di table users dengan level id 3');
            $table->unsignedBigInteger('id_cawangan')->comment('@todo : refrence ke id di table users');
            $table->decimal('amount', 10,2)->default(0);
            $table->enum('status', ['PENDING', 'PAID', 'CANCEL'])->default('PENDING');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_payment_cawangan');
    }
};
