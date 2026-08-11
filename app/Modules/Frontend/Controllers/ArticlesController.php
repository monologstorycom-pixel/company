<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    public function index(Request $request)
    {
        // Cache categories separately (they change less frequently)
        $categories = Cache::remember('articles.categories.all', 3600, function () {
            return ArticleCategory::all();
        });

        // Build query for articles (don't cache pagination results to avoid stale data)
        $query = \App\Models\Article::with(['category', 'author'])
            ->where('is_published', true)
            ->where('published_at', '<=', now());

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('content', 'like', '%' . $searchTerm . '%')
                  ->orWhere('excerpt', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by tag (if tags are stored as array)
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        $data = [
            'articles' => $query->orderBy('published_at', 'desc')->paginate(9)->withQueryString(),
            'categories' => $categories,
        ];

        // SEO Meta Tags
        $seoMeta = [
            'title' => 'News & Articles - Latest Updates | PT Lestari Jaya Bangsa',
            'description' => 'Stay updated with the latest news, articles, and updates about our herbal and food products.',
            'keywords' => 'news, articles, herbal products, health tips, product updates',
            'og_title' => 'News & Articles - PT Lestari Jaya Bangsa',
            'og_description' => 'Latest news and articles about our products',
            'og_type' => 'website',
            'og_image' => asset('images/logo.png'),
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.articles.index', $data);
    }

    public function show($slug)
    {
        $article = $this->articleService->getBySlug($slug);
        
        if (!$article) {
            abort(404);
        }

        // Increment view count
        $this->articleService->incrementViews($article);

        $relatedArticles = $this->articleService->getRelatedArticles($article, 3);

        // SEO Meta Tags
        $seoMeta = [
            'title' => $article->meta_title ?? $article->title,
            'description' => $article->meta_description ?? Str::limit(strip_tags($article->excerpt ?: $article->content), 160),
            'keywords' => implode(', ', $article->tags ?? []) . ', news, articles',
            'og_title' => $article->title,
            'og_description' => Str::limit(strip_tags($article->excerpt ?: $article->content), 160),
            'og_type' => 'article',
            'og_image' => $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/logo.png'),
            'article_published_time' => $article->published_at?->toIso8601String(),
            'article_author' => $article->author->name ?? 'PT Lestari Jaya Bangsa',
            'json_ld' => $this->generateArticleJsonLd($article),
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.articles.show', compact('article', 'relatedArticles'));
    }

    /**
     * Generate JSON-LD structured data for article.
     */
    protected function generateArticleJsonLd($article): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => strip_tags($article->excerpt ?: $article->content),
            'image' => $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/logo.png'),
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $article->author->name ?? 'PT Lestari Jaya Bangsa',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'PT Lestari Jaya Bangsa',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
        ];
    }
}
