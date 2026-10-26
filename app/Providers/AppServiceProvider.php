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
            // Priority 1: Manual refresh override (SEED_DEMO_REFRESH=true)
            if ($this->shouldRefreshCatalog()) {
                $this->refreshCatalog();
            }
            // Priority 2: Automatic catalog update when JSON changes or old demo data detected
            elseif ($this->shouldAutoRefreshCatalog()) {
                $this->autoRefreshCatalog();
            }
            // Priority 3: Normal empty-catalog seeding
            elseif ($this->shouldSeedDemo()) {
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
            
            $this->performCatalogRefresh('SEED_DEMO_REFRESH');
            
            // Success - set permanent cache flag to prevent re-running
            Cache::forever('catalog_refresh_completed', true);
            Log::info('SEED_DEMO_REFRESH: Remove SEED_DEMO_REFRESH env var to prevent re-running');
        } catch (\Exception $e) {
            Log::error('SEED_DEMO_REFRESH: Failed to refresh catalog: ' . $e->getMessage());
            Log::error('SEED_DEMO_REFRESH: Exception trace: ' . $e->getTraceAsString());
            Cache::put('catalog_refresh_retry_after', now()->timestamp, now()->addMinutes(5));
        }
    }

    /**
     * Check if automatic catalog refresh should run.
     */
    private function shouldAutoRefreshCatalog(): bool
    {
        try {
            // Check if scraped catalog JSON exists
            $catalogPath = database_path('data/scraped-wallpapers.json');
            if (!file_exists($catalogPath)) {
                return false;
            }

            // Compute stable hash of catalog contents
            $catalogContents = file_get_contents($catalogPath);
            $catalogHash = md5($catalogContents);

            // Check cached hash
            $cachedHash = Cache::get('scraped_catalog_hash');
            
            // If hashes match, catalog is up to date
            if ($cachedHash === $catalogHash) {
                return false;
            }

            // Check if wallpapers exist
            $wallpaperCount = Wallpaper::count();
            
            if ($wallpaperCount === 0) {
                // Empty catalog - let SEED_DEMO handle initial seeding
                return false;
            }

            // Check if we have old demo titles
            $oldDemoTitles = [
                'Golden Hexagons',
                'Midnight Geometry',
                'Spring Blossom',
                'Tropical Paradise',
                'Watercolor Dreams',
                'Marble Veins',
                'Pure Lines',
                'Soft Gradient',
                'Victorian Damask',
                'Retro Circles',
                'Natural Linen',
                'Concrete Chic',
            ];

            $hasOldDemoData = Wallpaper::whereIn('title', $oldDemoTitles)->exists();

            // Refresh if:
            // 1. Hash changed (new catalog data available)
            // 2. AND (old demo data detected OR wallpaper count doesn't match expected scraped count)
            if ($hasOldDemoData) {
                Log::info('AUTO_CATALOG_REFRESH: Old demo data detected, will refresh with scraped products');
                return true;
            }

            // Also refresh if catalog JSON has more products than database
            $catalogData = json_decode($catalogContents, true);
            $expectedCount = is_array($catalogData) ? count($catalogData) : 0;
            
            if ($expectedCount > 0 && $wallpaperCount < $expectedCount) {
                Log::info("AUTO_CATALOG_REFRESH: Catalog has {$expectedCount} products but only {$wallpaperCount} in DB");
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::debug('AUTO_CATALOG_REFRESH: shouldAutoRefreshCatalog check skipped: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Automatically refresh catalog when JSON changes or old demo data detected.
     */
    private function autoRefreshCatalog(): void
    {
        try {
            Log::info('AUTO_CATALOG_REFRESH: Starting automatic catalog refresh...');
            
            $this->performCatalogRefresh('AUTO_CATALOG_REFRESH');
            
            // Store catalog hash to prevent re-running
            $catalogPath = database_path('data/scraped-wallpapers.json');
            if (file_exists($catalogPath)) {
                $catalogHash = md5(file_get_contents($catalogPath));
                Cache::forever('scraped_catalog_hash', $catalogHash);
                Log::info("AUTO_CATALOG_REFRESH: Stored catalog hash: {$catalogHash}");
            }

        } catch (\Exception $e) {
            Log::error('AUTO_CATALOG_REFRESH: Failed to refresh catalog: ' . $e->getMessage());
            Log::error('AUTO_CATALOG_REFRESH: Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Perform the actual catalog refresh (shared logic).
     */
    private function performCatalogRefresh(string $logPrefix): void
    {
        // Delete old wallpaper images and wallpapers
        // Safe: only removes wallpaper-related data, keeps users/orders/designs/papers
        $oldCount = Wallpaper::count();
        
        // Delete wallpaper images first (foreign key constraint)
        \App\Models\WallpaperImage::truncate();
        
        // Delete wallpaper-paper pivot records
        DB::table('paper_wallpaper')->truncate();
        
        // Delete wallpapers
        Wallpaper::truncate();
        
        Log::info("{$logPrefix}: Removed {$oldCount} old wallpapers");
        
        // Run scraped wallpaper seeder
        $exitCode = Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\ScrapedWallpaperSeeder',
            '--force' => true
        ]);
        $output = Artisan::output();
        
        if ($exitCode === 0) {
            $newCount = Wallpaper::count();
            Log::info("{$logPrefix}: Catalog refreshed successfully! {$newCount} products loaded.");
            Log::info("{$logPrefix}: Artisan output: " . $output);
        } else {
            Log::error("{$logPrefix}: Seeder returned exit code {$exitCode}");
            Log::error("{$logPrefix}: Artisan output: " . $output);
            throw new \Exception("Seeder failed with exit code {$exitCode}");
        }
    }
}

