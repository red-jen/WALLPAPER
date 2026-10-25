<?php

namespace Database\Seeders;

use App\Models\Design;
use App\Models\User;
use App\Models\Category;
use App\Models\Paper;
use Illuminate\Database\Seeder;

class DesignSeeder extends Seeder
{
    public function run(): void
    {
        $designer1 = User::where('email', 'designer@murart.com')->first();
        $designer2 = User::where('email', 'designer2@murart.com')->first();

        $geometricCat = Category::where('name', 'Geometric')->first();
        $floralCat = Category::where('name', 'Floral')->first();
        $abstractCat = Category::where('name', 'Abstract')->first();
        $minimalistCat = Category::where('name', 'Minimalist')->first();
        $vintageCat = Category::where('name', 'Vintage')->first();
        $texturedCat = Category::where('name', 'Textured')->first();

        $designs = [
            [
                'title' => 'Hexagonal Harmony',
                'designer_id' => $designer1->id,
                'category_id' => $geometricCat->id,
                'image_path' => 'designs/hexagonal-harmony.jpg',
            ],
            [
                'title' => 'Nordic Triangles',
                'designer_id' => $designer1->id,
                'category_id' => $geometricCat->id,
                'image_path' => 'designs/nordic-triangles.jpg',
            ],
            [
                'title' => 'Botanical Garden',
                'designer_id' => $designer2->id,
                'category_id' => $floralCat->id,
                'image_path' => 'designs/botanical-garden.jpg',
            ],
            [
                'title' => 'Wildflower Meadow',
                'designer_id' => $designer2->id,
                'category_id' => $floralCat->id,
                'image_path' => 'designs/wildflower-meadow.jpg',
            ],
            [
                'title' => 'Urban Dreams',
                'designer_id' => $designer1->id,
                'category_id' => $abstractCat->id,
                'image_path' => 'designs/urban-dreams.jpg',
            ],
            [
                'title' => 'Zen Lines',
                'designer_id' => $designer2->id,
                'category_id' => $minimalistCat->id,
                'image_path' => 'designs/zen-lines.jpg',
            ],
            [
                'title' => 'Retro Waves',
                'designer_id' => $designer1->id,
                'category_id' => $vintageCat->id,
                'image_path' => 'designs/retro-waves.jpg',
            ],
            [
                'title' => 'Linen Weave',
                'designer_id' => $designer2->id,
                'category_id' => $texturedCat->id,
                'image_path' => 'designs/linen-weave.jpg',
            ],
            [
                'title' => 'Scandinavian Simple',
                'designer_id' => $designer1->id,
                'category_id' => $minimalistCat->id,
                'image_path' => 'designs/scandinavian-simple.jpg',
            ],
            [
                'title' => 'Art Deco Revival',
                'designer_id' => $designer2->id,
                'category_id' => $vintageCat->id,
                'image_path' => 'designs/art-deco-revival.jpg',
            ],
        ];

        $papers = Paper::all();

        foreach ($designs as $designData) {
            $design = Design::firstOrCreate(
                ['title' => $designData['title']],
                $designData
            );

            // Attach 2-3 recommended papers to each design
            if ($design->papers()->count() === 0) {
                $recommendedPapers = $papers->random(min(3, $papers->count()));
                $design->papers()->attach($recommendedPapers->pluck('id'));
            }
        }
    }
}
