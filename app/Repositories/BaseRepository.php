<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The model class name.
     *
     * @var string
     */
    protected $modelClass;

    /**
     * Create a new repository instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->modelClass = get_class($model);
    }

    /**
     * Get a new query builder instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->newQuery()->select($columns)->get();
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
        return $this->newQuery()->select($columns)->find($id);
    }

    /**
     * Find record by ID or fail.
     *
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id, array $columns = ['*'])
    {
        return $this->newQuery()->select($columns)->findOrFail($id);
    }

    /**
     * Find record by field.
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findBy(string $field, $value, array $columns = ['*'])
    {
        return $this->newQuery()->select($columns)->where($field, $value)->first();
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): Model
    {
        return $this->newQuery()->create($data);
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
        $record = $this->findOrFail($id);
        return $record->update($data);
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);
        return $record->delete();
    }

    /**
     * Get paginated records.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->newQuery()->select($columns)->paginate($perPage);
    }

    /**
     * Get records with relationships.
     * Note: This is for fluent query building. Use newQuery() in repository methods instead.
     *
     * @param array|string $relations
     * @return \App\Repositories\RepositoryInterface
     */
    public function with($relations): RepositoryInterface
    {
        // Note: This method is kept for interface compatibility
        // All repository methods should use newQuery() directly for better isolation
        // This method doesn't modify the base model instance
        return $this;
    }

    /**
     * Add a where clause.
     * Note: This is for fluent query building. Use newQuery() in repository methods instead.
     *
     * @param string $column
     * @param mixed $operator
     * @param mixed $value
     * @return \App\Repositories\RepositoryInterface
     */
    public function where(string $column, $operator = null, $value = null): RepositoryInterface
    {
        // Note: This method is kept for interface compatibility
        // All repository methods should use newQuery() directly for better isolation
        // This method doesn't modify the base model instance
        return $this;
    }

    /**
     * Get count of records.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->newQuery()->count();
    }

    /**
     * Check if a record exists by field (optimized with EXISTS query).
     *
     * @param string $field
     * @param mixed $value
     * @param int|null $excludeId Exclude this ID from the check (useful for updates)
     * @return bool
     */
    public function existsBy(string $field, $value, ?int $excludeId = null): bool
    {
        $query = $this->newQuery()->where($field, $value);
        
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Generate unique slug by checking existence efficiently.
     *
     * @param string $baseSlug
     * @param int|null $excludeId Exclude this ID from the check (useful for updates)
     * @param int $maxAttempts Maximum number of attempts to find a unique slug
     * @return string
     */
    public function generateUniqueSlug(string $baseSlug, ?int $excludeId = null, int $maxAttempts = 100): string
    {
        $slug = $baseSlug;
        $counter = 1;

        // Check if base slug exists (uses newQuery, so doesn't affect model state)
        if (!$this->existsBy('slug', $slug, $excludeId)) {
            return $slug;
        }

        // Try with counter until we find a unique slug
        while ($counter <= $maxAttempts) {
            $slug = $baseSlug . '-' . $counter;
            
            if (!$this->existsBy('slug', $slug, $excludeId)) {
                return $slug;
            }
            
            $counter++;
        }

        // Fallback: use timestamp if we can't find a unique slug
        return $baseSlug . '-' . time();
    }

    /**
     * Get the model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Reset the model instance.
     *
     * @return void
     */
    protected function resetModel(): void
    {
        $this->model = new $this->modelClass;
    }
}

