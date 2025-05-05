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
        // First, remove preview columns from the artworks table
        Schema::table('artworks', function (Blueprint $table) {
            // Store existing preview data to move it to the new table later
            if (Schema::hasColumn('artworks', 'preview_status')) {
                $table->dropColumn([
                    'preview_status',
                    'preview_image_path',
                    'preview_updated_at',
                    'status_notes',
                    'feedback'
                ]);
            }
        });

        // Create the new artwork_previews table
        Schema::create('artwork_previews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('image_path')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('client_feedback')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artwork_previews');

        // Restore columns to artworks table
        Schema::table('artworks', function (Blueprint $table) {
            $table->string('preview_status')->nullable();
            $table->string('preview_image_path')->nullable();
            $table->timestamp('preview_updated_at')->nullable();
            $table->text('status_notes')->nullable();
            $table->text('feedback')->nullable();
        });
    }
};
