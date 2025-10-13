<?php

namespace Models;

use DateTimeImmutable;

class CommentsDTO
{
    private ?int $id;
    private string $content;
    private ?int $user_id;
    private ?int $post_id;
    private ?DateTimeImmutable $create_at;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->content = $data['content'];
        $this->user_id = $data['user_id']?? null;
        $this->post_id = $data['post_id']?? null;
        $this->create_at = $data['date'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPostId(): int
    {
        return $this->post_id;
    }

    public function getCreateAt(): ?DateTimeImmutable
    {
        return $this->create_at;
    }



}