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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // e.g., Matte, Glossy, Recycled, etc.
            $table->integer('thickness')->nullable(); // in gsm (grams per square meter)
            $table->string('size')->nullable(); // e.g., A4, A3, Letter
            $table->string('color')->nullable();
            $table->string('finish')->nullable(); // e.g., Smooth, Textured
            $table->text('usage')->nullable(); // Recommended usage
            $table->boolean('is_active')->default(true);
            $table->decimal('price', 10, 2)->nullable(); // Price per unit
            $table->timestamps();
        });

        // Create the paper_design pivot table for many-to-many relationship
        Schema::create('design_paper', function (Blueprint $table) {
            $table->id();
            $table->foreignId('design_id')->constrained()->onDelete('cascade');
            $table->foreignId('paper_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_paper');
        Schema::dropIfExists('papers');
    }
};