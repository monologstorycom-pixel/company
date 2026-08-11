<?php

namespace App\Services;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class BaseService
{
    /**
     * The repository instance.
     *
     * @var \App\Repositories\RepositoryInterface
     */
    protected $repository;

    /**
     * Cache TTL in seconds (30 minutes default).
     */
    const CACHE_TTL = 1800;

    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*'])
    {
        return $this->repository->all($columns);
    }

    /**
     * Find record by ID.
     *
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, array $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Find record by ID or fail.
     *
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrFail(int $id, array $columns = ['*'])
    {
        return $this->repository->findOrFail($id, $columns);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update a record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get paginated records.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'])
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * Get cache with tags support (with fallback for drivers that don't support tags).
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @param array $tags
     * @return mixed
     */
    protected function rememberWithTags(string $key, callable $callback, ?int $ttl = null, array $tags = []): mixed
    {
        $ttl = $ttl ?? self::CACHE_TTL;

        try {
            if (!empty($tags) && $this->cacheSupportsTags()) {
                return Cache::tags($tags)->remember($key, $ttl, $callback);
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
     * @param array $tags
     * @return bool
     */
    protected function forgetWithTags(string $key, array $tags = []): bool
    {
        try {
            if (!empty($tags) && $this->cacheSupportsTags()) {
                Cache::tags($tags)->forget($key);
                return true;
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags, fallback to regular cache
        }

        return Cache::forget($key);
    }

    /**
     * Flush cache by tags.
     *
     * @param array $tags
     * @return bool
     */
    protected function flushByTags(array $tags): bool
    {
        try {
            if (!empty($tags) && $this->cacheSupportsTags()) {
                Cache::tags($tags)->flush();
                return true;
            }
        } catch (\BadMethodCallException $e) {
            // Cache driver doesn't support tags
        }

        return false;
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
     * Execute database operations within a transaction.
     *
     * @param callable $callback
     * @return mixed
     * @throws \Throwable
     */
    protected function transaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}

