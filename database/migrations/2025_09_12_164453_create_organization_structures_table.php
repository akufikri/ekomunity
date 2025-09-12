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
        Schema::create('organization_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chart_id');
            $table->string('position_title');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('level')->default(0);
            $table->integer('order_index')->default(0);
            $table->decimal('position_x', 8, 2)->nullable();
            $table->decimal('position_y', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // For storing additional data like chart config
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('chart_id')->references('id')->on('organization_charts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('organization_structures')->onDelete('cascade');

            // Indexes for better performance
            $table->index(['chart_id', 'parent_id', 'level']);
            $table->index(['chart_id', 'is_active']);
            $table->index(['parent_id', 'level']);
            $table->index(['is_active', 'level']);
            $table->index('order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_structures');
    }
};
