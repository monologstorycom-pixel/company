<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveProducts()
    {
        return $this->newQuery()
            ->with(['category', 'media'])
            ->where('is_active', true)
            ->get();
    }

    /**
     * Get featured products.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedProducts(int $limit = 6)
    {
        return $this->newQuery()
            ->with(['category', 'media'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->limit($limit)
            ->get();
    }

    /**
     * Find product by slug.
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findBySlug(string $slug)
    {
        return $this->newQuery()
            ->with(['category', 'media'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get products by category.
     *
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCategory(int $categoryId)
    {
        return $this->newQuery()
            ->with(['category', 'media'])
            ->where('product_category_id', $categoryId)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Get related products (excluding current product).
     *
     * @param int $productId
     * @param int $categoryId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedProducts(int $productId, int $categoryId, int $limit = 4)
    {
        return $this->newQuery()
            ->with(['category', 'media'])
            ->where('product_category_id', $categoryId)
            ->where('id', '!=', $productId)
            ->where('is_active', true)
            ->limit($limit)
            ->get();
    }
}

