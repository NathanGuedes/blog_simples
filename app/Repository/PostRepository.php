<?php

namespace Repository;

use Contracts\PostRepositoryInterface;
use Models\PostDTO;
use PDO;

readonly class PostRepository implements PostRepositoryInterface
{

    public function __construct(private PDO $pdo)
    {
    }

    public function create(PostDTO $post): void
    {
        $sql = "INSERT INTO posts (content, image, privacy, user_id, date) VALUES (:content, :image, :privacy, :user_id, :date)";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "content" => $post->getContent(),
            "image" => $post->getImage() ?? null,
            "privacy" => $post->getPrivacy(),
            "user_id" => $post->getUserId(),
            "date" => date('Y-m-d H:i:s')
        ]);

    }

    public function update(PostDTO $post): void
    {
        $sql = "UPDATE posts SET content = :content, image = :image, privacy = :privacy WHERE id = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "content" => $post->getContent(),
            "image" => $post->getImage() ?? null,
            "privacy" => $post->getPrivacy(),
            "id" => $post->getId()
        ]);
    }

    public function updateWithoutImage(PostDTO $post): void
    {
        $sql = "UPDATE posts SET content = :content, privacy = :privacy WHERE id = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "content" => $post->getContent(),
            "privacy" => $post->getPrivacy(),
            "id" => $post->getId()
        ]);
    }

    public function delete(string $id): void
    {
        $sql = "DELETE FROM posts WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "id" => $id
        ]);
    }

    public function allPosts(int $privicy = 0): array
    {
        $sql = "SELECT posts.*, 
               users.name AS user_name, 
               TO_CHAR(posts.date, 'DD \"de\" TMMonth \"de\" YYYY \"às\" HH24:MI') AS date_formatado  
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE privacy = :privacy ORDER BY date DESC ";


        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "privacy" => $privicy
        ]);

        return $statement->fetchAll();
    }

    public function UserPosts(int $id, int $privacy): array
    {
        $sql = $privacy == 0 ? "SELECT posts.*, users.name AS user_name, TO_CHAR(posts.date, 'DD \"de\" TMMonth \"de\" YYYY \"às\" HH24:MI') AS date_formatado  
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE privacy = $privacy AND user_id = :user_id ORDER BY date DESC" :
            "SELECT posts.*, users.name AS user_name, TO_CHAR(posts.date, 'DD \"de\" TMMonth \"de\" YYYY \"às\" HH24:MI') AS date_formatado  
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE user_id = :user_id ORDER BY date DESC";


        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "user_id" => $id
        ]);

        return $statement->fetchAll();
    }

    public function onlyPost(int $id, $privacy = 0): array
    {
        $sql = "SELECT posts.*, users.name AS user_name,
               TO_CHAR(posts.date, 'DD \"de\" TMMonth \"de\" YYYY \"às\" HH24:MI') AS date_formatado  
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE privacy = :privacy and posts.id = :id ";


        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "privacy" => $privacy,
            "id" => $id
        ]);

        return $statement->fetchAll();
    }

    public function onlyPostProfile(int $id): array
    {
        $sql = "SELECT posts.*, users.name AS user_name,
               TO_CHAR(posts.date, 'DD \"de\" TMMonth \"de\" YYYY \"às\" HH24:MI') AS date_formatado  
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        WHERE posts.id = :id ";


        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "id" => $id
        ]);

        return $statement->fetchAll();
    }

    public function findById(string $id): bool|array
    {
        $sql = "SELECT * FROM posts where id = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "id" => $id
        ]);

        return $statement->fetch();
    }



    public function postComments(int $post_id): array
    {
        $sql = "SELECT c.id AS comment_id, c.content AS content, u.name AS user_name, u.id AS user_id,
                TO_CHAR(c.created_at, 'DD \"de\" TMMonth \"de\" YYYY \"às\" HH24:MI') AS date_formatado
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.post_id = :post_id
                ORDER BY c.created_at desc";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "post_id" => $post_id
        ]);

        return $statement->fetchAll();
    }
}