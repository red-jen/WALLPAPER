<?php

namespace Database\Seeders;

use App\Models\Wallpaper;
use App\Models\WallpaperImage;
use App\Models\Category;
use App\Models\Paper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScrapedWallpaperSeeder extends Seeder
{
    /**
     * Seed scraped wallpaper catalog with real products and images.
     */
    public function run(): void
    {
        $catalogPath = database_path('data/scraped-wallpapers.json');
        
        if (!file_exists($catalogPath)) {
            Log::error('ScrapedWallpaperSeeder: Catalog file not found at ' . $catalogPath);
            $this->command->error('Catalog file not found: ' . $catalogPath);
            return;
        }

        $products = json_decode(file_get_contents($catalogPath), true);
        
        if (!$products || !is_array($products)) {
            Log::error('ScrapedWallpaperSeeder: Invalid catalog JSON');
            $this->command->error('Invalid catalog JSON');
            return;
        }

        $this->command->info('Loading ' . count($products) . ' scraped wallpaper products...');

        // Get all categories for mapping
        $categories = Category::all()->keyBy('name');
        $papers = Paper::all();

        if ($papers->isEmpty()) {
            $this->command->warn('No papers found - wallpapers will have no paper associations');
        }

        $successCount = 0;
        $errorCount = 0;

        foreach ($products as $product) {
            try {
                // Map category by name
                $categoryName = $product['category'] ?? 'Geometric';
                $category = $categories->get($categoryName);
                
                if (!$category) {
                    $this->command->warn("Category '{$categoryName}' not found, skipping {$product['title']}");
                    $errorCount++;
                    continue;
                }

                // Create or update wallpaper
                $wallpaper = Wallpaper::updateOrCreate(
                    ['title' => $product['title']],
                    [
                        'description' => $product['description'],
                        'category_id' => $category->id,
                        'price' => $product['price'] ?? 29.99,
                        'width' => $product['width'] ?? 2048,
                        'height' => $product['height'] ?? 2732,
                        'stock' => $product['stock'] ?? 50,
                        'status' => $product['status'] ?? 'published',
                    ]
                );

                // Download and store image if we have an image_url
                if (!empty($product['image_url'])) {
                    $this->downloadAndStoreImage($wallpaper, $product['image_url']);
                }

                // Attach 2-4 compatible papers
                if ($papers->isNotEmpty() && $wallpaper->papers()->count() === 0) {
                    $compatiblePapers = $papers->random(min(rand(2, 4), $papers->count()));
                    $wallpaper->papers()->attach($compatiblePapers->pluck('id')->mapWithKeys(function ($id) {
                        return [$id => ['is_recommended' => rand(0, 1) === 1]];
                    }));
                }

                $successCount++;
                $this->command->info("✓ {$product['title']}");

            } catch (\Exception $e) {
                $errorCount++;
                $this->command->error("✗ {$product['title']}: " . $e->getMessage());
                Log::error('ScrapedWallpaperSeeder: Error seeding ' . ($product['title'] ?? 'unknown') . ': ' . $e->getMessage());
            }
        }

        $this->command->info("\nCompleted: {$successCount} successful, {$errorCount} errors");
    }

    /**
     * Download image from URL and store in Laravel storage.
     */
    private function downloadAndStoreImage(Wallpaper $wallpaper, string $imageUrl): void
    {
        try {
            // Download image with timeout
            $response = Http::timeout(30)->get($imageUrl);
            
            if (!$response->successful()) {
                throw new \Exception("HTTP {$response->status()} from {$imageUrl}");
            }

            $imageData = $response->body();
            
            if (empty($imageData)) {
                throw new \Exception('Empty image data');
            }

            // Ensure directory exists
            $directory = "wallpapers/{$wallpaper->id}";
            Storage::disk('public')->makeDirectory($directory);

            // Determine file extension from content type or URL
            $contentType = $response->header('Content-Type');
            $extension = 'jpg'; // default
            
            if (str_contains($contentType, 'png')) {
                $extension = 'png';
            } elseif (str_contains($contentType, 'jpeg') || str_contains($contentType, 'jpg')) {
                $extension = 'jpg';
            } elseif (str_contains($contentType, 'webp')) {
                $extension = 'webp';
            }

            // Store image
            $filename = "primary.{$extension}";
            $path = "{$directory}/{$filename}";
            Storage::disk('public')->put($path, $imageData);

            // Create or update WallpaperImage record
            WallpaperImage::updateOrCreate(
                [
                    'wallpaper_id' => $wallpaper->id,
                    'is_primary' => true,
                ],
                [
                    'image_path' => $path,
                    'title' => $wallpaper->title,
                    'sort_order' => 1,
                ]
            );

            $this->command->info("  → Image downloaded: {$filename}");

        } catch (\Exception $e) {
            $this->command->warn("  → Image download failed: " . $e->getMessage());
            Log::warning("ScrapedWallpaperSeeder: Image download failed for wallpaper {$wallpaper->id}: " . $e->getMessage());
            
            // Create placeholder image record if download fails
            WallpaperImage::updateOrCreate(
                [
                    'wallpaper_id' => $wallpaper->id,
                    'is_primary' => true,
                ],
                [
                    'image_path' => "wallpapers/{$wallpaper->id}/primary.jpg",
                    'title' => $wallpaper->title,
                    'sort_order' => 1,
                ]
            );
        }
    }
}
