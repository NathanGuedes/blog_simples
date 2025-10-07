<?php

namespace Contracts;

use Models\User;

interface UserRepositoryInterface
{
    public function create(User $user): void;
    public function update(User $user): void;
    public function delete(string $id): void;

    public function findById(string $id): bool|array;
    public function findByEmail(string $email): bool|array;
    public function findByToken(string $token): bool|array;
}
