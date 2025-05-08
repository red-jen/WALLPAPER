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
        Schema::table('artworks', function (Blueprint $table) {
            $table->string('preview_status')->default('pending')->after('image_path');
            $table->string('preview_image_path')->nullable()->after('preview_status');
            $table->timestamp('preview_updated_at')->nullable()->after('preview_image_path');
            $table->text('status_notes')->nullable()->after('preview_updated_at');
            $table->json('production_images')->nullable()->after('status_notes');
            $table->string('production_status')->nullable()->after('production_images');
            $table->text('production_notes')->nullable()->after('production_status');
            $table->string('tracking_number')->nullable()->after('production_notes');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn([
                'preview_status',
                'preview_image_path',
                'preview_updated_at',
                'status_notes',
                'production_images',
                'production_status',
                'production_notes',
                'tracking_number'
            ]);
        });
    }
}; 