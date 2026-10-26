<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Geometric',
                'description' => 'Modern geometric patterns and shapes for contemporary interiors.'
            ],
            [
                'name' => 'Floral',
                'description' => 'Beautiful botanical and floral designs inspired by nature.'
            ],
            [
                'name' => 'Abstract',
                'description' => 'Artistic abstract patterns for bold, creative spaces.'
            ],
            [
                'name' => 'Minimalist',
                'description' => 'Clean, simple designs for modern minimalist aesthetics.'
            ],
            [
                'name' => 'Vintage',
                'description' => 'Classic and retro-inspired patterns with timeless appeal.'
            ],
            [
                'name' => 'Textured',
                'description' => 'Designs that mimic natural textures like linen, wood, and stone.'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                ]
            );
        }
    }
}
