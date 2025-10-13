<?php

namespace Repository;

use Contracts\CommentsRepositoryInterface;
use Models\CommentsDTO;
use PDO;

readonly class CommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function create(CommentsDTO $comments): void
    {
        $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (:user_id, :post_id, :content)";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $comments->getUserId(),
            'post_id' => $comments->getPostId(),
            'content' => $comments->getContent()
        ]);
    }

    public function update(CommentsDTO $comments): void
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(string $id): bool|array
    {
        // TODO: Implement findById() method.
    }
}