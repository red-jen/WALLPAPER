<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Wallpaper;
use App\Models\Paper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // One-shot demo seeding on boot for frozen Wasmer deployments
        // Only runs when SEED_DEMO=true AND catalog is empty
        if ($this->shouldSeedDemo()) {
            $this->seedDemoData();
        }
    }

    /**
     * Check if demo seeding should run.
     */
    private function shouldSeedDemo(): bool
    {
        // Check if SEED_DEMO env var is enabled
        if (!in_array(env('SEED_DEMO'), ['true', '1', 'yes'], true)) {
            return false;
        }

        // Check if seeding already completed (cache flag)
        if (Cache::has('demo_seed_completed')) {
            return false;
        }

        try {
            // Check if catalog is empty (both wallpapers AND papers)
            // If either table has data, assume catalog is seeded
            $wallpaperCount = Wallpaper::count();
            $paperCount = Paper::count();
            
            return ($wallpaperCount === 0 && $paperCount === 0);
        } catch (\Exception $e) {
            // Database not ready yet or tables don't exist
            // Fail silently and try again on next request
            return false;
        }
    }

    /**
     * Seed demo data and set completion flag.
     */
    private function seedDemoData(): void
    {
        try {
            Log::info('SEED_DEMO: Starting automatic demo data seeding...');
            
            // Run the seeder
            Artisan::call('db:seed', ['--force' => true]);
            
            // Set cache flag to prevent re-running (forever)
            Cache::forever('demo_seed_completed', true);
            
            Log::info('SEED_DEMO: Demo data seeded successfully!');
            Log::info('SEED_DEMO: Demo credentials - Admin: admin@murart.com, Customer: customer@murart.com, Password: password');
        } catch (\Exception $e) {
            // Log error but don't crash the application
            Log::error('SEED_DEMO: Failed to seed demo data: ' . $e->getMessage());
            
            // Set flag anyway to prevent infinite retry loops
            // User can clear cache and redeploy if needed
            Cache::put('demo_seed_completed', true, now()->addHours(24));
        }
    }
}

