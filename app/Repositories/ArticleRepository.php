<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published articles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublishedArticles()
    {
        return $this->newQuery()
            ->with(['category', 'author'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();
    }

    /**
     * Find article by slug.
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findBySlug(string $slug)
    {
        return $this->newQuery()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->first();
    }

    /**
     * Get featured articles.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedArticles(int $limit = 3)
    {
        return $this->newQuery()
            ->with(['category', 'author'])
            ->where('is_published', true)
            ->where('featured', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get latest articles.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatestArticles(int $limit = 6)
    {
        return $this->newQuery()
            ->with(['category', 'author'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get articles by category.
     *
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByCategory(int $categoryId)
    {
        return $this->newQuery()
            ->with(['category', 'author'])
            ->where('category_id', $categoryId)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();
    }

    /**
     * Get related articles (excluding current article).
     *
     * @param int $articleId
     * @param int $categoryId
     * @param array $tagIds
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedArticles(int $articleId, int $categoryId, array $tagIds = [], int $limit = 4)
    {
        $query = $this->newQuery()
            ->with(['category', 'author'])
            ->where('id', '!=', $articleId)
            ->where('is_published', true)
            ->where('published_at', '<=', now());

        // Prioritize same category
        $query->where(function ($q) use ($categoryId, $tagIds) {
            $q->where('category_id', $categoryId);
            if (!empty($tagIds)) {
                $q->orWhere(function ($subQ) use ($tagIds) {
                    foreach ($tagIds as $tagId) {
                        $subQ->orWhereJsonContains('tags', $tagId);
                    }
                });
            }
        });

        return $query
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

