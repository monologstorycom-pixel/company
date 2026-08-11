<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class HomepageController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ArticleService $articleService
    ) {}

    public function index()
    {
        // Get featured products with caching (limit to 6)
        $featuredProducts = $this->productService->getFeaturedProducts(6);

        // Get latest articles with caching (limit to 3)
        $latestArticles = $this->articleService->getLatestArticles(3);

        // Get homepage content from settings/pages with caching
        $homepageContent = Cache::remember('homepage.content', 3600, function () {
            return \App\Models\Page::where('slug', 'home')->first();
        });

        // SEO Meta Tags
        $seoMeta = [
            'title' => 'Home - PT Lestari Jaya Bangsa | Premium Herbal & Food Products Since 1992',
            'description' => 'PT Lestari Jaya Bangsa delivers premium herbal and processed food products, combining health and taste in every creation. Established in 1992.',
            'keywords' => 'herbal products, food products, natural products, halal certified, BPOM approved, PT Lestari Jaya Bangsa',
            'og_title' => 'PT Lestari Jaya Bangsa - Food & Herbal Products',
            'og_description' => 'Premium herbal and processed food products, combining health and taste since 1992',
            'og_type' => 'website',
            'og_image' => asset('images/logo.png'),
            'json_ld' => [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'PT Lestari Jaya Bangsa',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
                'description' => 'Premium herbal and processed food products, combining health and taste in every creation',
                'foundingDate' => '1992',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak, Bangsa',
                    'addressLocality' => 'Kec. Kebasen',
                    'addressRegion' => 'Jawa Tengah',
                    'postalCode' => '53282',
                    'addressCountry' => 'ID',
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '(+62) 821-9698-146',
                    'contactType' => 'customer service',
                    'hoursAvailable' => 'Mo-Fr 07:00-16:00',
                ],
            ],
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.homepage', compact('featuredProducts', 'latestArticles', 'homepageContent'));
    }
}