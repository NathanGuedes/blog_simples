<?php

namespace Services;

use Contracts\SessionInterface;
use Contracts\UserRepositoryInterface;
use Exceptions\ActiveValidationException;
use Exceptions\ValidationException;
use Utils\Validator;

class SessionService
{
    private UserRepositoryInterface $userRepository;
    private SessionInterface $sessionManager;

    public function __construct(UserRepositoryInterface $userRepository, SessionInterface $sessionManager)
    {
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @throws ValidationException
     * @throws ActiveValidationException
     */
    public function session(array $data): void
    {

        $validator = new Validator();
        $validator
            ->required('email', $data['email'] ?? null, 'Email')
            ->email('email', $data['email'] ?? null, 'Email')
            ->required('password', $data['password'] ?? null, 'Password');

        if ($validator->fails()) {
            throw new ValidationException($validator->getErrors());
        }

        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user['password'])) {
            throw new ValidationException('Email or password is incorrect');
        }

        $this->startSessionLogin($user);

        if ($user['active'] === 0) {
            throw new ActiveValidationException();
        }

    }

    /**
     * @param array $data
     * @return void
     */
    public function startSessionLogin(array $data): void
    {
        $this->sessionManager
            ->set(
                'user', ['user_id' => $data['id'], 'email' => $data['email'], 'name' => $data['name'], 'active' => $data['active']
            ]);

        $this->sessionManager->regenerate();
    }

    public function killSession(): void
    {
        $_SESSION = [];

        session_destroy();

        $params = session_get_cookie_params();

        setcookie("PHPSESSID", "", time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

    }
}