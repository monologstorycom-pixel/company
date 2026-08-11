<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*']);

    /**
     * Find record by ID.
     *
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id, array $columns = ['*']);

    /**
     * Find record by ID or fail.
     *
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id, array $columns = ['*']);

    /**
     * Find record by field.
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findBy(string $field, $value, array $columns = ['*']);

    /**
     * Create a new record.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update a record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get paginated records.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']);

    /**
     * Get records with relationships.
     *
     * @param array|string $relations
     * @return \App\Repositories\RepositoryInterface
     */
    public function with($relations);

    /**
     * Add a where clause.
     *
     * @param string $column
     * @param mixed $operator
     * @param mixed $value
     * @return \App\Repositories\RepositoryInterface
     */
    public function where(string $column, $operator = null, $value = null);

    /**
     * Get count of records.
     *
     * @return int
     */
    public function count(): int;
}

