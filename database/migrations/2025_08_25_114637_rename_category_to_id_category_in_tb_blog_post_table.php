<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tb_blog_post', function (Blueprint $table) {
            // rename dulu
            $table->renameColumn('category', 'id_category');
        });

        Schema::table('tb_blog_post', function (Blueprint $table) {
            // lalu ubah tipe jadi unsignedBigInteger
            $table->unsignedBigInteger('id_category')->change();

            // optional: tambahkan foreign key
            // $table->foreign('id_category')->references('id')->on('tb_categories_post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tb_blog_post', function (Blueprint $table) {
            // kalau rollback, hapus foreign key dulu kalau ada
            // $table->dropForeign(['id_category']);
            $table->integer('id_category')->change(); // balik ke integer biasa
            $table->renameColumn('id_category', 'category');
        });
    }
};
