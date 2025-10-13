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
        $sql = "UPDATE comments SET content = :content WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'content' => $comments->getContent(),
            'id' => $comments->getId()
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM comments WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);
    }

    public function findById(int $id): bool|array
    {
        // TODO: Implement findById() method.
    }
}