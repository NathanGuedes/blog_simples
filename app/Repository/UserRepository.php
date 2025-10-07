<?php

namespace Repository;

use Contracts\UserRepositoryInterface;
use Models\User;
use PDO;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function create(User $user): void
    {
        $sql = "INSERT INTO users (name, email, password, token, token_validity, created_at) VALUES (:name, :email, :password, :token, :token_validity, :created_at)";

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "password" => $user->getPasswordHash(),
            "token" => $user->getToken(),
            "token_validity" => date('Y-m-d H:i:s', time() + 15 * 60),
            "created_at" => date('Y-m-d H:i:s')
        ]);


    }

    public function update(User $user): void
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(string $id): bool|array
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "id" => $id
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ?: false;
    }

    public function findByEmail(string $email): bool|array
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "email" => $email
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findByToken(string $token): bool|array
    {
        $sql = "SELECT * FROM users WHERE token = :token";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "token" => $token
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    public function updateToken(string $email, string $token): void
    {
        $sql = "UPDATE users SET token = :token, token_validity = :token_validity WHERE email = :email";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "token" => $token,
            "token_validity" => date('Y-m-d H:i:s', time() + 15 * 60),
            "email" => $email
        ]);
    }

    public function updatePasswordWithToke($token, $password): void
    {
        $sql = "UPDATE users SET password = :password, token = :token, token_validity = :token_validity WHERE token = :tokenVerify";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "password" => $password,
            "token" => null,
            "token_validity" => null,
            "tokenVerify" => $token
        ]);
    }
}