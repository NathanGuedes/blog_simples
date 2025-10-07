<?php

namespace Services;

use Contracts\SessionInterface;
use Contracts\UserRepositoryInterface;
use Exceptions\ActiveValidationException;
use Exceptions\ValidationException;
use Validators\SessionFormValidator;

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
    public function session(array $formData): void
    {
        $error = SessionFormValidator::validate($formData);

        if (!empty($error)) {
            throw new ValidationException($error);
        }

        $user = $this->userRepository->findByEmail($formData['email']);

        if (!$user || !password_verify($formData['password'], $user['password'])) {
            throw new ValidationException('Email or password is incorrect');
        }

        $this->startSessionLogin($user);

        if ($user['active'] === 0) {
            throw new ActiveValidationException();
        }

    }

    /**
     * @param array $formData
     * @return void
     */
    public function startSessionLogin(array $formData): void
    {
        $this->sessionManager->set('user', [
            'email' => $formData['email'],
            'name' => $formData['name'],
            'active' => $formData['active']
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