<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        // CRITICAL: Skip during console/build (artisan commands, composer hooks)
        // Only run on actual HTTP requests when DB is available
        if (!app()->runningInConsole()) {
            // Check for refresh mode first (replaces existing catalog)
            if ($this->shouldRefreshCatalog()) {
                $this->refreshCatalog();
            } elseif ($this->shouldSeedDemo()) {
                // Normal empty-catalog seeding
                $this->seedDemoData();
            }
        }
    }

    /**
     * Check if demo seeding should run.
     */
    private function shouldSeedDemo(): bool
    {
        try {
            // Check if SEED_DEMO is enabled (use config, not env - works with config:cache)
            $seedDemo = config('app.seed_demo');
            if (!in_array($seedDemo, ['true', '1', 'yes', true, 1], true)) {
                return false;
            }

            // Check if seeding already completed (cache flag)
            // Wrapped in try-catch: cache might not be available during build
            if (Cache::has('demo_seed_completed')) {
                return false;
            }

            // Check if catalog is empty (both wallpapers AND papers)
            // If either table has data, assume catalog is seeded
            $wallpaperCount = Wallpaper::count();
            $paperCount = Paper::count();
            
            return ($wallpaperCount === 0 && $paperCount === 0);
        } catch (\Exception $e) {
            // Database/cache not ready yet (build time, tables don't exist, etc.)
            // Fail silently and try again on next request
            Log::debug('SEED_DEMO: shouldSeedDemo check skipped: ' . $e->getMessage());
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

    /**
     * Check if catalog refresh should run.
     */
    private function shouldRefreshCatalog(): bool
    {
        try {
            // Check if SEED_DEMO_REFRESH is enabled
            $refreshEnabled = config('app.seed_demo_refresh');
            if (!in_array($refreshEnabled, ['true', '1', 'yes', true, 1], true)) {
                return false;
            }

            // Check if refresh already completed (cache flag)
            if (Cache::has('catalog_refresh_completed')) {
                return false;
            }

            // Check if catalog exists (we need wallpapers to refresh)
            $wallpaperCount = Wallpaper::count();
            
            return ($wallpaperCount > 0); // Only refresh if catalog exists
        } catch (\Exception $e) {
            Log::debug('SEED_DEMO_REFRESH: shouldRefreshCatalog check skipped: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Refresh wallpaper catalog with scraped products.
     */
    private function refreshCatalog(): void
    {
        try {
            Log::info('SEED_DEMO_REFRESH: Starting catalog refresh with scraped products...');
            
            // Delete old wallpaper images and wallpapers
            // Safe: only removes wallpaper-related data, keeps users/orders/designs/papers
            $oldCount = Wallpaper::count();
            
            // Delete wallpaper images first (foreign key constraint)
            \App\Models\WallpaperImage::truncate();
            
            // Delete wallpaper-paper pivot records
            \DB::table('paper_wallpaper')->truncate();
            
            // Delete wallpapers
            Wallpaper::truncate();
            
            Log::info("SEED_DEMO_REFRESH: Removed {$oldCount} old wallpapers");
            
            // Run scraped wallpaper seeder
            $exitCode = Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\ScrapedWallpaperSeeder',
                '--force' => true
            ]);
            $output = Artisan::output();
            
            if ($exitCode === 0) {
                // Success - set permanent cache flag to prevent re-running
                Cache::forever('catalog_refresh_completed', true);
                
                $newCount = Wallpaper::count();
                Log::info("SEED_DEMO_REFRESH: Catalog refreshed successfully! {$newCount} products loaded.");
                Log::info('SEED_DEMO_REFRESH: Artisan output: ' . $output);
                Log::info('SEED_DEMO_REFRESH: Remove SEED_DEMO_REFRESH env var to prevent re-running');
            } else {
                Log::error('SEED_DEMO_REFRESH: Seeder returned exit code ' . $exitCode);
                Log::error('SEED_DEMO_REFRESH: Artisan output: ' . $output);
                Cache::put('catalog_refresh_retry_after', now()->timestamp, now()->addMinutes(5));
            }
        } catch (\Exception $e) {
            Log::error('SEED_DEMO_REFRESH: Failed to refresh catalog: ' . $e->getMessage());
            Log::error('SEED_DEMO_REFRESH: Exception trace: ' . $e->getTraceAsString());
            Cache::put('catalog_refresh_retry_after', now()->timestamp, now()->addMinutes(5));
        }
    }
}

