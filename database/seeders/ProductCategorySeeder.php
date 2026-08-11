<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Herbal Teas',
                'slug' => 'herbal-teas',
                'description' => 'Traditional herbal tea blends for health and wellness',
                'is_active' => true,
            ],
            [
                'name' => 'Spices & Seasonings',
                'slug' => 'spices-seasonings',
                'description' => 'Natural spices and seasonings for cooking',
                'is_active' => true,
            ],
            [
                'name' => 'Health Supplements',
                'slug' => 'health-supplements',
                'description' => 'Natural health supplements and vitamins',
                'is_active' => true,
            ],
            [
                'name' => 'Essential Oils',
                'slug' => 'essential-oils',
                'description' => 'Pure essential oils for aromatherapy and wellness',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}