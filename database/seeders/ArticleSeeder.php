<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $healthCategory = ArticleCategory::where('slug', 'health-wellness')->first();
        $productCategory = ArticleCategory::where('slug', 'product-information')->first();
        $admin = User::where('email', 'superadmin@ljs.com')->first();

        $articles = [
            [
                'title' => 'The Benefits of Ginger in Traditional Medicine',
                'slug' => 'benefits-ginger-traditional-medicine',
                'excerpt' => 'Discover how ginger has been used for centuries in traditional medicine and its modern health benefits.',
                'content' => '<p>Ginger (Zingiber officinale) has been a cornerstone of traditional medicine for thousands of years. Used extensively in Ayurvedic and Chinese medicine, this powerful root offers numerous health benefits backed by modern scientific research.</p>

<h2>Anti-Inflammatory Properties</h2>
<p>Ginger contains potent anti-inflammatory compounds called gingerols. These compounds help reduce inflammation throughout the body, making ginger particularly beneficial for those suffering from arthritis or chronic inflammatory conditions.</p>

<h2>Digestive Health</h2>
<p>One of ginger\'s most well-known benefits is its ability to aid digestion. It helps stimulate digestive enzymes, reduces nausea, and can alleviate symptoms of indigestion and motion sickness.</p>

<h2>Immune System Support</h2>
<p>The antioxidants in ginger help strengthen the immune system and protect against oxidative stress. Regular consumption may help reduce the frequency of common colds and infections.</p>

<h2>Traditional Uses</h2>
<p>In traditional medicine systems, ginger has been used to treat everything from headaches and menstrual cramps to respiratory conditions. Its warming properties make it particularly useful in cold climates or during winter months.</p>

<p>At PT Lestari Jaya Bangsa, we carefully select the finest ginger roots to create our premium ginger tea blends, ensuring you receive all the natural benefits of this remarkable herb.</p>',
                'category_id' => $healthCategory?->id,
                'author_id' => $admin?->id,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Understanding Halal Certification: What It Means for Our Products',
                'slug' => 'understanding-halal-certification',
                'excerpt' => 'Learn about the importance of Halal certification and how it ensures the quality and purity of our herbal products.',
                'content' => '<p>Halal certification is more than just a label—it represents a commitment to quality, purity, and ethical production standards that align with Islamic principles. At PT Lestari Jaya Bangsa, every product bearing our Halal certification has undergone rigorous testing and verification.</p>

<h2>What is Halal Certification?</h2>
<p>Halal certification ensures that products are free from any substances forbidden in Islam and that they have been produced according to Islamic guidelines. This includes not only the ingredients themselves but also the entire production process.</p>

<h2>Our Certification Process</h2>
<p>Our products are certified by MUI (Majelis Ulama Indonesia), the highest Islamic authority in Indonesia. This involves:</p>
<ul>
<li>Regular facility inspections</li>
<li>Ingredient verification</li>
<li>Production process monitoring</li>
<li>Annual recertification</li>
</ul>

<h2>Quality Assurance</h2>
<p>Halal certification goes hand-in-hand with our commitment to quality. Products that meet Halal standards must also meet strict safety and purity requirements, ensuring you receive only the best natural ingredients.</p>

<p>When you choose our Halal-certified products, you\'re not just making a choice for your health—you\'re also making an ethical choice that supports sustainable and responsible production practices.</p>',
                'category_id' => $productCategory?->id,
                'author_id' => $admin?->id,
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($articles as $article) {
            Article::firstOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}