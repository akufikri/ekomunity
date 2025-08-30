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
        Schema::create('tb_email_setting', function (Blueprint $table) {
            $table->id();

            // pengaturan notifikasi
            $table->boolean('notif_enabled')->default(true); // toggle notif
            $table->json('notif_types')->nullable(); // jenis notif (optional, bisa json array)

            // pengaturan sender
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->unique();

            // default penerima (misalnya admin)
            $table->string('admin_email')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_email_setting');
    }
};
