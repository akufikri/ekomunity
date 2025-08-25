<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldToCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_city', function (Blueprint $table) {
            $table->string('representation', '255')->nullable()->after('city');
            $table->string('association', '255')->nullable()->after('representation');
            $table->text('description2')->nullable()->after('description');
            $table->string('phone_number', '30')->nullable()->after('description2');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_city', function (Blueprint $table) {
            $table->dropColumn('representation');
            $table->dropColumn('association');
            $table->dropColumn('desc_1');
            $table->dropColumn('desc_2');
            $table->dropColumn('phone_number');
        });
    }
}
