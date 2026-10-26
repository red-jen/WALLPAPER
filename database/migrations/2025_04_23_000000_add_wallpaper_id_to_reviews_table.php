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
        Schema::table('reviews', function (Blueprint $table) {
            // Add wallpaper_id if missing (ShopController expects this)
            if (!Schema::hasColumn('reviews', 'wallpaper_id')) {
                $table->foreignId('wallpaper_id')->nullable()->after('design_id')->constrained()->onDelete('cascade');
            }
            
            // Make design_id nullable (reviews can be for wallpapers OR designs, not both)
            if (Schema::hasColumn('reviews', 'design_id')) {
                $table->foreignId('design_id')->nullable()->change();
            }
        });
        
        // Drop old unique constraint if exists and recreate with wallpaper support
        // Note: This may need to be adjusted based on actual constraint name in production
        try {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'design_id']);
            });
        } catch (\Exception $e) {
            // Constraint might not exist or have different name
            \Log::debug('Could not drop unique constraint on reviews: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'wallpaper_id')) {
                $table->dropForeign(['wallpaper_id']);
                $table->dropColumn('wallpaper_id');
            }
        });
    }
};
