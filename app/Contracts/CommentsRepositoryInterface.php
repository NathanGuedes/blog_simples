<?php

namespace Contracts;


use Models\CommentsDTO;

interface CommentsRepositoryInterface
{
    public function create(CommentsDTO $comments): void;

    public function update(CommentsDTO $comments): void;

    public function delete(int $id): void;

    public function findById(int $id): bool|array;
}