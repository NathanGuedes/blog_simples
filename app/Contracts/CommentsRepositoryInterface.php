<?php

namespace Contracts;


use Models\CommentsDTO;

interface CommentsRepositoryInterface
{
    public function create(CommentsDTO $comments): void;

    public function update(CommentsDTO $comments): void;

    public function delete(string $id): void;

    public function findById(string $id): bool|array;
}