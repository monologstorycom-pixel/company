<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Display a listing of products with filtering and search.
     */
    public function index(Request $request)
    {
        // Cache categories separately (they change less frequently)
        $categories = Cache::remember('products.categories.active', 3600, function () {
            return ProductCategory::where('is_active', true)->orderBy('name')->get();
        });

        // Build query for products (don't cache pagination results to avoid stale data)
        $query = \App\Models\Product::with(['category', 'media'])
            ->where('is_active', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'price':
                $query->orderBy('price', $sortDirection);
                break;
            case 'created':
                $query->orderBy('created_at', $sortDirection);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $data = [
            'products' => $query->paginate(12)->withQueryString(),
            'categories' => $categories,
        ];

        // SEO Meta Tags
        $seoMeta = [
            'title' => 'Our Products - Premium Herbal & Food Products | PT Lestari Jaya Bangsa',
            'description' => 'Explore our premium herbal and processed food products. 100% natural, Halal certified, and BPOM approved products for your health.',
            'keywords' => 'herbal products, food products, halal certified, BPOM approved, natural products',
            'og_title' => 'Our Products - PT Lestari Jaya Bangsa',
            'og_description' => 'Discover premium herbal and processed food products',
            'og_type' => 'website',
            'og_image' => asset('images/logo.png'),
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.products.index', $data);
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = $this->productService->getBySlug($slug);
        
        if (!$product) {
            abort(404);
        }

        $relatedProducts = $this->productService->getRelatedProducts($product, 4);

        // SEO Meta Tags
        $seoMeta = [
            'title' => $product->meta_title ?? ($product->name . ' - PT Lestari Jaya Bangsa'),
            'description' => $product->meta_description ?? Str::limit(strip_tags($product->description), 160),
            'keywords' => $product->name . ', herbal products, food products',
            'og_title' => $product->name,
            'og_description' => Str::limit(strip_tags($product->description), 160),
            'og_type' => 'product',
            'og_image' => $product->getFirstMediaUrl('images') ?: asset('images/logo.png'),
            'json_ld' => $this->generateProductJsonLd($product),
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Generate JSON-LD structured data for product.
     */
    protected function generateProductJsonLd($product): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => strip_tags($product->description),
            'image' => $product->getFirstMediaUrl('images') ?: asset('images/logo.png'),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'PT Lestari Jaya Bangsa',
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $product->price ?? '0',
                'priceCurrency' => 'IDR',
                'availability' => $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ],
            'category' => $product->category->name ?? '',
        ];
    }
}
