<?php

namespace Models;

use DateTimeImmutable;

class UserDTO
{
    private ?int $id = null {
        get {
            return $this->id;
        }
    } // ID interno (auto increment no banco)
    private ?string $uuid {
        get {
            return $this->uuid;
        }
    }    // UUID público
    public string $name {
        get {
            return $this->name;
        }
    }
    public string $email {
        get {
            return $this->email;
        }
    }
    public ?string $password {
        get {
            return $this->password;
        }
    }
    private ?string $token {
        get {
            return $this->token;
        }
    }

    private ?DateTimeImmutable $createdAt {
        get {
            return $this->createdAt;
        }
    }
    private ?DateTimeImmutable $updatedAt {
        get {
            return $this->updatedAt;
        }
    }
    private ?int $active {
        get {
            return $this->active;
        }
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->uuid = $data['uuid'] ?? null;
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'] ?? null;
        $this->token = $data['token'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
        $this->updatedAt = $data['updatedAt'] ?? null;
        $this->active = $data['active'] ?? null;

    }

}
