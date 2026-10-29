<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->getAll(
            max(1, min($perPage, 100))
        );
    }

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function getById(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    public function update(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}