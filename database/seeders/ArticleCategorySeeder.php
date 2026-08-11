<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Articles about health, wellness, and natural remedies',
                'status' => 'active',
            ],
            [
                'name' => 'Product Information',
                'slug' => 'product-information',
                'description' => 'Detailed information about our products and their benefits',
                'status' => 'active',
            ],
            [
                'name' => 'Company News',
                'slug' => 'company-news',
                'description' => 'Latest news and updates from PT Lestari Jaya Bangsa',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            ArticleCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}