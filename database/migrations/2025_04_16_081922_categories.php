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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Create the category_design pivot table for many-to-many relationship
        // Schema::create('category_design', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('category_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('design_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('category_design');
        Schema::dropIfExists('categories');
    }
};