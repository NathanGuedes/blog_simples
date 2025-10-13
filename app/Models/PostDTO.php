<?php

namespace Models;

use DateTimeImmutable;

class PostDTO
{
    private ?int $id;
    private ?string $content;
    private ?string $image;
    private ?int $privacy;
    private int $user_id;
    private ?DateTimeImmutable $date;

    public function __construct(array $data, int $user_id, ?string $image)
    {
        $this->id = $data['id'] ?? null;
        $this->content = $data['content'];
        $this->image = $image ?? null;
        $this->privacy = $data['privacy'];
        $this->user_id = $user_id;
        $this->date = $data['date'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getPrivacy(): ?int
    {
        return $this->privacy;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }


}