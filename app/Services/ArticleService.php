<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Models\Article;
use App\Jobs\ProcessImageUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ArticleService
{
    /**
     * Cache tags for articles.
     */
    const CACHE_TAGS = ['articles'];

    /**
     * Cache TTL in seconds (30 minutes).
     */
    const CACHE_TTL = 1800;

    public function __construct(
        protected ArticleRepository $repository
    ) {}

    /**
     * Get cache with tags support.
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    protected function remember(string $key, callable $callback, ?int $ttl = null): mixed
    {
        $ttl = $ttl ?? self::CACHE_TTL;

        try {
            if ($this->cacheSupportsTags()) {
                return Cache::tags(self::CACHE_TAGS)->remember($key, $ttl, $callback);
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags, fallback to regular cache
        }

        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Forget cache with tags support.
     *
     * @param string $key
     * @return bool
     */
    protected function forget(string $key): bool
    {
        try {
            if ($this->cacheSupportsTags()) {
                return Cache::tags(self::CACHE_TAGS)->forget($key);
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags, fallback to regular cache
        }

        return Cache::forget($key);
    }

    /**
     * Check if cache driver supports tags.
     *
     * @return bool
     */
    protected function cacheSupportsTags(): bool
    {
        $driver = config('cache.default');
        $tagSupportedDrivers = ['redis', 'memcached', 'dynamodb'];
        
        return in_array($driver, $tagSupportedDrivers);
    }

    /**
     * Get published articles with caching.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublishedArticles()
    {
        return $this->remember('articles.published', function () {
            return $this->repository->getPublishedArticles();
        });
    }

    /**
     * Get latest articles with caching.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatestArticles(int $limit = 6)
    {
        return $this->remember("articles.latest.{$limit}", function () use ($limit) {
            return $this->repository->getLatestArticles($limit);
        });
    }

    /**
     * Get featured articles with caching.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedArticles(int $limit = 3)
    {
        return $this->remember("articles.featured.{$limit}", function () use ($limit) {
            return $this->repository->getFeaturedArticles($limit);
        });
    }

    /**
     * Get article by slug.
     *
     * @param string $slug
     * @return \App\Models\Article|null
     */
    public function getBySlug(string $slug)
    {
        return $this->remember("article.slug.{$slug}", function () use ($slug) {
            return $this->repository->findBySlug($slug);
        });
    }

    /**
     * Get related articles.
     *
     * @param \App\Models\Article $article
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedArticles(Article $article, int $limit = 4)
    {
        $tagIds = $article->tags ? $article->tags : [];
        
        return $this->repository->getRelatedArticles(
            $article->id,
            $article->category_id,
            $tagIds,
            $limit
        );
    }

    /**
     * Increment article view count.
     *
     * @param \App\Models\Article $article
     * @return void
     */
    public function incrementViews(Article $article): void
    {
        $article->increment('view_count');
        $this->forget("article.slug.{$article->slug}");
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @param array|null $tags Tag IDs to attach
     * @param \Illuminate\Http\UploadedFile|null $featuredImage Featured image file
     * @return \App\Models\Article
     */
    public function create(array $data, ?array $tags = null, ?UploadedFile $featuredImage = null): Article
    {
        return DB::transaction(function () use ($data, $tags, $featuredImage) {
            // Normalize category_id (handle both article_category_id and category_id)
            if (isset($data['article_category_id'])) {
                $data['category_id'] = $data['article_category_id'];
                unset($data['article_category_id']);
            }

            // Set author_id if not provided
            if (empty($data['author_id'])) {
                $data['author_id'] = auth()->id();
            }

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

            // Ensure slug is unique (optimized with EXISTS query)
            $data['slug'] = $this->repository->generateUniqueSlug($data['slug']);

        // Auto-generate meta title if not provided
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }

        // Auto-generate meta description if not provided
        if (empty($data['meta_description']) && !empty($data['excerpt'])) {
            $data['meta_description'] = Str::limit($data['excerpt'], 160);
        } elseif (empty($data['meta_description'])) {
            $data['meta_description'] = Str::limit(strip_tags($data['content']), 160);
        }

        // Set published_at if not set and is_published is true
        if (empty($data['published_at']) && ($data['is_published'] ?? false)) {
            $data['published_at'] = now();
        }

            // Handle featured image upload
            if ($featuredImage) {
                $filename = $this->uploadFeaturedImage($featuredImage);
                $data['featured_image'] = $filename;
                
                // Dispatch job to process image asynchronously
                $imagePath = 'uploads/articles/' . $filename;
                ProcessImageUpload::dispatch($imagePath, $imagePath, [
                    'max_width' => 1920,
                    'max_height' => 1080,
                    'quality' => 85,
                ])->onQueue('images');
            }

        $article = $this->repository->create($data);

            // Handle tags
            if ($tags !== null) {
                $article->tags()->sync($tags);
            }

        // Clear cache
        $this->clearCache();

        return $article;
        });
    }

    /**
     * Update an article.
     *
     * @param int $id
     * @param array $data
     * @param array|null $tags Tag IDs to sync (null means don't change tags)
     * @param \Illuminate\Http\UploadedFile|null $featuredImage Featured image file
     * @param bool $deleteOldImage Whether to delete old image when uploading new one
     * @return bool
     */
    public function update(int $id, array $data, ?array $tags = null, ?UploadedFile $featuredImage = null, bool $deleteOldImage = true): bool
    {
        return DB::transaction(function () use ($id, $data, $tags, $featuredImage, $deleteOldImage) {
            $article = $this->repository->findOrFail($id);

            // Normalize category_id (handle both article_category_id and category_id)
            if (isset($data['article_category_id'])) {
                $data['category_id'] = $data['article_category_id'];
                unset($data['article_category_id']);
            }

        // Update slug if title changed
            if (isset($data['title']) && $article->title !== $data['title']) {
                $data['slug'] = Str::slug($data['title']);
                // Ensure slug is unique (optimized with EXISTS query, exclude current article)
                $data['slug'] = $this->repository->generateUniqueSlug($data['slug'], $id);
        }

        // Auto-generate meta fields if not provided
        if (isset($data['title']) && empty($data['meta_title'])) {
            $data['meta_title'] = $data['title'];
        }

        if (isset($data['excerpt']) && empty($data['meta_description'])) {
            $data['meta_description'] = Str::limit($data['excerpt'], 160);
        } elseif (isset($data['content']) && empty($data['meta_description'])) {
            $data['meta_description'] = Str::limit(strip_tags($data['content']), 160);
        }

        // Set published_at if not set and is_published is true
        if (isset($data['is_published']) && $data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

            // Handle featured image upload
            if ($featuredImage) {
                // Delete old image if requested
                if ($deleteOldImage && $article->featured_image) {
                    $this->deleteFeaturedImage($article->featured_image);
                }
                $filename = $this->uploadFeaturedImage($featuredImage);
                $data['featured_image'] = $filename;
                
                // Dispatch job to process image asynchronously
                $imagePath = 'uploads/articles/' . $filename;
                ProcessImageUpload::dispatch($imagePath, $imagePath, [
                    'max_width' => 1920,
                    'max_height' => 1080,
                    'quality' => 85,
                ])->onQueue('images');
            }

        $result = $this->repository->update($id, $data);

            // Handle tags
            if ($tags !== null) {
                $article->tags()->sync($tags);
            }

        // Clear cache
            $this->forget("article.slug.{$article->slug}");
        $this->clearCache();

        return $result;
        });
    }

    /**
     * Delete an article.
     *
     * @param int $id
     * @param bool $deleteImage Whether to delete featured image
     * @return bool
     */
    public function delete(int $id, bool $deleteImage = true): bool
    {
        return DB::transaction(function () use ($id, $deleteImage) {
            $article = $this->repository->findOrFail($id);
        
            // Delete featured image if requested
            if ($deleteImage && $article->featured_image) {
                $this->deleteFeaturedImage($article->featured_image);
        }

            // Delete tags relationship
            $article->tags()->detach();

            // Delete article
        $result = $this->repository->delete($id);

        // Clear cache
            $this->forget("article.slug.{$article->slug}");
        $this->clearCache();

        return $result;
        });
    }

    /**
     * Upload featured image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return string Filename
     */
    protected function uploadFeaturedImage(UploadedFile $image): string
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('uploads/articles', $filename, 'public');
        return basename($path);
    }

    /**
     * Delete featured image.
     *
     * @param string $filename
     * @return bool
     */
    protected function deleteFeaturedImage(string $filename): bool
    {
        $path = 'uploads/articles/' . $filename;
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        // Fallback to public_path for legacy images
        $publicPath = public_path('uploads/' . $filename);
        if (file_exists($publicPath)) {
            return unlink($publicPath);
        }
        return false;
    }

    /**
     * Get paginated articles with filters.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginated(array $filters = [], int $perPage = 15)
    {
        $query = $this->repository->getModel()->newQuery()->with(['category', 'author']);

        // Apply search filter
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if (isset($filters['status']) && !empty($filters['status'])) {
            if ($filters['status'] === 'published') {
                $query->where('is_published', true);
            } elseif ($filters['status'] === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Apply category filter
        if (isset($filters['category']) && !empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Clear article cache using tags (fixes wildcard issue).
     *
     * @return void
     */
    protected function clearCache(): void
    {
        try {
            if ($this->cacheSupportsTags()) {
                // Flush all cache with articles tag (efficient way to clear all article-related cache)
                Cache::tags(self::CACHE_TAGS)->flush();
                return;
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags, fallback to manual clearing
        }

        // Fallback: manually clear known cache keys
        // Note: This doesn't handle wildcards, but we list all possible keys
        $this->forget('articles.published');
        
        // Clear latest articles cache for common limits
        for ($i = 1; $i <= 20; $i++) {
            $this->forget("articles.latest.{$i}");
        }
        
        // Clear featured articles cache for common limits
        for ($i = 1; $i <= 10; $i++) {
            $this->forget("articles.featured.{$i}");
        }
    }
}

