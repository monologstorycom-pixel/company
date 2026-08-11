<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;
use App\Jobs\ProcessProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductService
{
    /**
     * Cache tags for products.
     */
    const CACHE_TAGS = ['products'];

    /**
     * Cache TTL in seconds (1 hour).
     */
    const CACHE_TTL = 3600;

    public function __construct(
        protected ProductRepository $repository
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
     * Get featured products with caching.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedProducts(int $limit = 6)
    {
        return $this->remember("products.featured.{$limit}", function () use ($limit) {
            return $this->repository->getFeaturedProducts($limit);
        });
    }

    /**
     * Get active products with caching.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveProducts()
    {
        return $this->remember('products.active', function () {
            return $this->repository->getActiveProducts();
        });
    }

    /**
     * Get product by slug.
     *
     * @param string $slug
     * @return \App\Models\Product|null
     */
    public function getBySlug(string $slug)
    {
        return $this->remember("product.slug.{$slug}", function () use ($slug) {
            return $this->repository->findBySlug($slug);
        });
    }

    /**
     * Get related products.
     *
     * @param \App\Models\Product $product
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedProducts(Product $product, int $limit = 4)
    {
        return $this->repository->getRelatedProducts(
            $product->id,
            $product->product_category_id,
            $limit
        );
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @param array|null $images Array of uploaded image files
     * @return \App\Models\Product
     */
    public function create(array $data, ?array $images = null): Product
    {
        return DB::transaction(function () use ($data, $images) {
            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Ensure slug is unique (optimized with EXISTS query)
            $data['slug'] = $this->repository->generateUniqueSlug($data['slug']);

            $product = $this->repository->create($data);

            // Handle image uploads using Spatie Media Library
            if ($images && is_array($images)) {
                foreach ($images as $image) {
                    if ($image instanceof UploadedFile) {
                        $media = $product->addMedia($image)->toMediaCollection('images');
                        
                        // Dispatch job to process image asynchronously
                        ProcessProductImage::dispatch($media->id, [
                            'max_width' => 1920,
                            'max_height' => 1080,
                            'quality' => 85,
                        ])->onQueue('images');
                    }
                }
            }

            // Clear cache
            $this->clearCache();

            return $product;
        });
    }

    /**
     * Update a product.
     *
     * @param int $id
     * @param array $data
     * @param array|null $images Array of uploaded image files to add
     * @return bool
     */
    public function update(int $id, array $data, ?array $images = null): bool
    {
        return DB::transaction(function () use ($id, $data, $images) {
            $product = $this->repository->findOrFail($id);

            // Update slug if name changed
            if (isset($data['name']) && $product->name !== $data['name']) {
                $data['slug'] = Str::slug($data['name']);
                // Ensure slug is unique (optimized with EXISTS query, exclude current product)
                $data['slug'] = $this->repository->generateUniqueSlug($data['slug'], $id);
            }

            $result = $this->repository->update($id, $data);

            // Handle image uploads using Spatie Media Library
            if ($images && is_array($images)) {
                foreach ($images as $image) {
                    if ($image instanceof UploadedFile) {
                        $media = $product->addMedia($image)->toMediaCollection('images');
                        
                        // Dispatch job to process image asynchronously
                        ProcessProductImage::dispatch($media->id, [
                            'max_width' => 1920,
                            'max_height' => 1080,
                            'quality' => 85,
                        ])->onQueue('images');
                    }
                }
            }

            // Clear cache
            $this->forget("product.slug.{$product->slug}");
            $this->clearCache();

            return $result;
        });
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $product = $this->repository->findOrFail($id);

            // Clear media collection (Spatie Media Library handles file deletion)
            $product->clearMediaCollection('images');
            $this->forget("product.slug.{$product->slug}");

            $result = $this->repository->delete($id);

            // Clear cache
            $this->clearCache();

            return $result;
        });
    }

    /**
     * Remove a specific image from a product.
     *
     * @param int $productId
     * @param int $mediaId
     * @return bool
     */
    public function removeImage(int $productId, int $mediaId): bool
    {
        return DB::transaction(function () use ($productId, $mediaId) {
            $product = $this->repository->findOrFail($productId);
            
            $media = $product->getMedia('images')->find($mediaId);
            
            if (!$media) {
                return false;
            }

            $media->delete();

            // Clear cache
            $this->forget("product.slug.{$product->slug}");
            $this->clearCache();

            return true;
        });
    }

    /**
     * Get paginated products with filters.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginated(array $filters = [], int $perPage = 15)
    {
        $query = $this->repository->getModel()->newQuery()->with(['category', 'media']);

        // Apply search filter
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if (isset($filters['status']) && !empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->where('is_active', true);
            } elseif ($filters['status'] === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Apply category filter
        if (isset($filters['category']) && !empty($filters['category'])) {
            $query->where('product_category_id', $filters['category']);
        }

        // Apply featured filter
        if (isset($filters['featured']) && $filters['featured'] === '1') {
            $query->where('is_featured', true);
        }

        return $query->paginate($perPage);
    }

    /**
     * Clear product cache using tags (fixes wildcard issue).
     *
     * @return void
     */
    protected function clearCache(): void
    {
        try {
            if ($this->cacheSupportsTags()) {
                // Flush all cache with products tag (efficient way to clear all product-related cache)
                Cache::tags(self::CACHE_TAGS)->flush();
                return;
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags, fallback to manual clearing
        }

        // Fallback: manually clear known cache keys
        $this->forget('products.active');
        
        // Clear featured products cache for common limits
        for ($i = 1; $i <= 20; $i++) {
            $this->forget("products.featured.{$i}");
        }
    }
}

