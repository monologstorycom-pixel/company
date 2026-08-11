<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    /**
     * Get contacts by status.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByStatus(string $status)
    {
        return $this->model->where('status', $status)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get unread contacts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreadContacts()
    {
        return $this->model->where('status', 'unread')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Mark contact as read.
     *
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        return $this->update($id, [
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    /**
     * Mark contact as replied.
     *
     * @param int $id
     * @return bool
     */
    public function markAsReplied(int $id): bool
    {
        return $this->update($id, ['status' => 'replied']);
    }
}

