<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Create Super Admin user first
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@ljs.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('Super Admin');

        $this->call(ChatbotRuleSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ArticleCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ArticleSeeder::class);
    }
}
