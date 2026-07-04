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
        Schema::create('tb_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location');
            $table->text('address')->nullable();
            $table->string('organizer')->nullable();
            $table->string('type')->nullable(); // e.g. mesyuarat, aktiviti, bengkel, majlis
            $table->string('status')->default('upcoming'); // e.g. upcoming, completed
            $table->integer('max_attendees')->default(100);
            $table->text('agenda')->nullable(); // JSON formatted list
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_activities');
    }
};
