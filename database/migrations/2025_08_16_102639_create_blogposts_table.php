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
        Schema::create('tb_blog_post', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->longText('content')->nullable();
            $table->text('tags')->nullable();
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->default('DRAFT');
            $table->timestamps();
        });

        Schema::create('tb_direktori', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('jawatan');
            $table->string('no_phone');
            $table->string('email')->unique();
            $table->string('cawangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_blog_post');
        Schema::dropIfExists('tb_direktori');
    }
};
