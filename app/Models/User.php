<?php

namespace Models;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Random\RandomException;

class User
{
    private ?int $id = null; // ID interno (auto increment no banco)
    private string $uuid;    // UUID público
    private string $name;
    private string $email;
    private string $passwordHash;
    private string $token;

    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt = null;
    private bool $isActive = false;

    /**
     * @throws RandomException
     */
    public function __construct(string $name, string $email, string $password)
    {
        // 🔒 Gera o UUID e token de forma segura
        $this->uuid = Uuid::uuid4()->toString();
        $this->token = bin2hex(random_bytes(32));

        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->createdAt = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
