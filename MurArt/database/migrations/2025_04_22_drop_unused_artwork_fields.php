<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            // Drop unused columns
            $table->dropColumn([
                'medium',
                'year_created',
                'price',
                'is_for_sale',
                'is_featured'
            ]);

            // Modify dimensions to width and height
            $table->dropColumn('dimensions');
            $table->integer('width')->nullable()->after('description');
            $table->integer('height')->nullable()->after('width');

            // Add foreign keys properly
            $table->foreignId('paper_id')->after('height')->constrained()->onDelete('cascade');
            $table->foreignId('design_id')->after('paper_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            // Drop the foreign key constraints first
            $table->dropForeign(['paper_id']);
            $table->dropForeign(['design_id']);
            $table->dropColumn(['paper_id', 'design_id']);

            // Restore original columns
            $table->string('medium')->nullable();
            $table->year('year_created')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_for_sale')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('dimensions')->nullable();

            // Drop the new columns
            $table->dropColumn(['width', 'height']);
        });
    }
};