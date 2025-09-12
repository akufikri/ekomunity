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
        Schema::create('organization_charts', function (Blueprint $table) {
            $table->id();
            $table->string('chart_name');
            $table->string('chart_type')->default('organizational'); // organizational, departmental, project
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable(); // if you have companies table
            $table->unsignedBigInteger('created_by');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_published')->default(false);
            $table->date('effective_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('chart_settings')->nullable(); // For storing chart display settings
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade'); // uncomment if you have companies table

            // Indexes
            $table->index(['is_active', 'is_published']);
            $table->index('effective_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_charts');
    }
};
