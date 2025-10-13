<?php

namespace Contracts;

use Models\PostDTO;

interface PostRepositoryInterface
{
    public function create(PostDTO $post): void;

    public function update(PostDTO $post): void;

    public function delete(string $id): void;

    public function findById(string $id): bool|array;
}