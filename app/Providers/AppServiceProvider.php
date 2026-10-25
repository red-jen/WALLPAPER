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
        // Check if SEED_DEMO is enabled (use config, not env - works with config:cache)
        $seedDemo = config('app.seed_demo');
        if (!in_array($seedDemo, ['true', '1', 'yes', true, 1], true)) {
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
            $exitCode = Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();
            
            if ($exitCode === 0) {
                // Success - set permanent cache flag
                Cache::forever('demo_seed_completed', true);
                Log::info('SEED_DEMO: Demo data seeded successfully!');
                Log::info('SEED_DEMO: Artisan output: ' . $output);
                Log::info('SEED_DEMO: Demo credentials - Admin: admin@murart.com, Customer: customer@murart.com, Password: password');
            } else {
                // Non-zero exit - treat as failure, short backoff
                Log::error('SEED_DEMO: Seeder returned exit code ' . $exitCode);
                Log::error('SEED_DEMO: Artisan output: ' . $output);
                Cache::put('demo_seed_completed_retry_after', now()->timestamp, now()->addMinutes(5));
            }
        } catch (\Exception $e) {
            // Exception thrown - log and short backoff
            Log::error('SEED_DEMO: Failed to seed demo data: ' . $e->getMessage());
            Log::error('SEED_DEMO: Exception trace: ' . $e->getTraceAsString());
            Cache::put('demo_seed_completed_retry_after', now()->timestamp, now()->addMinutes(5));
        }
    }
}

