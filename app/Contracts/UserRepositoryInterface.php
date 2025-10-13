<?php

namespace Contracts;

use Models\UserDTO;

interface UserRepositoryInterface
{
    public function create(UserDTO $user): void;
    public function update(UserDTO $user): void;
    public function delete(string $id): void;

    public function findById(string $id): bool|array;
    public function findByEmail(string $email): bool|array;
    public function findByToken(string $token): bool|array;
}
