<?php

namespace Database\Seeders;

use App\Models\Paper;
use Illuminate\Database\Seeder;

class PaperSeeder extends Seeder
{
    public function run(): void
    {
        $papers = [
            [
                'name' => 'Premium Matte',
                'description' => 'High-quality matte finish paper that reduces glare and provides a smooth, elegant surface.',
                'type' => 'Matte',
                'thickness' => 180,
                'size' => 'A3',
                'color' => 'White',
                'finish' => 'Smooth',
                'usage' => 'Perfect for living rooms and bedrooms where a non-reflective finish is desired.',
                'is_active' => true,
                'price' => 12.99,
            ],
            [
                'name' => 'Glossy Premium',
                'description' => 'Vibrant glossy paper that makes colors pop with a reflective, modern finish.',
                'type' => 'Glossy',
                'thickness' => 200,
                'size' => 'A3',
                'color' => 'White',
                'finish' => 'Glossy',
                'usage' => 'Ideal for kitchens, bathrooms, and spaces that benefit from easy-to-clean surfaces.',
                'is_active' => true,
                'price' => 15.99,
            ],
            [
                'name' => 'Eco Recycled',
                'description' => 'Environmentally friendly recycled paper with a natural texture.',
                'type' => 'Recycled',
                'thickness' => 150,
                'size' => 'A4',
                'color' => 'Natural',
                'finish' => 'Textured',
                'usage' => 'Great for eco-conscious projects and rustic, natural interior designs.',
                'is_active' => true,
                'price' => 10.99,
            ],
            [
                'name' => 'Silk Textured',
                'description' => 'Luxury silk-textured paper with a subtle sheen and soft touch.',
                'type' => 'Silk',
                'thickness' => 220,
                'size' => 'A3',
                'color' => 'Ivory',
                'finish' => 'Textured',
                'usage' => 'Premium option for elegant dining rooms and formal spaces.',
                'is_active' => true,
                'price' => 18.99,
            ],
            [
                'name' => 'Canvas Effect',
                'description' => 'Textured paper that mimics canvas for an artistic, gallery-like appearance.',
                'type' => 'Canvas',
                'thickness' => 240,
                'size' => 'A2',
                'color' => 'Natural',
                'finish' => 'Textured',
                'usage' => 'Perfect for art-focused spaces and creative studios.',
                'is_active' => true,
                'price' => 22.99,
            ],
            [
                'name' => 'Vinyl Durable',
                'description' => 'Water-resistant vinyl paper ideal for high-traffic and moisture-prone areas.',
                'type' => 'Vinyl',
                'thickness' => 280,
                'size' => 'A3',
                'color' => 'White',
                'finish' => 'Smooth',
                'usage' => 'Excellent for bathrooms, kitchens, and commercial spaces.',
                'is_active' => true,
                'price' => 19.99,
            ],
        ];

        foreach ($papers as $paper) {
            Paper::firstOrCreate(
                ['name' => $paper['name']],
                $paper
            );
        }
    }
}
