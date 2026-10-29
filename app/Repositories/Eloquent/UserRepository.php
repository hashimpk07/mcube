<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get paginated users.
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create a new user.
     */
    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::query()->create($data);
    }

    /**
     * Find a user by ID.
     */
    public function findById(int $id): User
    {
        return User::query()->findOrFail($id);
    }

    /**
     * Update an existing user.
     */
    public function update(int $id, array $data): User
    {
        $user = $this->findById($id);

        if (isset($data['password']) && $data['password'] !== '') {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user->refresh();
    }

    /**
     * Delete a user.
     */
    public function delete(int $id): bool
    {
        return (bool) $this->findById($id)->delete();
    }
}
