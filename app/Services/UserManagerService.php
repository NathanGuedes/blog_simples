<?php

namespace Services;

use Contracts\EmailServiceInterface;
use Contracts\UserRepositoryInterface;
use DateMalformedStringException;
use DateTime;
use Exception;
use Exceptions\ActiveValidationException;
use Exceptions\InvalidTokenException;
use Exceptions\ValidationException;
use PDO;
use Random\RandomException;
use Support\Token;
use Validators\ForgotPasswordFormValidator;

readonly class UserManagerService
{
    public function __construct(private UserRepositoryInterface $userRepository,
                                private EmailServiceInterface   $emailService,
                                private PDO                     $pdo
    )
    {
    }

    public function sendEmail(string $uri, string $userEmail, string $userName, string $subject, string $token): void
    {

        $message = $_SERVER['HTTP_HOST'] . $uri . '/' . $token;

        $this->emailService->send($userEmail, $userName, $subject, $message);

    }


    /**
     * @throws RandomException
     */
    public function emailActiveSend(array $user): void
    {
        $token = Token::genToken();

        $this->userRepository->updateToken($user['email'], $token);

        $this->sendEmail('/email/activation', $user['email'], $user['name'], 'Ativação de conta', $token);
    }

    /**
     * @throws ActiveValidationException
     * @throws Exception
     */
    public function confirmEmail(string $token): void
    {
        $user = $this->userRepository->findByToken($token);

        if (!$user) {
            throw new InvalidTokenException();
        }

        $tokenValidity = new DateTime($user['token_validity']);
        $now = new DateTime();


        if ($now > $tokenValidity) {
            throw new ActiveValidationException([
                'name' => $user['name'],
                'email' => $user['email']
            ]);
        }

        $this->updateTokenAndActive($token);

    }

    public function updateTokenAndActive(string $token): void
    {
        $sql = "UPDATE users SET token = :token, token_validity = :token_validity, active = :active WHERE token = :tokenFind";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            "token" => null,
            "token_validity" => null,
            "active" => 1,
            "tokenFind" => $token
        ]);
    }

    /**
     * @throws RandomException
     */
    public function forgotPasswordSend(array $data): void
    {
        $token = Token::genToken();

        $this->userRepository->updateToken($data['email'], $token);

        $this->sendEmail('/forgot/password/email/recovery', $data['email'], $data['email'], 'Recuperacao de senha', $token);
    }

    /**
     * @throws ValidationException
     */
    public function updatePassword(array $formData): string
    {
        $error = ForgotPasswordFormValidator::validate($formData);

        if (!empty($error)) {
            throw new ValidationException($error);
        }

        $password = password_hash($formData['password'], PASSWORD_DEFAULT);
        $token = $formData['__token'];

        $user = $this->userRepository->findByToken($token);

        $this->userRepository->updatePasswordWithToke($token, $password);

        return $user['email'];
    }

    /**
     * @throws DateMalformedStringException
     * @throws InvalidTokenException
     */
    public function checkToken($token): void
    {
        $user = $this->userRepository->findByToken($token);

        if (!$user) {
            throw new InvalidTokenException();
        }

        $tokenValidity = $user['token_validity'] !== null ? new DateTime($user['token_validity']) : null;


        $now = new DateTime();


        if ($now > $tokenValidity) {
            throw new InvalidTokenException();
        }
    }

}