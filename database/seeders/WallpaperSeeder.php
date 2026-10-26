<?php

namespace Database\Seeders;

use App\Models\Wallpaper;
use App\Models\WallpaperImage;
use App\Models\Category;
use App\Models\Paper;
use Illuminate\Database\Seeder;

class WallpaperSeeder extends Seeder
{
    public function run(): void
    {
        $geometricCat = Category::where('name', 'Geometric')->first();
        $floralCat = Category::where('name', 'Floral')->first();
        $abstractCat = Category::where('name', 'Abstract')->first();
        $minimalistCat = Category::where('name', 'Minimalist')->first();
        $vintageCat = Category::where('name', 'Vintage')->first();
        $texturedCat = Category::where('name', 'Textured')->first();

        $wallpapers = [
            [
                'title' => 'Golden Hexagons',
                'description' => 'Elegant geometric pattern featuring gold hexagons on a neutral background. Perfect for adding a touch of luxury to any room.',
                'category_id' => $geometricCat->id,
                'price' => 49.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 50,
                'status' => 'published',
            ],
            [
                'title' => 'Midnight Geometry',
                'description' => 'Bold black and navy geometric shapes creating a modern, sophisticated look ideal for contemporary spaces.',
                'category_id' => $geometricCat->id,
                'price' => 54.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 45,
                'status' => 'featured',
            ],
            [
                'title' => 'Spring Blossom',
                'description' => 'Delicate cherry blossoms and soft pink florals bring the beauty of spring indoors year-round.',
                'category_id' => $floralCat->id,
                'price' => 44.99,
                'width' => 1920,
                'height' => 2560,
                'stock' => 60,
                'status' => 'published',
            ],
            [
                'title' => 'Tropical Paradise',
                'description' => 'Vibrant tropical leaves and exotic flowers create a bold, energetic atmosphere.',
                'category_id' => $floralCat->id,
                'price' => 52.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 40,
                'status' => 'featured',
            ],
            [
                'title' => 'Watercolor Dreams',
                'description' => 'Soft, flowing watercolor patterns in blues and purples for a dreamy, artistic ambiance.',
                'category_id' => $abstractCat->id,
                'price' => 46.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 55,
                'status' => 'published',
            ],
            [
                'title' => 'Marble Veins',
                'description' => 'Luxurious marble texture with elegant gold veining for a high-end, sophisticated look.',
                'category_id' => $abstractCat->id,
                'price' => 59.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 35,
                'status' => 'featured',
            ],
            [
                'title' => 'Pure Lines',
                'description' => 'Clean, minimal black lines on white background for ultimate simplicity and elegance.',
                'category_id' => $minimalistCat->id,
                'price' => 39.99,
                'width' => 1920,
                'height' => 2560,
                'stock' => 70,
                'status' => 'published',
            ],
            [
                'title' => 'Soft Gradient',
                'description' => 'Subtle gradient from cream to beige creating a calm, serene atmosphere.',
                'category_id' => $minimalistCat->id,
                'price' => 42.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 65,
                'status' => 'published',
            ],
            [
                'title' => 'Victorian Damask',
                'description' => 'Classic damask pattern in rich burgundy and gold, perfect for traditional elegant interiors.',
                'category_id' => $vintageCat->id,
                'price' => 48.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 42,
                'status' => 'published',
            ],
            [
                'title' => 'Retro Circles',
                'description' => '1970s inspired circles and dots in warm oranges and browns for a fun retro vibe.',
                'category_id' => $vintageCat->id,
                'price' => 45.99,
                'width' => 1920,
                'height' => 2560,
                'stock' => 48,
                'status' => 'published',
            ],
            [
                'title' => 'Natural Linen',
                'description' => 'Realistic linen texture in natural beige, adding warmth and organic feel to any space.',
                'category_id' => $texturedCat->id,
                'price' => 41.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 58,
                'status' => 'published',
            ],
            [
                'title' => 'Concrete Chic',
                'description' => 'Industrial concrete texture perfect for modern loft-style interiors.',
                'category_id' => $texturedCat->id,
                'price' => 43.99,
                'width' => 2048,
                'height' => 2732,
                'stock' => 52,
                'status' => 'published',
            ],
        ];

        $papers = Paper::all();

        foreach ($wallpapers as $wallpaperData) {
            $wallpaper = Wallpaper::firstOrCreate(
                ['title' => $wallpaperData['title']],
                $wallpaperData
            );

            // Create wallpaper image if it doesn't exist
            if ($wallpaper->images()->count() === 0) {
                // Use placeholder images with seed for consistency
                $seed = crc32($wallpaper->title);
                $imageUrl = "https://picsum.photos/seed/{$seed}/800/1200";
                
                WallpaperImage::create([
                    'wallpaper_id' => $wallpaper->id,
                    'image_path' => "wallpapers/{$wallpaper->id}/primary.jpg",
                    'title' => $wallpaper->title,
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);
            }

            // Attach 2-4 compatible papers to each wallpaper
            if ($wallpaper->papers()->count() === 0) {
                $compatiblePapers = $papers->random(min(rand(2, 4), $papers->count()));
                $wallpaper->papers()->attach($compatiblePapers->pluck('id')->mapWithKeys(function ($id) {
                    return [$id => ['is_recommended' => rand(0, 1) === 1]];
                }));
            }
        }
    }
}
