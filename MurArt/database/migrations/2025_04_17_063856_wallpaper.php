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
        Schema::create('wallpapers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('width')->nullable()->comment('Width in pixels');
            $table->integer('height')->nullable()->comment('Height in pixels');
            $table->integer('stock')->default(0)->comment('Available quantity in stock');
            $table->integer('downloads')->default(0)->comment('Number of times downloaded/purchased');
            $table->enum('status', ['draft', 'published', 'featured'])->default('draft');
            $table->timestamps();
        });

        // Create wallpaper_images table for multiple images
        Schema::create('wallpaper_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallpaper_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('title')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Create paper_wallpaper pivot table for recommended papers
        Schema::create('paper_wallpaper', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallpaper_id')->constrained()->onDelete('cascade');
            $table->foreignId('paper_id')->constrained()->onDelete('cascade');
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_wallpaper');
        Schema::dropIfExists('wallpaper_images');
        Schema::dropIfExists('wallpapers');
    }
};